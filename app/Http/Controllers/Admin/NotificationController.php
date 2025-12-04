<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display a listing of notifications
     */
    public function index(Request $request)
    {
        $query = Notification::with('creator:id,name');

        // Filter by type
        if ($request->has('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }

        $notifications = $query->orderBy('created_at', 'desc')
            ->paginate($request->per_page ?? 20);

        return response()->json([
            'success' => true,
            'notifications' => $notifications
        ]);
    }

    /**
     * Store a newly created notification (broadcast)
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'type' => 'required|in:info,success,warning,error'
        ]);

        $notification = Notification::create([
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'created_by' => Auth::id(),
            'sent_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Notification broadcasted successfully',
            'notification' => $notification->load('creator:id,name')
        ], 201);
    }

    /**
     * Display the specified notification
     */
    public function show($id)
    {
        $notification = Notification::with('creator:id,name')->findOrFail($id);

        return response()->json([
            'success' => true,
            'notification' => $notification
        ]);
    }

    /**
     * Remove the specified notification
     */
    public function destroy($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->delete();

        return response()->json([
            'success' => true,
            'message' => 'Notification deleted successfully'
        ]);
    }

    /**
     * Get recent notifications for current user
     * Shows both broadcast notifications and personal targeted notifications
     */
    public function recent(Request $request)
    {
        $limit = $request->limit ?? 10;
        $userId = Auth::id();
        
        $notifications = Notification::forUser($userId)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();

        return response()->json([
            'success' => true,
            'notifications' => $notifications
        ]);
    }

    /**
     * Get unread notification count
     * Counts both broadcast and personal notifications
     */
    public function unreadCount()
    {
        $userId = Auth::id();
        
        // Count notifications from last 7 days that are visible to this user
        $count = Notification::forUser($userId)
            ->where('created_at', '>', now()->subDays(7))
            ->count();

        return response()->json([
            'success' => true,
            'count' => $count
        ]);
    }
}
