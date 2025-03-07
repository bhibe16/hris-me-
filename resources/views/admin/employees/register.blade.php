<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="main-content min-h-screen flex flex-col">

    <!-- Navigation Bar -->
    @include('layouts.navigation')

    <div class="flex flex-grow">
        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Centered Card Container -->
        <div class="flex flex-grow justify-center items-center p-6">
            <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-lg">
                <h2 class="text-2xl font-bold text-center mb-4">Register</h2>

                <!-- Status Message -->
                @if(session('status'))
                    <div id="status-message" class="status-message mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('status') }}</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input id="name" class="block mt-1 w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-yellow-400 focus:border-yellow-400" 
                               type="text" name="name" value="{{ old('name') }}" required autofocus />
                        @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <!-- Email Address -->
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                        <input id="email" class="block mt-1 w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-yellow-400 focus:border-yellow-400" 
                               type="email" name="email" value="{{ old('email') }}" required />
                        @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input id="password" class="block mt-1 w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-yellow-400 focus:border-yellow-400" 
                               type="password" name="password" required />
                        @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-4">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                        <input id="password_confirmation" class="block mt-1 w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-yellow-400 focus:border-yellow-400" 
                               type="password" name="password_confirmation" required />
                        @error('password_confirmation') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <!-- Role Selection -->
                    <div class="mb-4">
                        <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                        <select id="role" name="role" class="block mt-1 w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-yellow-400 focus:border-yellow-400" required>
                            <option value="employee" {{ old('role') === 'employee' ? 'selected' : '' }}>Employee</option>
                        </select>
                        @error('role') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="flex items-center justify-center mt-4">
                        <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600 transition">
                            Register
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript for Smooth Transition -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const statusMessage = document.getElementById('status-message');
            if (statusMessage) {
                setTimeout(() => {
                    statusMessage.classList.add('show');
                }, 10); // Small delay to trigger the transition
            }
        });
    </script>
</body>
</html>