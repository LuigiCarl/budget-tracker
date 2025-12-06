<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('send-mail {email?}', function ($email = null) {
    $toEmail = $email ?? 'luigi.brezuela@sorsu.edu.ph';
    $fromAddress = config('mail.from.address', 'FinanEase@demomailtrap.co');
    $fromName = config('mail.from.name', 'FinanEase Budget Tracker SorSu-BC');
    
    $this->info("Sending test email...");
    $this->info("From: {$fromName} <{$fromAddress}>");
    $this->info("To: {$toEmail}");
    
    try {
        Mail::raw('Congrats for sending test email with Mailtrap! Your FinanEase Budget Tracker SorSu-BC email system is working.', function ($message) use ($toEmail, $fromAddress, $fromName) {
            $message->to($toEmail)
                ->subject('FinanEase Budget Tracker SorSu-BC - Test Email')
                ->from($fromAddress, $fromName);
        });
        
        $this->info("✓ Test email sent successfully!");
        $this->info("Check your Mailtrap inbox at https://mailtrap.io/inboxes");
    } catch (\Exception $e) {
        $this->error("✗ Failed to send email: " . $e->getMessage());
        $this->line("");
        $this->warn("Full error trace:");
        $this->line($e->getTraceAsString());
    }
})->purpose('Send test email via Mailtrap');
