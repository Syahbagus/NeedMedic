<x-guest-layout>
    <div class="text-center mb-6">
        <h2 class="text-white text-2xl font-bold border-2 border-gray-400 py-2 px-6 inline-block">
            FORM REGISTRASI
        </h2>
    </div>
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

        <!-- Date of Birth -->
        <div class="grid grid-cols-2 gap-4 mt-4">
            <div>
                <x-input-label for="date_of_birth" :value="__('Date of birth')" />
                <x-text-input id="date_of_birth" class="block mt-1 w-full" type="date" name="date_of_birth"
                    :value="old('date_of_birth')" />
                <x-input-error :messages="$errors->get('date_of_birth')" class="mt-2" />
            </div>

            <!-- Gender -->
            <div>
                <x-input-label for="gender" :value="__('Gender')" />
                <div class="flex items-center mt-2 space-x-4">
                    <label class="inline-flex items-center">
                        <input type="radio" name="gender" value="male" class="rounded-full">
                        <span class="ms-2">Male</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="gender" value="female" class="rounded-full">
                        <span class="ms-2">Female</span>
                    </label>
                </div>
                <x-input-error :messages="$errors->get('gender')" class="mt-2" />
            </div>
        </div>

        <!-- Address -->
        <div class="mt-4">
            <x-input-label for="address" :value="__('Address')" />
            <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')" />
            <x-input-error :messages="$errors->get('address')" class="mt-2" />
        </div>

        <!-- City -->
        <div class="grid grid-cols-2 gap-4 mt-4">
            <div>
                <x-input-label for="city" :value="__('City')" />
                <x-text-input id="city" class="block mt-1 w-full" type="text" name="city"
                    :value="old('city')" />
                <x-input-error :messages="$errors->get('city')" class="mt-2" />
            </div>

            <!-- Contact Number -->
            <div>
                <x-input-label for="contact_no" :value="__('Contact no')" />
                <x-text-input id="contact_no" class="block mt-1 w-full" type="text" name="contact_no"
                    :value="old('contact_no')" />
                <x-input-error :messages="$errors->get('contact_no')" class="mt-2" />
            </div>
        </div>

        <!-- PayPal ID -->
        <div class="mt-4">
            <x-input-label for="paypal_id" :value="__('Pay-pal id')" />
            <x-text-input id="paypal_id" class="block mt-1 w-full" type="text" name="paypal_id" :value="old('paypal_id')" />
            <x-input-error :messages="$errors->get('paypal_id')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
