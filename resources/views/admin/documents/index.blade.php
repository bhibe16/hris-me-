<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="logout-url" content="{{ route('logout') }}">
    <title>HRIS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="main-content min-h-screen bg-gray-100">

    <!-- Navigation Bar -->
    @include('layouts.navigation')

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Main Content -->
        <main class="flex-grow p-6 sm:p-12">
            <div class="p-8 rounded-xl text-gray-800 max-w-7xl mx-auto">
                
                <!-- Title & Filter Section -->
                <div class="mb-6">
                    <h1 class="text-3xl font-bold mb-2">Documents Pending Review</h1>
                    
                    <!-- Filter & Search Section -->
                    <div class="flex justify-between items-center mb-6">
                        <!-- Filter Dropdown -->
                        <form action="{{ route('admin.documents.index') }}" method="GET">
                            <select name="status" class="border p-2 rounded-md bg-white shadow-md" onchange="this.form.submit()">
                                <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </form>

                        <div class="flex items-center gap-3">
                            <!-- Search Input -->
                            <div class="relative">
                                <input type="text" id="searchInput" class="border border-gray-300 rounded-lg px-4 py-2 w-72 focus:ring focus:ring-yellow-300" placeholder="Search employee...">
                                <button onclick="searchEmployee()" class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-yellow-500 text-white px-3 py-1 rounded-md hover:bg-yellow-600 transition">
                                    🔍
                                </button>
                            </div>

                            <!-- Toggle Layout Button -->
                            <button id="toggleButton" class="bg-yellow-500 text-black px-4 py-2 rounded-lg hover:bg-yellow-600 transition" onclick="toggleLayout()">
                                Toggle View
                            </button>
                        </div>
                    </div>
                </div>

                @if($documents->isEmpty())
                    <p class="text-center text-gray-500">No documents found for this status.</p>
                @else
                <!-- Card Layout -->
                <div id="cardLayout" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                    @foreach ($documents as $document)
                        @php
                            $employee = optional($document->Employee);
                        @endphp
                        <a href="{{ route('admin.documents.view', $document) }}" class="block bg-gray-50 p-5 rounded-xl shadow-lg border border-gray-200 hover:bg-gray-100 transition">
                            <!-- Employee Info -->
                            <div class="flex items-center space-x-3 mb-3">
                                <img src="{{ $employee && $employee->profile_picture 
                                ? asset('storage/' . $employee->profile_picture) 
                                : asset('default-avatar.png') }}" 
                                alt="Employee Picture" 
                                class="w-12 h-12 rounded-full border">
                                <div>
                                    <p class="text-lg font-semibold">{{ $employee->first_name }} {{ $employee->last_name }}</p>
                                    <p class="text-sm text-gray-500">Uploaded on {{ $document->created_at->format('M d, Y') }}</p>
                                </div>
                            </div>

                            <!-- Document Details -->
                            <div class="flex justify-between items-center">
                                <p class="text-lg font-semibold">{{ $document->document_name }}</p>
                                <span class="px-3 py-1 rounded-full text-white text-sm
                                    {{ $document->status == 'approved' ? 'bg-green-500' : 
                                    ($document->status == 'rejected' ? 'bg-red-500' : 'bg-yellow-500') }}">
                                    {{ ucfirst($document->status) }}
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>

                <!-- Table Layout -->
                <div id="tableLayout" class="hidden">
                    <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
                        <table class="w-full border-collapse text-md">
                            <thead class="bg-gray-100 text-gray-700 uppercase text-left sticky top-0 z-10">
                                <tr class="border-b">
                                    <th class="p-4 font-semibold">Profile</th>
                                    <th class="p-4 font-semibold">Name</th>
                                    <th class="p-4 font-semibold">Document Name</th>
                                    <th class="p-4 font-semibold">Uploaded Date</th>
                                    <th class="p-4 font-semibold text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($documents as $document)
                                    @php
                                        $employee = optional($document->Employee);
                                    @endphp
                                    <tr class="hover:bg-gray-50 transition cursor-pointer" onclick="window.location='{{ route('admin.documents.view', $document) }}'">
                                        <td class="p-4 flex items-center space-x-3">
                                            <img src="{{ $employee && $employee->profile_picture 
                                            ? asset('storage/' . $employee->profile_picture) 
                                            : asset('default-avatar.png') }}" 
                                            alt="Employee Picture" 
                                            class="w-12 h-12 rounded-full border">
                                        </td>
                                        <td class="p-4 text-gray-700">{{ $employee->first_name }} {{ $employee->last_name }}</td>
                                        <td class="p-4 text-gray-700">
                                            @foreach(App\Models\Document::DOCUMENT_TYPES as $category => $types)
                                                @if(array_key_exists($document->document_type, $types))
                                                    {{ $types[$document->document_type] }}
                                                    @break
                                                @endif
                                            @endforeach
                                        </td>
                                        <td class="text-sm text-gray-700">Uploaded on {{ $document->created_at->format('M d, Y') }}</td>
                                        <td class="p-4 text-center">
                                            <span class="px-3 py-1 rounded-full text-white text-xs font-medium
                                                {{ $document->status == 'approved' ? 'bg-green-500' : 
                                                ($document->status == 'rejected' ? 'bg-red-500' : 'bg-yellow-500') }}">
                                                {{ ucfirst($document->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                @endif

            </div>
        </main>
    </div>

    <!-- JavaScript for Layout Toggle -->
    <script>
        window.onload = function() {
            const savedLayout = localStorage.getItem('layout');
            const cardLayout = document.getElementById('cardLayout');
            const tableLayout = document.getElementById('tableLayout');
            const toggleButton = document.getElementById('toggleButton');

            if (savedLayout === 'card') {
                cardLayout.classList.remove('hidden');
                tableLayout.classList.add('hidden');
                toggleButton.textContent = 'Table View';
            } else {
                cardLayout.classList.add('hidden');
                tableLayout.classList.remove('hidden');
                toggleButton.textContent = 'Card View';
            }
        }

        function toggleLayout() {
            const cardLayout = document.getElementById('cardLayout');
            const tableLayout = document.getElementById('tableLayout');
            const toggleButton = document.getElementById('toggleButton');

            cardLayout.classList.toggle('hidden');
            tableLayout.classList.toggle('hidden');

            toggleButton.textContent = cardLayout.classList.contains('hidden') ? 'Card View' : 'Table View';
            localStorage.setItem('layout', cardLayout.classList.contains('hidden') ? 'table' : 'card');
        }
    </script>

</body>
</html>
