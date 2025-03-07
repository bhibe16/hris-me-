<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="logout-url" content="{{ route('logout') }}">
    <title>Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="main-content">
    <!-- Navigation Bar -->
    @include('layouts.navigation')

    <!-- Flex container to hold sidebar and main content -->
    <div class="flex min-h-screen">
        <!-- Sidebar with fixed width, stretching to match main content height -->
        
            @include('layouts.sidebar')
        

        <!-- Main Content -->
        <div class="flex-1 p-6">
            <div class="bg-gradient-to-r from-yellow-100 via-yellow-200 to-yellow-300 p-10 rounded-lg shadow-lg mb-6 w-full max-w-2xl text-center">
                <h2 class="text-4xl font-bold text-black">
                    @if(auth()->user()->role == 'admin')
                        Welcome {{ auth()->user()->name }}!
                    @else
                        Welcome {{ auth()->user()->name }}!
                    @endif
                </h2>
            </div>
        </div>
    </div>
</body>
</html>
