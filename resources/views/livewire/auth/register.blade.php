<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;

new
    #[Layout('components.layouts.auth')]
    #[Title('Register')]
    class extends Component
    {
        public string $name = '';
        public string $email = '';
        public string $password = '';
        public string $password_confirmation = '';

        /**
         * Handle an incoming registration request.
         */
        public function register(): void
        {
            $validated = $this->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
                'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            ]);

            $validated['password'] = Hash::make($validated['password']);

            event(new Registered(($user = User::create($validated))));

            Auth::login($user);

            $this->redirectIntended(route('dashboard', absolute: false), navigate: true);
        }
    };

?>

<div class="flex items-center justify-center">
    <x-card title="Register" subtitle="Please Insert Your Information" separator progress-indicator class="w-96">
        <x-form wire:submit="register" no-separator>
            <x-input label="Name" wire:model="name" />
            <x-input label="Email" wire:model="email" />
            <x-password label="Password" wire:model="password" clearable />
            <x-password label="Password Confirmation" wire:model="password_confirmation" clearable />

            <x-slot:actions>
                <x-button label="register" class="btn-primary" type="submit" spinner="register" />
            </x-slot:actions>
        </x-form>
    </x-card>
</div>