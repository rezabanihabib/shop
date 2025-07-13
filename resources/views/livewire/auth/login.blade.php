<?php

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new
    #[Layout('components.layouts.auth')]
    #[Title('Login')]
    class extends Component
    {
        #[Validate('required|string|email')]
        public string $email = '';

        #[Validate('required|string')]
        public string $password = '';

        public bool $remember = false;

        /**
         * Handle an incoming authentication request.
         */
        public function login(): void
        {
            $this->validate();

            $this->ensureIsNotRateLimited();

            if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
                RateLimiter::hit($this->throttleKey());

                throw ValidationException::withMessages([
                    'email' => __('auth.failed'),
                ]);
            }

            RateLimiter::clear($this->throttleKey());
            Session::regenerate();

            $this->redirectIntended(default: route('home', absolute: false), navigate: true);
        }

        /**
         * Ensure the authentication request is not rate limited.
         */
        protected function ensureIsNotRateLimited(): void
        {
            if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
                return;
            }

            event(new Lockout(request()));

            $seconds = RateLimiter::availableIn($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.throttle', [
                    'seconds' => $seconds,
                    'minutes' => ceil($seconds / 60),
                ]),
            ]);
        }

        /**
         * Get the authentication rate limiting throttle key.
         */
        protected function throttleKey(): string
        {
            return Str::transliterate(Str::lower($this->email) . '|' . request()->ip());
        }
    };

?>

<div class="flex items-center justify-center">
    <x-card title="Login" subtitle="Please Insert Your Login Information" separator progress-indicator class="w-96">
        <x-form wire:submit="login">
            <x-input label="Email" wire:model="email" />
            <x-password label="Password" wire:model="password" clearable />
            <x-menu-item title="Forgot Password?" link="{{ route('password.request') }}"  class="link"/>
            <x-toggle label="Remember Me" wire:model="remember" right />

            <x-slot:actions>
                <x-button label="register" class="btn-primary btn-outline me-auto" link="{{ route('register') }}" />
                <x-button label="Cancel" />
                <x-button label="login" class="btn-primary" type="submit" spinner="login" />
            </x-slot:actions>
        </x-form>
    </x-card>
</div>