<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

/**
 * API Caching Trait
 * 
 * Provides consistent caching across all API controllers.
 * 
 * Cache Strategy:
 * - User-specific caches: Use user ID in cache key
 * - TTL: 5 minutes for frequently changing data, 15 minutes for stable data
 * - Tags: Group related caches for easy invalidation
 * - Automatic invalidation: Clear caches on create/update/delete
 */
trait CachesApiResponses
{
    /**
     * Default cache TTL in seconds
     */
    protected int $defaultCacheTtl = 300; // 5 minutes
    
    /**
     * Long cache TTL for rarely changing data
     */
    protected int $longCacheTtl = 900; // 15 minutes
    
    /**
     * Short cache TTL for frequently changing data
     */
    protected int $shortCacheTtl = 60; // 1 minute

    /**
     * Generate a user-specific cache key
     */
    protected function userCacheKey(string $key, array $params = []): string
    {
        $userId = Auth::id();
        $paramString = $params ? ':' . md5(serialize($params)) : '';
        return "user:{$userId}:{$key}{$paramString}";
    }

    /**
     * Get cached data or execute callback and cache result
     */
    protected function cachedResponse(string $key, callable $callback, int $ttl = null, array $params = []): mixed
    {
        $cacheKey = $this->userCacheKey($key, $params);
        $ttl = $ttl ?? $this->defaultCacheTtl;
        
        return Cache::remember($cacheKey, $ttl, $callback);
    }

    /**
     * Clear user-specific cache
     */
    protected function clearUserCache(string $key): void
    {
        Cache::forget($this->userCacheKey($key));
    }

    /**
     * Clear multiple user caches by pattern
     */
    protected function clearUserCaches(array $keys): void
    {
        foreach ($keys as $key) {
            $this->clearUserCache($key);
        }
    }

    /**
     * Clear all caches for the current user
     * Note: This requires cache driver that supports tags (Redis, Memcached)
     * For file/database driver, we clear specific known keys
     */
    protected function clearAllUserCaches(): void
    {
        $cacheKeys = [
            'dashboard:stats',
            'dashboard:recent-transactions',
            'dashboard:monthly-analytics',
            'dashboard:budget-progress',
            'transactions:list',
            'transactions:all',
            'budgets:list',
            'budgets:all',
            'categories:list',
            'categories:all',
            'accounts:list',
            'accounts:all',
        ];

        foreach ($cacheKeys as $key) {
            $this->clearUserCache($key);
        }
    }

    /**
     * Clear transaction-related caches
     * Called after transaction create/update/delete
     */
    protected function clearTransactionCaches(): void
    {
        $this->clearUserCaches([
            'dashboard:stats',
            'dashboard:recent-transactions',
            'dashboard:monthly-analytics',
            'dashboard:budget-progress',
            'transactions:list',
            'transactions:all',
            'accounts:list', // Account balances change with transactions
        ]);
    }

    /**
     * Clear budget-related caches
     */
    protected function clearBudgetCaches(): void
    {
        $this->clearUserCaches([
            'dashboard:budget-progress',
            'budgets:list',
            'budgets:all',
        ]);
    }

    /**
     * Clear category-related caches
     */
    protected function clearCategoryCaches(): void
    {
        $this->clearUserCaches([
            'dashboard:stats',
            'dashboard:budget-progress',
            'categories:list',
            'categories:all',
        ]);
    }

    /**
     * Clear account-related caches
     */
    protected function clearAccountCaches(): void
    {
        $this->clearUserCaches([
            'dashboard:stats',
            'accounts:list',
            'accounts:all',
        ]);
    }
}
