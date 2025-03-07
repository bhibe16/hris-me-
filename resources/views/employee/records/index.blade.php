<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="logout-url" content="{{ route('logout') }}">
    <title>HRIS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="main-content min-h-screen">
    <!-- Navigation Bar -->
    @include('layouts.navigation')

    <div class="flex">
        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Main Content -->
        <main class="flex-grow p-16">

            <!-- Employee Record Section -->
            <div>
                @forelse ($record as $empRecord)
                        <div class="bg-white border border-gray-300 rounded-lg shadow-sm p-9 flex flex-col relative min-h-[150px]">
                            <h2 class="text-3xl font-semibold -mt-7 -ml-5 text-gray-600">Profile</h2>
                            <!-- Settings Dropdown (Top-Right) -->
                            <div x-data="{ open: false }" class="absolute top-4 right-4">
                                <button @click="open = !open" class="p-1 rounded-full bg-gray-200 hover:bg-yellow-500">
                                <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#5f6368"><path d="M216-216h51l375-375-51-51-375 375v51Zm-72 72v-153l498-498q11-11 23.84-16 12.83-5 27-5 14.16 0 27.16 5t24 16l51 51q11 11 16 24t5 26.54q0 14.45-5.02 27.54T795-642L297-144H144Zm600-549-51-51 51 51Zm-127.95 76.95L591-642l51 51-25.95-25.05Z"/></svg>
                                </button>
                                <div x-show="open" @click.away="open = false"
                                    class="absolute right-0 mt-2 w-32 bg-white border border-gray-300 shadow-lg rounded-md">
                                    <a href="{{ route('employee.records.edit', $empRecord->id) }}" 
                                    class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Edit</a>
                                    <form action="{{ route('employee.records.destroy', $empRecord->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this record?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <div class="flex items-center space-x-6 w-full">
                                <!-- Left side (Profile Image and Basic Information) -->
                                <div class="flex items-center space-x-6 w-1/2 pr-6">
                                    <img src="{{ !empty($empRecord->profile_picture) ? asset('storage/' . $empRecord->profile_picture) : asset('storage/default.png') }}" 
                                        alt="Profile Picture" 
                                        class="w-32 h-32 rounded-full border border-gray-300 shadow-md">
                                    <div>
                                        <p class="text-xl font-semibold">{{ $empRecord->position->name ?? 'N/A' }}</p>
                                        <p class="text-xl text-gray-600">{{ $empRecord->department->name ?? 'N/A' }}</p>
                                        <p class="text-xl text-gray-600">Employee ID: {{ $empRecord->user_id ?? 'N/A' }}</p>
                                    </div>
                                </div>

                                <!-- Vertical Line -->
                                <div class="border-r-2 border-dashed border-gray-300 h-60"></div>

                                <!-- Right side (Personal Information) -->
                                <div class="w-1/2 pl-6 mt-9">
                                    <h2 class="text-xl mb-4 -mt-14">Personal Information</h2>
                                    <div class="space-y-2">
                                        <p><span class="w-60 inline-block">First Name:</span> {{ $empRecord->first_name ?? 'N/A' }}</p>
                                        <p><span class="w-60 inline-block">Middle Name:</span> {{ $empRecord->middle_name ?? 'N/A' }}</p>
                                        <p><span class="w-60 inline-block">Last Name:</span> {{ $empRecord->last_name ?? 'N/A' }}</p>
                                        <p><span class="w-60 inline-block">Date of Birth:</span> 
                                            {{ !empty($empRecord->date_of_birth) ? \Carbon\Carbon::parse($empRecord->date_of_birth)->format('m/d/Y') : 'N/A' }}
                                        </p>
                                        <p><span class="w-60 inline-block">Gender:</span> {{ $empRecord->gender ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                @empty
                    <!-- Show this card when there are no records -->
                    <div class="bg-white border border-gray-300 rounded-lg shadow-sm p-9 flex flex-col relative min-h-[150px]">
                        <!-- Settings Dropdown (Top-Right) -->
                        <div x-data="{ open: false }" class="absolute top-4 right-4">
                            <button @click="open = !open" class="p-1 rounded-full bg-gray-200 hover:bg-yellow-500">
                            <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#5f6368"><path d="M216-216h51l375-375-51-51-375 375v51Zm-72 72v-153l498-498q11-11 23.84-16 12.83-5 27-5 14.16 0 27.16 5t24 16l51 51q11 11 16 24t5 26.54q0 14.45-5.02 27.54T795-642L297-144H144Zm600-549-51-51 51 51Zm-127.95 76.95L591-642l51 51-25.95-25.05Z"/></svg>
                            </button>
                            <div x-show="open" @click.away="open = false"
                                class="absolute right-0 mt-2 w-32 bg-white border border-gray-300 shadow-lg rounded-md">
                                <a href="{{ route('employee.records.create') }}" 
                                class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Create</a>
                            </div>
                        </div>
                        <div class="flex items-center space-x-6 w-full">
                            <!-- Left side -->
                            <div class="flex items-center space-x-6 w-1/2 pr-6">
                                <img src="{{ asset('storage/default.png') }}" 
                                    alt="Default Profile Picture" 
                                    class="w-32 h-32 rounded-full border border-gray-300 shadow-md">
                                <div>
                                    <p class="text-xl font-semibold">N/A</p>
                                    <p class="text-xl text-gray-600">N/A</p>
                                    <p class="text-xl text-gray-600">Employee ID: N/A</p>
                                </div>
                            </div>

                            <!-- Vertical Line -->
                            <div class="border-r-2 border-dashed border-gray-300 h-32"></div>

                            <!-- Right side -->
                            <div class="w-1/2 pl-6">
                                <h2 class="text-xl font-bold mb-4">Personal Information</h2>
                                <div class="space-y-2">
                                    <p><span class="w-60 inline-block">First Name:</span> N/A</p>
                                    <p><span class="w-60 inline-block">Middle Name:</span> N/A</p>
                                    <p><span class="w-60 inline-block">Last Name:</span> N/A</p>
                                    <p><span class="w-60 inline-block">Date of Birth:</span> N/A</p>
                                    <p><span class="w-60 inline-block">Gender:</span> N/A</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>

             <!-- Contact & Professional Details Grid -->
             <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                @forelse ($record as $empRecord)
                    <!-- Contact Information -->
                    <div class="bg-white border border-gray-300 rounded-lg p-6 shadow-sm">
                        <h2 class="text-xl mb-4">Contact Information</h2>
                        <div class="space-y-2">
                            <p><span class="w-60 inline-block">Email:</span> {{ $empRecord->email ?? 'N/A' }}</p>
                            <p><span class="w-60 inline-block">Phone:</span> {{ $empRecord->phone ?? 'N/A' }}</p>
                            <p><span class="w-60 inline-block">Address:</span> {{ $empRecord->address ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <!-- Professional Details -->
                    <div class="bg-white border border-gray-300 rounded-lg p-6 shadow-sm">
                        <h2 class="text-xl mb-4">Professional Details</h2>
                        <div class="space-y-2">
                            <p><span class="w-60 inline-block">Department:</span> {{ $empRecord->department->name ?? 'N/A' }}</p>
                            <p><span class="w-60 inline-block">Position:</span> {{ $empRecord->position->name ?? 'N/A' }}</p>
                            <p><span class="w-60 inline-block">Employment Status:</span> {{ $empRecord->employment_status ?? 'N/A' }}</p>
                        </div>
                    </div>
                @empty
                    <!-- Show empty details card -->
                    <div class="bg-white border border-gray-300 rounded-lg p-6 shadow-sm">
                        <h2 class="text-xl mb-4">Contact Information</h2>
                        <div class="space-y-2">
                            <p><span class="w-60 inline-block">Email:</span> N/A</p>
                            <p><span class="w-60 inline-block">Phone:</span> N/A</p>
                            <p><span class="w-60 inline-block">Address:</span> N/A</p>
                        </div>
                    </div>

                    <div class="bg-white border border-gray-300 rounded-lg p-6 shadow-sm">
                        <h2 class="text-xl mb-4">Professional Details</h2>
                        <div class="space-y-2">
                            <p><span class="w-60 inline-block">Department:</span> N/A</p>
                            <p><span class="w-60 inline-block">Position:</span> N/A</p>
                            <p><span class="w-60 inline-block">Employment Status:</span> N/A</p>
                        </div>
                    </div>
                @endforelse
            </div>
        


            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Educational History -->
                <div class="mt-6 relative" x-data="{ openEducationModal: false }">
                    <!-- Educational History Cards -->
                    <div class="bg-white border border-gray-300 rounded-lg p-6 shadow-sm h-full">
                        <div class="flex justify-between items-center">
                            <h2 class="text-xl">Educational Background</h2>
                            <!-- Settings Button (Opens Modal) -->
                            <button @click="openEducationModal = true" class="p-2 rounded-full bg-gray-200 hover:bg-yellow-500">
                                <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#5f6368"><path d="M216-216h51l375-375-51-51-375 375v51Zm-72 72v-153l498-498q11-11 23.84-16 12.83-5 27-5 14.16 0 27.16 5t24 16l51 51q11 11 16 24t5 26.54q0 14.45-5.02 27.54T795-642L297-144H144Zm600-549-51-51 51 51Zm-127.95 76.95L591-642l51 51-25.95-25.05Z"/></svg>
                            </button>
                        </div>
                        <div class="relative pl-6">
                            <div class="absolute left-2 top-14 bottom-16 w-1 bg-gray-500"></div>
                            @php
                                $orderedEducation = $educationalHistory->sortBy(function ($education) {
                                    return match ($education->education_level) {
                                        'Junior High' => 1,
                                        'Senior High' => 2,
                                        'Tertiary' => 3,
                                        default => 4,
                                    };
                                });
                            @endphp

                            @forelse ($orderedEducation as $education)
                                <div class="relative rounded-lg p-4">
                                    <!-- Educational History Text -->
                                    <div class="flex items-start">
                                        <div class="relative flex items-center gap-1">
                                            <div class="absolute -left-9 w-3 h-3 bg-gray-500 rounded-full"></div>
                                            <div class="ml-1 flex-1">
                                                <h4 class="text-md font-bold text-gray-900">
                                                     {{ $education->education_level ?? 'N/A' }}
                                                </h4>
                                                <p class="text-md text-gray-600">
                                                    {{ $education->school_name ?? 'N/A' }}
                                                </p>
                                                <!-- Track/Strand for Senior High -->
                                                @if($education->education_level === 'Senior High' && !empty($education->track_strand))
                                                    <p class="text-md text-gray-600">
                                                        {{ $education->track_strand }}
                                                    </p>
                                                @endif

                                                <!-- Program for Tertiary -->
                                                @if($education->education_level === 'Tertiary' && !empty($education->program))
                                                    <p class="text-sm text-gray-600">
                                                        {{ $education->program }}
                                                    </p>
                                                @endif
                                                <p class="text-sm text-gray-600">
                                                    {{ $education->start_year ? \Carbon\Carbon::parse($education->start_year)->format(' Y') : 'N/A' }} - 
                                                    {{ $education->end_year ? \Carbon\Carbon::parse($education->end_year)->format(' Y') : 'N/A' }}
                                                </p>
                                                <p class="text-sm text-gray-600">
                                                    {{ $education->graduation_status ?? 'N/A' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-center text-gray-600">No educational background found.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Modal for Managing Educational History -->
                    <div x-show="openEducationModal" class="fixed inset-0 z-50 bg-black bg-opacity-50 flex justify-center items-center">
                        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                            <h3 class="text-lg font-bold mb-4">Manage Educational Background</h3>
                            <ul class="space-y-2">
                                @foreach ($educationalHistory as $education)
                                    <li class="flex justify-between items-center border-b py-2">
                                        <span>{{ $education->school_name ?? 'N/A' }} - {{ $education->education_level ?? 'N/A' }}</span>
                                        <div class="flex space-x-2">
                                            <a href="{{ route('employee.educational-history.edit', $education->id) }}" 
                                            class="px-3 py-1 text-sm bg-blue-500 text-white rounded hover:bg-blue-600">
                                                Edit
                                            </a>
                                            <form action="{{ route('employee.educational-history.destroy', $education->id) }}" method="POST" 
                                                onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1 text-sm bg-red-500 text-white rounded hover:bg-red-600">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>

                            <!-- Create New Educational History Button -->
                            @if($educationalHistory->count() < 3)
                                <div class="mt-6 text-center">
                                    <a href="{{ route('employee.educational-history.create') }}" class="btn bg-green-500 text-white px-6 py-3 rounded-lg shadow-md hover:bg-green-600 transition duration-300">
                                        Add Educational History
                                    </a>
                                </div>
                            @endif
                            
                            <div class="mt-4 flex justify-end">
                                <button @click="openEducationModal = false" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                                    Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Employment History -->
                <div class="mt-6 relative" x-data="{ openWorkModal: false }">
                    <!-- Employment History Cards -->
                    <div class="bg-white border border-gray-300 rounded-lg p-6 shadow-sm h-full">
                        <div class="flex justify-between items-center">
                            <h2 class="text-xl">Work Experience</h2>
                            <!-- Settings Button (Opens Modal) -->
                            <button @click="openWorkModal = true" class="p-2 rounded-full bg-gray-200 hover:bg-yellow-500">
                            <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#5f6368"><path d="M216-216h51l375-375-51-51-375 375v51Zm-72 72v-153l498-498q11-11 23.84-16 12.83-5 27-5 14.16 0 27.16 5t24 16l51 51q11 11 16 24t5 26.54q0 14.45-5.02 27.54T795-642L297-144H144Zm600-549-51-51 51 51Zm-127.95 76.95L591-642l51 51-25.95-25.05Z"/></svg>
                            </button>
                        </div>
                        <div class="relative pl-6">
                            <div class="absolute left-4 top-9 bottom-9 w-1 bg-gray-500"></div>
                            @forelse ($history as $empHistory)
                                <div class="relative rounded-lg p-4">
                                    <!-- Work Experience Text -->
                                    <div class="flex items-start">
                                        <div class="relative flex items-center gap-1">
                                            <div class="absolute -left-7 w-3 h-3 bg-gray-500 rounded-full"></div>
                                            <div class="ml-1 flex-1">
                                                <h4 class="text-lg font-semibold text-gray-900">
                                                    {{ $empHistory->position ?? 'N/A' }} at {{ $empHistory->company_name ?? 'N/A' }}
                                                </h4>
                                                <p class="text-sm text-gray-600">
                                                    @php
                                                        $startDate = $empHistory->start_date ? \Carbon\Carbon::parse($empHistory->start_date) : null;
                                                        $endDate = $empHistory->end_date ? \Carbon\Carbon::parse($empHistory->end_date) : null;
                                                        $now = now(); // Get current date

                                                        // Format start and end dates
                                                        $startFormatted = $startDate ? $startDate->format('M Y') : 'N/A';
                                                        $endFormatted = $endDate ? $endDate->format('M Y') : 'Present';

                                                        // Calculate duration
                                                        $diffDate = $endDate ?? $now;
                                                        $years = $startDate ? $startDate->diffInYears($diffDate) : 0;
                                                        $months = $startDate ? $startDate->diffInMonths($diffDate) % 12 : 0;
                                                        
                                                        // Format duration text
                                                        $duration = $years > 0 ? "{$years} years" : '';
                                                        $duration .= $months > 0 ? " {$months} months" : '';
                                                        $duration = trim($duration) ?: 'N/A';
                                                    @endphp

                                                    {{ $startFormatted }} - {{ $endFormatted }} ({{ $duration }})
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-center text-gray-600">No employment history found.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Modal for Managing Employment History -->
                    <div x-show="openWorkModal" class="fixed inset-0 z-50 bg-black bg-opacity-50 flex justify-center items-center">
                        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                            <h3 class="text-lg font-bold mb-4">Manage Employment History</h3>
                            <ul class="space-y-2">
                                @foreach ($history as $empHistory)
                                    <li class="flex justify-between items-center border-b py-2">
                                        <span>{{ $empHistory->position ?? 'N/A' }} at {{ $empHistory->company_name ?? 'N/A' }}</span>
                                        <div class="flex space-x-2">
                                            <a href="{{ route('employee.history.edit', $empHistory->id) }}" 
                                            class="px-3 py-1 text-sm bg-blue-500 text-white rounded hover:bg-blue-600">
                                                Edit
                                            </a>
                                            <form action="{{ route('employee.history.destroy', $empHistory->id) }}" method="POST" 
                                                onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1 text-sm bg-red-500 text-white rounded hover:bg-red-600">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>

                            <!-- Create New History Button -->
                            @if($history->count() < 3)
                                <div class="mt-6 text-center">
                                    <a href="{{ route('employee.history.create') }}" class="btn bg-green-500 text-white px-6 py-3 rounded-lg shadow-md hover:bg-green-600 transition duration-300">
                                        Add Employment History
                                    </a>
                                </div>
                            @endif
                            
                            <div class="mt-4 flex justify-end">
                                <button @click="openWorkModal = false" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                                    Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
