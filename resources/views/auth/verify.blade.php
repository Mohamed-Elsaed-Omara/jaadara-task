<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('our email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <div>
                <x-input-label for="code" :value="__('Verification Code')" />

                <x-text-input id="code" class="block mt-1 w-full"
                type="text"
                name="otp"
                required />

                <x-input-error :messages="$errors->get('otp')" class="mt-2" />
            </div>

            <div class="flex justify-end mt-4">
                <x-primary-button>
                    {{ __('Send Verification Code') }}
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('Log Out') }}
            </button>
        </form>
</x-guest-layout>
