<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SanitizeInput
{
    /**
     * Fields that should be sanitized (strip HTML tags)
     */
    protected array $sanitizeFields = [
        'name',
        'description',
        'notes',
        'subject',
        'message',
        'search',
    ];

    /**
     * Fields that should never be modified
     */
    protected array $excludeFields = [
        'password',
        'password_confirmation',
        'current_password',
        'email',
        'token',
    ];

    /**
     * Handle an incoming request.
     * Sanitizes string inputs to prevent XSS attacks.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $input = $request->all();
        
        array_walk_recursive($input, function (&$value, $key) {
            // Skip excluded fields
            if (in_array($key, $this->excludeFields)) {
                return;
            }
            
            // Only process strings
            if (!is_string($value)) {
                return;
            }
            
            // Strip HTML tags from sanitizable fields
            if (in_array($key, $this->sanitizeFields)) {
                $value = strip_tags($value);
            }
            
            // Always trim whitespace
            $value = trim($value);
            
            // Remove null bytes (security)
            $value = str_replace(chr(0), '', $value);
        });
        
        $request->merge($input);
        
        return $next($request);
    }
}
