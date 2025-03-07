<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- Profile Picture and Role Section -->
        <div class="flex items-start gap-6">
            <div class="flex flex-col items-start gap-4">
                @if ($user->profilePic)
                    <img src="{{ asset('storage/images/' . $user->profilePic) }}" alt="Profile" 
                         class="w-40 h-40 rounded-full border-4 border-gray-200 object-cover">
                @else
                    <img src="{{ asset('storage/images/default.png') }}" alt="Default Profile" 
                         class="w-40 h-40 rounded-full border-4 border-gray-200 object-cover">
                @endif

                <!-- Display User Role -->
                <p class="text-lg font-semibold text-gray-800">
                    {{ $user->role ?? 'No Role Assigned' }}
                </p>

                <div class="w-full text-left">
                    <x-input-label for="profilePic" :value="__('Change Profile Picture')" />
                    <input id="profilePic" name="profilePic" type="file" 
                           class="mt-1 block w-full text-sm text-gray-600
                                  file:mr-4 file:py-2 file:px-4
                                  file:rounded-full file:border-0
                                  file:text-sm file:font-semibold
                                  file:bg-gray-100 file:text-gray-700
                                  hover:file:bg-gray-200">
                    <x-input-error class="mt-2" :messages="$errors->get('profilePic')" />
                </div>
            </div>

            <!-- Name, Email, and Address Fields -->
            <div class="flex-1 space-y-6">
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" 
                                 :value="old('name', $user->name)" required autofocus autocomplete="name" />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" 
                                 :value="old('email', $user->email)" required autocomplete="username" />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                        <div class="mt-4">
                            <p class="text-sm text-gray-800">
                                {{ __('Your email address is unverified.') }}
                                <button form="send-verification" 
                                        class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    {{ __('Click here to re-send the verification email.') }}
                                </button>
                            </p>
                        </div>
                    @endif
                </div>

                <!-- Address Field -->
                <div>
                    <x-input-label for="address" :value="__('Address')" />
                    <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" 
                                 :value="old('address', $user->address)" required />
                    <x-input-error class="mt-2" :messages="$errors->get('address')" />
                </div>
            </div>
        </div>

        <!-- Save Button -->
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
            @if (session('status') === 'profile-updated')
                <p class="text-sm text-gray-600" x-data="{ show: true }" x-show="show" 
                   x-transition x-init="setTimeout(() => show = false, 2000)">
                    {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </form>
</section>
