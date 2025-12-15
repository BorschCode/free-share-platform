<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component {
    public string $name = '';
    public string $email = '';

    public function layout(): string
    {
        return 'components.layouts.bootstrap';
    }

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user->id)
            ],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
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
                <a class="nav-link active" href="{{ route('profile.edit') }}">{{ __('Profile') }}</a>
                <a class="nav-link" href="{{ route('user-password.edit') }}">{{ __('Password') }}</a>
                @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                    <a class="nav-link" href="{{ route('two-factor.show') }}">{{ __('Two-Factor Auth') }}</a>
                @endif
                <a class="nav-link" href="{{ route('appearance.edit') }}">{{ __('Appearance') }}</a>
            </div>
        </div>

        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">{{ __('Profile') }}</h5>
                    <p class="text-muted small mb-0">{{ __('Update your name and email address') }}</p>
                </div>
                <div class="card-body">
                    <form wire:submit="updateProfileInformation">
                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('Name') }}</label>
                            <input
                                type="text"
                                class="form-control @error('name') is-invalid @enderror"
                                id="name"
                                wire:model="name"
                                required
                                autofocus
                                autocomplete="name"
                            >
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('Email') }}</label>
                            <input
                                type="email"
                                class="form-control @error('email') is-invalid @enderror"
                                id="email"
                                wire:model="email"
                                required
                                autocomplete="email"
                            >
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !auth()->user()->hasVerifiedEmail())
                                <div class="alert alert-warning mt-2">
                                    <p class="mb-2">{{ __('Your email address is unverified.') }}</p>
                                    <button type="button" class="btn btn-sm btn-outline-warning" wire:click.prevent="resendVerificationNotification">
                                        {{ __('Click here to re-send the verification email.') }}
                                    </button>

                                    @if (session('status') === 'verification-link-sent')
                                        <p class="text-success mt-2 mb-0">
                                            {{ __('A new verification link has been sent to your email address.') }}
                                        </p>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <div class="d-flex align-items-center gap-3">
                            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                            <span wire:loading wire:target="updateProfileInformation" class="text-muted">{{ __('Saving...') }}</span>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header bg-danger text-white">
                    <h5 class="card-title mb-0">{{ __('Delete Account') }}</h5>
                    <p class="small mb-0">{{ __('Delete your account and all of its resources') }}</p>
                </div>
                <div class="card-body">
                    <livewire:settings.delete-user-form />
                </div>
            </div>
        </div>
    </div>
</div>

@layout('components.layouts.bootstrap')
