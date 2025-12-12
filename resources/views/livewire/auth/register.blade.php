<x-layouts.auth>
    <div>
        <x-auth-header :title="__('Create an account')" :description="__('Enter your details below to create your account')" />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('register.store') }}">
            @csrf

            <!-- Name -->
            <div class="mb-3">
                <label for="name" class="form-label">{{ __('Name') }}</label>
                <input
                    type="text"
                    class="form-control @error('name') is-invalid @enderror"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    autofocus
                    autocomplete="name"
                    placeholder="{{ __('Full name') }}"
                >
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email Address -->
            <div class="mb-3">
                <label for="email" class="form-label">{{ __('Email address') }}</label>
                <input
                    type="email"
                    class="form-control @error('email') is-invalid @enderror"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autocomplete="email"
                    placeholder="email@example.com"
                >
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label">{{ __('Password') }}</label>
                <input
                    type="password"
                    class="form-control @error('password') is-invalid @enderror"
                    id="password"
                    name="password"
                    required
                    autocomplete="new-password"
                    placeholder="{{ __('Password') }}"
                >
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">{{ __('Confirm password') }}</label>
                <input
                    type="password"
                    class="form-control @error('password_confirmation') is-invalid @enderror"
                    id="password_confirmation"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    placeholder="{{ __('Confirm password') }}"
                >
                @error('password_confirmation')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary" data-test="register-user-button">
                    {{ __('Create account') }}
                </button>
            </div>
        </form>

        <div class="text-center mt-3 text-muted">
            <span>{{ __('Already have an account?') }}</span>
            <a href="{{ route('login') }}" class="text-decoration-none" wire:navigate>{{ __('Log in') }}</a>
        </div>
    </div>
</x-layouts.auth>
