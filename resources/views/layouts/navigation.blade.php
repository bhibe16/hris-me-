<nav x-data="{ open: false, showAdminNotifications: false, showEmployeeNotifications: false, showChat: false }" class="linear-gradient">
    <!-- Primary Navigation Menu -->
    <div class="max-w-10xl mx-auto px-4 sm:px-6 lg:px-7">
        <div class="flex justify-between h-16">
            <!-- Logo -->
            <div class="flex items-center" style="margin-left: 2cm;">
    <div class="shrink-0">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-12 h-12">
    </div>
</div>

            <!-- Chat, Notification, and Settings -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 space-x-4">
                <!-- Chat Icon -->
                <div class="relative">
                    <button @click="showChat = !showChat" class="relative p-2 text-gray-500 hover:text-gray-700 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </button>
                    <div x-show="showChat" @click.outside="showChat = false" class="absolute right-0 mt-2 w-64 bg-white rounded-lg shadow-lg overflow-hidden">
                        <div class="p-2 text-sm text-gray-700">Chat</div>
                        <ul class="divide-y divide-gray-200">
                            <li class="p-2 hover:bg-gray-100">Chat with Support</li>
                            <li class="p-2 hover:bg-gray-100">Chat with Team</li>
                        </ul>
                        <a href="{{ route('admin.notifications') }}" class="block text-center text-blue-600 hover:underline p-2" @click.stop>
    View all
</a>
                    </div>
                </div>

                @if (Auth::user()->role == 'admin' || Auth::user()->role == 'hr3')
               <!-- Admin Notification Icon -->
<div class="relative">
    <button @click="showAdminNotifications = !showAdminNotifications" class="relative p-2 text-gray-500 hover:text-gray-700 focus:outline-none">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14V11a6.002 6.002 0 00-4-5.659V4a2 2 0 10-4 0v1.341C7.67 6.165 6 8.388 6 11v3a2.032 2.032 0 01-.595 1.405L4 17h5m6 0a3 3 0 11-6 0m6 0H9"></path>
        </svg>
        @if(Auth::user()->unreadNotifications->count() > 0)
            <span class="absolute top-0 right-0 inline-flex items-center justify-center px-1 py-0.5 text-xs font-bold leading-none text-white bg-red-500 rounded-full">
                {{ Auth::user()->unreadNotifications->count() }}
            </span>
        @endif
    </button>
    <div x-show="showAdminNotifications" @click.outside="showAdminNotifications = false" class="absolute right-0 mt-2 w-64 bg-white rounded-lg shadow-lg">
        <div class="p-2 text-sm text-gray-700 border-b">Admin Notifications</div>
        <div class="max-h-36 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
            <ul class="divide-y divide-gray-200">
                @forelse(Auth::user()->unreadNotifications as $notification)
                <li class="p-2 hover:bg-gray-100">
                    <a href="{{ $notification->data['url'] }}" onclick="markNotificationAsRead('{{ $notification->id }}')" class="block text-sm">
                        {{ $notification->data['message'] }}
                    </a>
                </li>
                @empty
                <li class="p-2 text-gray-500 text-sm">No new notifications</li>
                @endforelse
            </ul>
        </div>
        <a href="{{ route('admin.notifications') }}" class="block text-center text-blue-600 hover:underline p-2 border-t">View all</a>
    </div>
</div>
                @elseif(Auth::user()->role == 'Employee')
                <!-- Notification Icon for Employee -->
                <div class="relative">
                    <!-- Notification Bell Icon -->
                    <button @click="showEmployeeNotifications = !showEmployeeNotifications" class="relative p-2 text-gray-500 hover:text-gray-700 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14V11a6.002 6.002 0 00-4-5.659V4a2 2 0 10-4 0v1.341C7.67 6.165 6 11 6 11v3a2.032 2.032 0 01-.595 1.405L4 17h5m6 0a3 3 0 11-6 0m6 0H9"></path>
                        </svg>

                        <!-- Notification Badge -->
                        @php
                            $notificationCount = Auth::user()->unreadNotifications->count();
                        @endphp
                        @if ($notificationCount > 0)
                            <span class="absolute top-0 right-0 inline-flex items-center justify-center px-1 py-0.5 text-xs font-bold leading-none text-white bg-red-500 rounded-full">
                                {{ $notificationCount }}
                            </span>
                        @endif
                    </button>

                    <!-- Notification Dropdown -->
                    <div x-show="showEmployeeNotifications" @click.outside="showEmployeeNotifications = false" class="absolute right-0 mt-2 w-72 bg-white rounded-lg shadow-lg overflow-hidden border border-gray-200">
                        <div class="p-3 text-sm font-semibold text-gray-800 bg-gray-100">Notifications</div>

                        <ul class="divide-y divide-gray-200 max-h-64 overflow-auto">
                            <!-- Laravel Notifications -->
                            @foreach (Auth::user()->notifications as $notification)
                                <li class="p-3 hover:bg-gray-100">
                                    <p class="text-sm text-gray-700">{{ $notification->data['message'] }}</p>
                                    @if ($notification->data['status'] == 'rejected')
                                        <p class="text-xs text-red-500">Reason: {{ $notification->data['rejection_comment'] }}</p>
                                    @endif
                                </li>
                            @endforeach

                            <!-- Static Employee Notifications -->
                            <li class="p-3 hover:bg-gray-100 text-gray-700">New company policy update</li>
                            <li class="p-3 hover:bg-gray-100 text-gray-700">Upcoming team meeting</li>
                        </ul>

                        <!-- View All Notifications Link -->
                        <a href="#" class="block text-center text-blue-600 hover:underline p-3 text-sm font-medium">View all</a>
                    </div>
                </div>
                @endif

                <!-- Display Time -->
                <div class="text-gray-700">
                    <span id="current-time"></span>
                </div>

                <!-- Settings Dropdown for Both Admin and Employee -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a 1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Setting') }}
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>
</nav>
<script>
    function markNotificationAsRead(notificationId) {
        fetch(`/notifications/${notificationId}/mark-as-read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
        });
    }

    function updateTime() {
        const timeElement = document.getElementById('current-time');
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        timeElement.innerText = `${hours}:${minutes}:${seconds}`;
    }

    setInterval(updateTime, 1000); // Update time every second
</script>