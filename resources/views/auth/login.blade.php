<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
        }
        .image-container {
            flex: 0.6;
            height: 100%;
            background: url('{{ asset('images/training.gif') }}') no-repeat center;
            background-size: 60%;
            background-position: center;
        }
        .login-box {
            flex: 1;
            max-width: 400px;
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: left;
            margin-right: 5%;
        }
        .login-box h2 {
            margin-bottom: 1.5rem;
            color: #333;
            font-size: 1.5rem;
        }
        .logo {
            display: block;
            margin: 0 auto 1.5rem auto;
            max-width: 100px;
        }
    </style>
</head>
<body>
    <div class="image-container"></div>
    <div class="login-box">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo">

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Custom Error Messages -->
        @if (session('error'))
            <div class="mb-4 text-center text-red-600 bg-red-100 p-4 rounded-md">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->has('role'))
            <div class="mb-4 text-center text-red-600 bg-red-100 p-4 rounded-md">
                {{ $errors->first('role') }}
            </div>
        @endif

        @if(request()->has('session_expired'))
            <p class="text-red-500 text-center">You were logged out due to inactivity.</p>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full border border-gray-300 rounded-md shadow-sm" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full border border-gray-300 rounded-md shadow-sm"
                    type="password"
                    name="password"
                    required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4 text-left">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <!-- Forgot Password Link -->
            <div class="flex items-center justify-between mt-4">
                @if (Route::has('password.request'))
                    <a class="text-sm text-indigo-600 hover:underline" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>

            <!-- Login Button -->
            <div class="flex items-center justify-end mt-4">
                <button type="submit" class="w-full py-2 px-4 bg-orange-600 hover:bg-orange-700 text-white font-semibold rounded-md shadow-md transition">
                    {{ __('Log in') }}
                </button>
            </div>
        </form>
    </div>
</body>
</html>
