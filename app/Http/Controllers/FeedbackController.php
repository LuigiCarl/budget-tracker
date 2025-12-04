<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    /**
     * Display a listing of feedback (admin only)
     */
    public function index(Request $request)
    {
        $query = Feedback::with('user:id,name,email');

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('subject', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $feedbacks = $query->orderBy('created_at', 'desc')
            ->paginate($request->per_page ?? 20);

        return response()->json([
            'success' => true,
            'feedbacks' => $feedbacks
        ]);
    }

    /**
     * Store a newly created feedback
     */
    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
            'rating' => 'required|integer|min:1|max:5'
        ]);

        $user = Auth::user();
        
        $feedback = Feedback::create([
            'user_id' => $user->id,
            'subject' => $request->subject,
            'message' => $request->message,
            'rating' => $request->rating,
            'status' => 'new'
        ]);

        // Create a notification for admins about new feedback
        Notification::create([
            'title' => 'New Feedback Received',
            'description' => "New feedback from {$user->name}: \"{$request->subject}\" (Rating: {$request->rating}/5)",
            'type' => 'info',
            'created_by' => $user->id,
            'sent_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Feedback submitted successfully',
            'feedback' => $feedback->load('user:id,name,email')
        ], 201);
    }

    /**
     * Display the specified feedback
     */
    public function show($id)
    {
        $feedback = Feedback::with('user:id,name,email')->findOrFail($id);

        return response()->json([
            'success' => true,
            'feedback' => $feedback
        ]);
    }

    /**
     * Update feedback status (admin only)
     * Notifies the user when their feedback is reviewed or resolved
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:new,reviewed,resolved'
        ]);

        $feedback = Feedback::with('user')->findOrFail($id);
        $oldStatus = $feedback->status;
        $newStatus = $request->status;
        
        $feedback->update([
            'status' => $newStatus,
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now()
        ]);

        // Notify the user about their feedback status change
        if ($oldStatus !== $newStatus && $feedback->user) {
            $statusMessages = [
                'reviewed' => [
                    'title' => 'Feedback Under Review',
                    'description' => "Your feedback \"{$feedback->subject}\" is being reviewed by our team.",
                    'type' => 'info'
                ],
                'resolved' => [
                    'title' => 'Feedback Resolved',
                    'description' => "Your feedback \"{$feedback->subject}\" has been resolved. Thank you for helping us improve!",
                    'type' => 'success'
                ]
            ];

            if (isset($statusMessages[$newStatus])) {
                // Create a personal notification for the user
                \App\Models\Notification::create([
                    'title' => $statusMessages[$newStatus]['title'],
                    'description' => $statusMessages[$newStatus]['description'],
                    'type' => $statusMessages[$newStatus]['type'],
                    'created_by' => Auth::id(),
                    'user_id' => $feedback->user_id, // Target specific user
                    'sent_at' => now()
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Feedback status updated successfully',
            'feedback' => $feedback->load('user:id,name,email')
        ]);
    }

    /**
     * Remove the specified feedback (admin only)
     */
    public function destroy($id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->delete();

        return response()->json([
            'success' => true,
            'message' => 'Feedback deleted successfully'
        ]);
    }

    /**
     * Get user's own feedbacks
     */
    public function myFeedback()
    {
        $feedbacks = Feedback::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'feedbacks' => $feedbacks
        ]);
    }
}
