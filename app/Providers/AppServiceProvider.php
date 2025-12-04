<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Mail;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use App\Mail\MailtrapApiTransport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS in production
        if (config('app.env') === 'production' || config('app.force_https')) {
            URL::forceScheme('https');
        }
        
        // Configure API rate limiters for security
        $this->configureRateLimiting();
        
        // Register Mailtrap API transport
        Mail::extend('mailtrap', function () {
            return new MailtrapApiTransport();
        });
    }
    
    /**
     * Configure rate limiting for API endpoints
     */
    protected function configureRateLimiting(): void
    {
        // General API rate limit - 120 requests per minute per user/IP
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(120)->by($request->user()?->id ?: $request->ip());
        });
        
        // Strict rate limit for authentication endpoints - 10 per minute per IP
        RateLimiter::for('auth', function (Request $request) {
            return Limit::perMinute(10)->by($request->ip());
        });
    }
}
