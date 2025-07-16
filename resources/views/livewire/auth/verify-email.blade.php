<?php

use App\Http\Controllers\Auth\LogoutController;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Mary\Traits\Toast;

new #[Layout('components.layouts.auth')] class extends Component {
    use Toast;
    /**
     * Send an email verification notification to the user.
     */
    public function sendVerification(): void
    {
        if (Auth::user()->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard.index', absolute: false), navigate: true);
            return;
        }
        Auth::user()->sendEmailVerificationNotification();
        $this->success('Verification Link Sent');
    }

    /**
     * Log the current user out of the application.
     */
    public function logout(LogoutController $logout): void
    {
        $logout();
        $this->redirect('/', navigate: true);
    }
}; ?>

<div class="flex items-center justify-center">
    <x-card title="Verify Email" subtitle="Please Verify Your Email" separator progress-indicator class="w-96">
        <x-button label="Send Link" wire:click="sendVerification" spinner="sendVerification" class="btn-primary" />
        <x-button label="logout" wire:click="logout" spinner="logout" class="btn-primary" />
    </x-card>
</div>
