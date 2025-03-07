<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="logout-url" content="{{ route('logout') }}">
    <title>HRIS - Job Listings</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="main-content min-h-screen">
    @include('layouts.navigation')

    <div class="flex">
        @include('layouts.sidebar')

        <main class="flex-grow p-16">
            <div class="container mx-auto p-6">
                <h2 class="text-2xl font-bold mb-4">Job Listings</h2>
                <div id="cardLayout" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                    @foreach($jobPosts as $job)
                        <div class="flex flex-col items-center mb-8 bg-white p-6 rounded-lg cursor-pointer hover:shadow-sm transition min-h-[300px] w-50 relative" 
                            onclick="toggleModal('modal-{{ $job['id'] }}')">
                            
                            <h3 class="text-lg font-bold mb-2">{{ $job['title'] }}</h3>
                            <p class="text-gray-500 text-center">{{ $job['location'] }}</p>
                            <p class="text-gray-500 mb-4 text-center">{{ $job['department'] }}</p>
                            
                            <div class="flex flex-col items-start w-full space-y-3 rounded-sm p-5 bg-gray-100">
                                <div class="flex items-center space-x-2">
                                    <label class="text-sm font-medium">Salary:</label>
                                    <p class="text-sm text-gray-700">₱{{ number_format($job['salary']) }}</p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <label class="text-sm font-medium">Schedule:</label>
                                    <p class="text-sm text-gray-700">{{ $job['schedule'] }}</p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <label class="text-sm font-medium">Created At:</label>
                                    <p class="text-sm text-gray-700">{{ \Carbon\Carbon::parse($job['created_at'])->format('m/d/Y') }}</p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <label class="text-sm font-medium">Updated At:</label>
                                    <p class="text-sm text-gray-700">{{ \Carbon\Carbon::parse($job['updated_at'])->format('m/d/Y') }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </main>
    </div>

    <!-- Modal -->
    @foreach($jobPosts as $job)
    <div id="modal-{{ $job['id'] }}" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg shadow-lg p-6 max-w-lg w-full">
            <h2 class="text-2xl font-semibold mb-4">{{ $job['title'] }}</h2>
            <p class="text-gray-700 mb-4">{{ $job['description'] }}</p>
            <div class="border-t pt-4 text-sm text-gray-600">
                <p><strong>Created At:</strong> {{ \Carbon\Carbon::parse($job['created_at'])->format('M d, Y h:i A') }}</p>
                <p><strong>Updated At:</strong> {{ \Carbon\Carbon::parse($job['updated_at'])->format('M d, Y h:i A') }}</p>
            </div>
            <button onclick="toggleModal('modal-{{ $job['id'] }}')" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 mt-4">Close</button>
        </div>
    </div>
    @endforeach

    <script>
        function toggleModal(modalId) {
            let modal = document.getElementById(modalId);
            if (modal.classList.contains('hidden')) {
                modal.classList.remove('hidden');
            } else {
                modal.classList.add('hidden');
            }
        }
    </script>
</body>
</html>
