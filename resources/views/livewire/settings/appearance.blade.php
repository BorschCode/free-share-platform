<?php

use Livewire\Volt\Component;

new class extends Component {
    public function layout(): string
    {
        return 'components.layouts.bootstrap';
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
                <a class="nav-link" href="{{ route('user-password.edit') }}">{{ __('Password') }}</a>
                @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                    <a class="nav-link" href="{{ route('two-factor.show') }}">{{ __('Two-Factor Auth') }}</a>
                @endif
                <a class="nav-link active" href="{{ route('appearance.edit') }}">{{ __('Appearance') }}</a>
            </div>
        </div>

        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">{{ __('Appearance') }}</h5>
                    <p class="text-muted small mb-0">{{ __('Update the appearance settings for your account') }}</p>
                </div>
                <div class="card-body">
                    <p class="text-muted">
                        {{ __('Theme selection is currently managed by your browser/system settings. The application will automatically adapt to your preferred color scheme (light or dark mode).') }}
                    </p>

                    <div class="alert alert-info">
                        <strong>{{ __('How to change theme:') }}</strong>
                        <ul class="mb-0 mt-2">
                            <li>{{ __('On Windows/Linux: Use your system dark mode settings') }}</li>
                            <li>{{ __('On macOS: System Preferences → General → Appearance') }}</li>
                            <li>{{ __('On mobile: Check your device settings for dark/light mode') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@layout('components.layouts.bootstrap')
