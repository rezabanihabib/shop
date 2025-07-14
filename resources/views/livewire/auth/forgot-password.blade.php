<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Mary\Traits\Toast;

new #[Layout('components.layouts.auth')] class extends Component 
{
    use Toast;

    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        Password::sendResetLink($this->only('email'));

        $this->success('A reset link will be sent if the account exists.');
    }
};
?>

<div class="flex items-center justify-center">
    <x-card title="Forgot Password" subtitle="Please Insert Your Email Information" separator progress-indicator class="w-96">
        <x-form wire:submit="sendPasswordResetLink">
            <x-input label="Email" wire:model="email" />
            <x-slot:actions>
                <x-button label="login" class="btn-primary btn-outline me-auto" link="{{ route('login') }}" />
                <x-button label="Submit" class="btn-primary" type="submit" spinner="sendPasswordResetLink" />
            </x-slot:actions>
        </x-form>
    </x-card>
</div>