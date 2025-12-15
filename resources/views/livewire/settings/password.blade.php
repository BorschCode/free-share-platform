<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Volt\Component;

new class extends Component {
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function layout(): string
    {
        return 'components.layouts.bootstrap';
    }

    /**
     * Update the password for the currently authenticated user.
     */
    public function updatePassword(): void
    {
        try {
            $validated = $this->validate([
                'current_password' => ['required', 'string', 'current_password'],
                'password' => ['required', 'string', Password::defaults(), 'confirmed'],
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw $e;
        }

        Auth::user()->update([
            'password' => $validated['password'],
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->dispatch('password-updated');
    }
}; ?>

<div>
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="mb-1">{{ __('Settings') }}</h1>
            <p class="text-muted mb-0">{{ __('Manage your profile and account settings') }}</p>
        </div>
    </div>
    <hr>

    <div class="row mt-4">
        <div class="col-md-3">
            <div class="nav flex-column nav-pills" role="tablist">
                <a class="nav-link" href="{{ route('profile.edit') }}">{{ __('Profile') }}</a>
                <a class="nav-link active" href="{{ route('user-password.edit') }}">{{ __('Password') }}</a>
                @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                    <a class="nav-link" href="{{ route('two-factor.show') }}">{{ __('Two-Factor Auth') }}</a>
                @endif
                <a class="nav-link" href="{{ route('appearance.edit') }}">{{ __('Appearance') }}</a>
            </div>
        </div>

        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">{{ __('Update Password') }}</h5>
                    <p class="text-muted small mb-0">{{ __('Ensure your account is using a long, random password to stay secure') }}</p>
                </div>
                <div class="card-body">
                    <form wire:submit="updatePassword">
                        <div class="mb-3">
                            <label for="current_password" class="form-label">{{ __('Current Password') }}</label>
                            <input
                                type="password"
                                class="form-control @error('current_password') is-invalid @enderror"
                                id="current_password"
                                wire:model="current_password"
                                required
                                autocomplete="current-password"
                            >
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('New Password') }}</label>
                            <input
                                type="password"
                                class="form-control @error('password') is-invalid @enderror"
                                id="password"
                                wire:model="password"
                                required
                                autocomplete="new-password"
                            >
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                            <input
                                type="password"
                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                id="password_confirmation"
                                wire:model="password_confirmation"
                                required
                                autocomplete="new-password"
                            >
                            @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex align-items-center gap-3">
                            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                            <span wire:loading wire:target="updatePassword" class="text-muted">{{ __('Saving...') }}</span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@layout('components.layouts.bootstrap')
