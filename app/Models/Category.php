<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'type',
        'description',
        'color',
        'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    /**
     * Get the user that owns the category.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the transactions for the category.
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Get the budgets for the category.
     */
    public function budgets(): HasMany
    {
        return $this->hasMany(Budget::class);
    }

    /**
     * Get the active budget for this category.
     */
    public function getActiveBudgetAttribute()
    {
        $today = now()->toDateString();
        
        return $this->budgets()
            ->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->first();
    }

    /**
     * Get the category type options.
     */
    public static function getTypeOptions(): array
    {
        return [
            'income' => 'Income',
            'expense' => 'Expense',
        ];
    }

    /**
     * Check if this category has an active limiting budget.
     */
    public function hasActiveLimitingBudget()
    {
        return $this->active_budget && $this->active_budget->is_limiter;
    }

    /**
     * Get the budget status for this category.
     */
    public function getBudgetStatus()
    {
        $budget = $this->active_budget;
        
        if (!$budget) {
            return [
                'has_budget' => false,
                'is_limiter' => false,
                'remaining' => null,
                'is_exceeded' => false,
                'overspending' => 0,
            ];
        }

        return [
            'has_budget' => true,
            'is_limiter' => $budget->is_limiter,
            'remaining' => $budget->remaining_amount,
            'is_exceeded' => $budget->is_exceeded,
            'overspending' => $budget->overspending_amount,
            'budget_amount' => $budget->amount,
            'spent_amount' => $budget->spent_amount,
        ];
    }

    /**
     * Get the default category for a specific type and user.
     */
    public static function getDefaultForUser($userId, $type = 'expense')
    {
        return static::where('user_id', $userId)
                     ->where('type', $type)
                     ->where('is_default', true)
                     ->first();
    }

    /**
     * Set this category as the default for its type, unsetting any other default categories.
     */
    public function setAsDefault()
    {
        // Remove default status from other categories of the same type for this user
        static::where('user_id', $this->user_id)
              ->where('type', $this->type)
              ->where('id', '!=', $this->id)
              ->update(['is_default' => false]);
        
        // Set this category as default
        $this->update(['is_default' => true]);
    }
}
