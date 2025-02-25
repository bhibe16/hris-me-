<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HRIS - Notifications</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script>
        function toggleCheckboxes(source) {
            let checkboxes = document.querySelectorAll('.notification-checkbox');
            checkboxes.forEach(checkbox => checkbox.checked = source.checked);
        }

        function filterNotifications(type) {
            let allNotifications = document.querySelectorAll('.notification-item');
            allNotifications.forEach(item => {
                if (type === 'all' || (type === 'unread' && item.classList.contains('unread'))) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        }
    </script>
</head>
<body class="main-content min-h-screen bg-gray-50">

    <!-- Navigation Bar -->
    @include('layouts.navigation')

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Main Content -->
        <main class="flex-grow p-6 sm:p-12">
            <div class="bg-white p-8 rounded-xl shadow-lg text-gray-700 max-w-4xl mx-auto">
                <h1 class="text-3xl font-bold text-gray-900 mb-6">All Notifications</h1>

                @if(Auth::user()->notifications->isEmpty())
                    <p class="text-gray-500 text-center py-6">No notifications found.</p>
                @else
                    <!-- Tabs for All & Unread -->
                    <div class="flex space-x-4 border-b mb-6">
                        <button onclick="filterNotifications('all')" class="px-6 py-2 text-gray-700 font-semibold focus:outline-none border-b-2 border-transparent hover:border-blue-500 transition-all">
                            All
                        </button>
                        <button onclick="filterNotifications('unread')" class="px-6 py-2 text-gray-700 font-semibold focus:outline-none border-b-2 border-transparent hover:border-blue-500 transition-all">
                            Unread
                        </button>
                    </div>

                    <!-- Scrollable Notification List -->
                    <div class="overflow-hidden border border-gray-200 rounded-lg max-h-96 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                        <ul class="divide-y divide-gray-200 bg-white">
                            <!-- Select All Checkbox -->
                            <li class="flex items-center p-4 bg-gray-50">
                                <input type="checkbox" onclick="toggleCheckboxes(this)" class="mr-3 w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <span class="font-semibold text-gray-700">Select All</span>
                            </li>

                            @foreach(Auth::user()->notifications as $notification)
                                <li class="notification-item flex items-center p-4 hover:bg-gray-50 transition-all {{ $notification->read_at ? '' : 'unread bg-blue-50' }}">
                                    <input type="checkbox" class="notification-checkbox mr-3 w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500" value="{{ $notification->id }}">
                                    
                                    <!-- Profile Picture -->
                                    <div class="flex-shrink-0 mr-3">
                                        <img src="{{ $notification->data['profile']['avatar'] ?? asset('default-avatar.png') }}" 
                                             alt="{{ $notification->data['profile']['name'] ?? 'Admin' }}" 
                                             class="w-10 h-10 rounded-full">
                                    </div>

                                    <div class="flex-1">
                                        <!-- Notification Message -->
                                        <a href="{{ $notification->data['url'] ?? '#' }}" class="text-blue-600 hover:underline font-medium">
                                            {{ $notification->data['message'] ?? 'No message available' }}
                                        </a>

                                        <!-- Profile Name and Timestamp -->
                                        <div class="flex items-center text-sm text-gray-500 mt-1">
                                            <span>{{ $notification->data['profile']['name'] ?? 'Admin' }}</span>
                                            <span class="mx-2">•</span>
                                            <span>{{ $notification->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-between items-center mt-6">
                        <form action="{{ route('admin.notifications.markAllRead') }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg shadow hover:bg-blue-600 transition-all">
                                Mark All as Read
                            </button>
                        </form>

                        <form id="deleteForm" action="{{ route('admin.notifications.deleteSelected') }}" method="POST">
                            @csrf
                            <input type="hidden" name="selected_notifications" id="selectedNotifications">
                            <button type="submit" class="bg-red-500 text-white px-6 py-2 rounded-lg shadow hover:bg-red-600 transition-all">
                                Delete Selected
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </main>
    </div>

    <script>
        document.getElementById('deleteForm').addEventListener('submit', function (event) {
            let selected = Array.from(document.querySelectorAll('.notification-checkbox:checked'))
                               .map(cb => cb.value);
            document.getElementById('selectedNotifications').value = selected.join(',');
            if (selected.length === 0) {
                event.preventDefault();
                alert('Please select at least one notification to delete.');
            }
        });
    </script>

</body>
</html>
