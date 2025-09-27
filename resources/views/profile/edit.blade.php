@extends('layouts.base')

@section('title', 'Profile - ' . config('app.name'))
@section('app-name', 'Profile Settings')

@section('content')
    <!-- Hero Section -->
    <div class="space-y-2 mb-8">
        <h1 class="scroll-m-20 text-4xl font-extrabold tracking-tight lg:text-5xl">
            Profile Settings
        </h1>
        <p class="text-xl text-muted-foreground">
            Manage your account information and security settings.
        </p>
    </div>

    <div class="max-w-4xl space-y-6">
        <!-- Update Profile Information -->
        <x-ui.card title="Profile Information" description="Update your account's profile information and email address.">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </x-ui.card>

        <!-- Update Password -->
        <x-ui.card title="Update Password" description="Ensure your account is using a long, random password to stay secure.">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </x-ui.card>

        <!-- Delete Account -->
        <x-ui.card title="Delete Account" description="Once your account is deleted, all of its resources and data will be permanently deleted.">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </x-ui.card>
    </div>
@endsection
