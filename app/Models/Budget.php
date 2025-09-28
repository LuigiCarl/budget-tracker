<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Budget extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'amount',
        'start_date',
        'end_date',
        'name',
        'description',
        'is_limiter',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'is_limiter' => 'boolean',
    ];

    /**
     * Get the user that owns the budget.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the category that owns the budget.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the spent amount for this budget.
     */
    public function getSpentAmountAttribute()
    {
        return $this->category->transactions()
            ->where('type', 'expense')
            ->whereBetween('date', [$this->start_date, $this->end_date])
            ->sum('amount');
    }

    /**
     * Get the remaining amount for this budget.
     */
    public function getRemainingAmountAttribute()
    {
        return $this->amount - $this->spent_amount;
    }

    /**
     * Get the percentage used of this budget.
     */
    public function getPercentageUsedAttribute()
    {
        if ($this->amount <= 0) {
            return 0;
        }

        return min(($this->spent_amount / $this->amount) * 100, 100);
    }

    /**
     * Check if the budget is exceeded.
     */
    public function getIsExceededAttribute()
    {
        return $this->spent_amount > $this->amount;
    }

    /**
     * Check if adding an amount would exceed the budget.
     */
    public function wouldExceedWith($amount)
    {
        return ($this->spent_amount + $amount) > $this->amount;
    }

    /**
     * Get the overspending amount (positive if over budget).
     */
    public function getOverspendingAmountAttribute()
    {
        return max(0, $this->spent_amount - $this->amount);
    }

    /**
     * Check if this budget acts as a spending limiter.
     */
    public function shouldPreventSpending()
    {
        return $this->is_limiter && $this->is_exceeded;
    }
}
