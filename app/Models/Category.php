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
}
