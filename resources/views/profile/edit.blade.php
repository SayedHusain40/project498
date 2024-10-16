@extends('new_layouts.app')

@section('title', 'Profile Page')

@section('content')
    <div class="container py-4">
        <div class="card p-4">
            <section>
                <header>
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Profile Information') }}
                    </h2>

                    <p class="mt-1 text-sm text-gray-600">
                        {{ __("Update your account's profile information and email address.") }}
                    </p>
                </header>

                <form method="post" action="{{ route('profile.update') }}" class="mt-4">
                    @csrf
                    @method('patch')

                    <div class="mb-3">
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" name="name" type="text" class="form-control" style="width: 300px;"
                            :value="old('name', $user->name)" required autofocus autocomplete="name" />
                        <x-input-error class="mt-2 text-danger" :messages="$errors->get('name')" />
                    </div>

                    <div class="mb-3">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" name="email" type="email" class="form-control"
                            style="width: 300px;" :value="old('email', $user->email)" required autocomplete="username" />
                        <x-input-error class="mt-2 text-danger" :messages="$errors->get('email')" />

                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                            <div>
                                <p class="text-sm mt-2 text-gray-800">
                                    {{ __('Your email address is unverified.') }}
                                    <button form="send-verification" class="btn btn-link">
                                        {{ __('Click here to re-send the verification email.') }}
                                    </button>
                                </p>

                                @if (session('status') === 'verification-link-sent')
                                    <p class="mt-2 text-success">
                                        {{ __('A new verification link has been sent to your email address.') }}
                                    </p>
                                @endif
                            </div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>

                        @if (session('status') === 'profile-updated')
                            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                                class="text-success">{{ __('Saved.') }}</p>
                        @endif
                    </div>
                </form>

            </section>
        </div>

        <div class="card p-4">
            <section>
                <header>
                    <h2 class="text-lg font-medium text-gray-900">
                        Your Academic Profile
                    </h2>

                </header>

<div class="container">
    <h2 class="text-lg font-medium text-gray-900"></h2>

    <div class="mt-4">
        <div class="mb-3">
            <strong style="font-size: 1.2rem;">Major:</strong>
            @if ($user->major)
                <span class="badge" style="font-size: 1rem; background-color: #ede7f6; color:rgb(0, 0, 0)">{{ $user->major->name }}</span>
            @else
                <span class="badge bg-secondary" style="font-size: 1rem;">Not specified</span>
            @endif
        </div>

        <div>
            <strong style="font-size: 1.2rem;">Expertise At:</strong>
            @if ($user->expertise->isNotEmpty())
                @foreach ($user->expertise as $course)
                    <span class="badge"
                        style="background-color: #e8f0fe; color: rgb(0, 0, 0); font-size: 1rem; padding: 0.5rem 1rem; margin-right: 0.5rem;border-radius: 20px; border-color:#e8f0fe;">
                        {{ $course->code }} | {{ $course->name }}
                    </span>
                @endforeach
            @else
                <span class="badge bg-secondary" style="font-size: 1rem;">Not specified</span>
            @endif
        </div>

        <div class="mt-3">
            <a href="{{ route('profile.info', $user->id) }}" class="btn btn-primary">Edit</a>
        </div>
    </div>
</div>


            </section>
        </div>

        <div class="card p-4 mt-4">
            <section>
                <header>
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Update Password') }}
                    </h2>

                    <p class="mt-1 text-sm text-gray-600">
                        {{ __('Ensure your account is using a long, random password to stay secure.') }}
                    </p>
                </header>

                <form method="post" action="{{ route('password.update') }}" class="mt-4">
                    @csrf
                    @method('put')

                    <div class="mb-3">
                        <x-input-label for="update_password_current_password" :value="__('Current Password')" />
                        <x-text-input id="update_password_current_password" name="current_password" type="password"
                            class="form-control" style="width: 300px;" autocomplete="current-password" />
                        <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-danger" />
                    </div>

                    <div class="mb-3">
                        <x-input-label for="update_password_password" :value="__('New Password')" />
                        <x-text-input id="update_password_password" name="password" type="password" class="form-control"
                            style="width: 300px;" autocomplete="new-password" />
                        <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-danger" />
                    </div>

                    <div class="mb-3">
                        <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" />
                        <x-text-input id="update_password_password_confirmation" name="password_confirmation"
                            type="password" class="form-control" style="width: 300px;" autocomplete="new-password" />
                        <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-danger" />
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>

                        @if (session('status') === 'password-updated')
                            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                                class="text-success">{{ __('Saved.') }}</p>
                        @endif
                    </div>
                </form>
            </section>
        </div>

        <div class="card p-4 mt-4">
            <section>
                <header>
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Delete Account') }}
                    </h2>

                    <p class="mt-1 text-sm text-gray-600">
                        {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
                    </p>
                </header>

                <form method="post" action="{{ route('profile.destroy') }}" class="mt-4">
                    @csrf
                    @method('delete')

                    <p class="text-sm text-gray-600 mb-4">
                        {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                    </p>

                    <div class="mb-3">
                        <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />
                        <x-text-input id="password" name="password" type="password" class="form-control"
                            style="width: 300px;" placeholder="{{ __('Password') }}" />
                        <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-danger" />
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-danger">{{ __('Delete Account') }}</button>
                    </div>
                </form>
            </section>
        </div>
    </div>
@endsection
