<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Terms and Conditions -->
        <div class="mt-4">
            <label for="terms" class="inline-flex items-center">
                <input id="terms" type="checkbox" name="terms"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" required>
                <span class="ml-3 text-sm text-gray-600">
                    {!! __('I agree to the :terms_of_service and :privacy_policy', [
                        'terms_of_service' =>
                            '<a href="' .
                            route('terms') .
                            '" target="_blank" class="underline text-sm text-gray-600 hover:text-gray-900">' .
                            __('Terms of Service') .
                            '</a>',
                        'privacy_policy' =>
                            '<a href="' .
                            route('privacy') .
                            '" target="_blank" class="underline text-sm text-gray-600 hover:text-gray-900">' .
                            __('Privacy Policy') .
                            '</a>',
                    ]) !!}
                </span>
            </label>
            <x-input-error :messages="$errors->get('terms')" class="mt-2" />
        </div>


        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
