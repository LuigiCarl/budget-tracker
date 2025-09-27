<section>
    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <div class="space-y-2">
            <label for="update_password_current_password" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                {{ __('Current Password') }}
            </label>
            <input id="update_password_current_password" name="current_password" type="password" 
                   class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" 
                   autocomplete="current-password" />
            @if($errors->updatePassword->get('current_password'))
                <p class="text-sm text-destructive">{{ implode(', ', $errors->updatePassword->get('current_password')) }}</p>
            @endif
        </div>

        <div class="space-y-2">
            <label for="update_password_password" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                {{ __('New Password') }}
            </label>
            <input id="update_password_password" name="password" type="password" 
                   class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" 
                   autocomplete="new-password" />
            @if($errors->updatePassword->get('password'))
                <p class="text-sm text-destructive">{{ implode(', ', $errors->updatePassword->get('password')) }}</p>
            @endif
        </div>

        <div class="space-y-2">
            <label for="update_password_password_confirmation" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                {{ __('Confirm Password') }}
            </label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" 
                   class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" 
                   autocomplete="new-password" />
            @if($errors->updatePassword->get('password_confirmation'))
                <p class="text-sm text-destructive">{{ implode(', ', $errors->updatePassword->get('password_confirmation')) }}</p>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-ui.button type="submit">{{ __('Update Password') }}</x-ui.button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" 
                   class="text-sm text-green-600 dark:text-green-400 font-medium">
                    {{ __('Password updated successfully!') }}
                </p>
            @endif
        </div>
    </form>
</section>
