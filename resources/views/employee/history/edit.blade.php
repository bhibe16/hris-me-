<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="logout-url" content="{{ route('logout') }}">
    <title>Edit Employee Record</title>
    <!-- Import Roboto font from Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="main-content text-gray-100 min-h-screen font-roboto">
    <!-- Navigation Bar -->
    @include('layouts.navigation')

    <!-- Flex container to hold sidebar and main content -->
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        
            @include('layouts.sidebar')
        

        <!-- Main Content -->
        <main class="flex-grow p-8">
            <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg p-8 text-gray-900">
                <h1 class="text-2xl font-bold mb-6">Edit Employee History</h1>

                <!-- Display Validation Errors -->
                @if ($errors->any())
                    <div class="bg-red-500 text-white p-4 rounded mb-6">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Form to edit employee history -->
                <form action="{{ route('employee.history.update', $record->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Grid Form Layout -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- Company Name -->
                        <div>
                            <label for="company_name" class="block text-sm font-medium text-gray-700">Company Name</label>
                            <input type="text" id="company_name" name="company_name" value="{{ old('company_name', $record->company_name) }}" class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>

                        <!-- Position -->
                        <div>
                            <label for="position" class="block text-sm font-medium text-gray-700">Position</label>
                            <input type="text" id="position" name="position" value="{{ old('position', $record->position) }}" class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>

                        <!-- Address -->
                        <div class="md:col-span-2">
                            <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                            <input type="text" id="address" name="address" value="{{ old('address', $record->address) }}" class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>

                        <!-- Start Date -->
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                            <input type="date" id="start_date" name="start_date" value="{{ old('start_date', $record->start_date) }}" class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>

                        <!-- End Date -->
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                            <input type="date" id="end_date" name="end_date" value="{{ old('end_date', $record->end_date) }}" class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>

                    </div> <!-- End of .grid -->

                    <!-- Submit Button -->
                    <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded focus:ring focus:ring-blue-300">
                        Update History
                    </button>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
