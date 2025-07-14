<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Mary\Traits\Toast;

new #[Layout('components.layouts.auth')] class extends Component
{
    use Toast;

    public string $password = '';

    /**
     * Confirm the current user's password.
     */
    public function confirmPassword(): void
    {
        $this->validate([
            'password' => ['required', 'string'],
        ]);

        if (! Auth::guard('web')->validate([
            'email' => Auth::user()->email,
            'password' => $this->password,
        ])) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        session(['auth.password_confirmed_at' => time()]);

        $this->redirectIntended(default: route('dashboard.index', absolute: false), navigate: true);
    }
};
?>

<div class="flex items-center justify-center">
    <x-card title="Comfirm Password" subtitle="Please Insert Your Password" separator progress-indicator class="w-96">
        <x-form wire:submit="confirmPassword">
            <x-password label="Password" wire:model="password" clearable />
            <x-slot:actions>
                <x-button label="Submit" class="btn-primary" type="submit" spinner="resetPassword" />
            </x-slot:actions>
        </x-form>
    </x-card>
</div>