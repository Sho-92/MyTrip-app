<x-guest-layout>
    <div class="mb-4 text-sm text-secondary">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-3">
            <x-input-label for="email" :value="__('Email')" />
            <input id="email" class="form-control mt-1" type="email" name="email" value="{{ old('email') }}" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger" />
        </div>

        <div class="d-flex justify-content-center mt-4">
            <button type="submit" class="btn btn-primary">
                {{ __('Email Password Reset Link') }}
            </button>
        </div>
    </form>

    <div class="d-flex justify-content-center mt-4">
        <button type="button" class="btn btn-secondary mx-2" onclick="window.history.back()">
            <i class="bi bi-arrow-left-circle" style="margin-right: 5px;"></i>back
        </button>
    </div>
</x-guest-layout>
