<x-guest-layout>
    <div class="mb-4 text-sm text-secondary">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div class="mb-3">
            <x-input-label for="password" :value="__('Password')" />

            <input id="password" class="form-control mt-1"
                   type="password"
                   name="password"
                   required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger" />
        </div>

        <div class="d-flex justify-content-end mt-4">
            <button type="submit" class="btn btn-primary">
                {{ __('Confirm') }}
            </button>
        </div>
    </form>
</x-guest-layout>

