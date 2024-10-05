<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="bg-light p-4 rounded shadow">
        @csrf

        <h2 class="text-center mb-4" style="font-size: 2rem; font-weight: 600;">Login</h2>

        <!-- Email Address -->
        <div class="mb-3 text-center">
            <input id="email" class="form-control d-inline-block w-75 mx-auto" type="email" name="email" :value="old('email')" required autofocus placeholder="Email" autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger" />
        </div>

        <!-- Password -->
        <div class="mb-3 text-center">
            <input id="password" class="form-control d-inline-block w-75 mx-auto" type="password" name="password" required placeholder="Password" autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger" />
        </div>

        <!-- Remember Me -->
        <div class="form-check mb-3 d-flex align-items-center justify-content-center">
            <input id="remember_me" type="checkbox" class="form-check-input me-2" name="remember">
            <label for="remember_me" class="form-check-label">{{ __('Remember me') }}</label>
        </div>

        <div class="d-flex justify-content-center mb-4">
            <button type="submit" class="btn btn-primary me-2">
                {{ __('Log in') }}
            </button>

            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="btn btn-secondary">
                    {{ __("Register") }}
                </a>
            @endif
        </div>

    </form>

    <!-- Guest Login Button -->
    <div class="text-center mt-4">
        <form method="POST" action="{{ route('guest.login') }}">
            @csrf
            <button type="submit" class="btn btn-outline-primary">
                {{ __("Guest Login") }}
            </button>
        </form>
    </div>

    <div class="text-end mt-4">
        @if (Route::has('password.request'))
        <div>
            <a class="text-decoration-underline" href="{{ route('password.request') }}">
                {{ __('Forgot your password?' ) }}
            </a>
        </div>
        @endif
    </div>
</x-guest-layout>

