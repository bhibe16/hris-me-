<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HRIS - Pending Records</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="main-content min-h-screen">
    @include('layouts.navigation')

    <div class="flex">
        @include('layouts.sidebar')

        <main class="flex-grow p-16">
            <h1 class="text-3xl font-bold mb-10 -mt-10 text-left">Pending Employee Records</h1>

            {{-- Success/Error Messages --}}
            @if(session('success'))
                <div class="bg-green-500 text-white p-3 mb-4 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-500 text-white p-3 mb-4 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="flex justify-end items-center mb-6">
    <div class="flex items-center gap-3">
        <form method="GET" action="" class="flex items-center gap-3">
            <div class="relative">
                <input type="text" name="search" id="searchInput" value="{{ request('search') }}"
                    class="border border-gray-300 rounded-lg px-4 py-2 w-72 focus:ring focus:ring-yellow-300"
                    placeholder="Search pending records...">
                <button type="submit"
                    class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-yellow-500 text-white px-3 py-1 rounded-md hover:bg-yellow-600 transition">🔍</button>
            </div>
        </form>

        <button id="toggleButton"
            class="bg-yellow-500 text-black px-4 py-2 rounded-lg hover:bg-yellow-600 transition"
            onclick="toggleLayout()">Toggle View</button>
    </div>
</div>


            {{-- Card Layout --}}
            <div id="cardLayout" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @forelse ($pendingRecords as $record)
                    <div class="flex flex-col items-center mb-8 bg-white p-6 rounded-lg cursor-pointer hover:shadow-lg transition min-h-[300px] w-50 relative"
                        onclick="toggleModal('modal-{{ $record->id }}')">
                        <img src="{{ asset('storage/' . $record->profile_picture) }}" alt="Profile Picture"
                            class="w-24 h-24 rounded-full border border-gray-300 shadow-md mb-4">
                        <p class="font-bold text-lg mb-2">{{ $record->first_name }} {{ $record->last_name }}</p>
                        <p class="text-gray-500 text-center">{{ $record->position->name }}</p>
                        <p class="text-gray-500 mb-4 text-center">{{ $record->department->name }}</p>

                        <div class="flex gap-3 mt-4">
                            <form action="{{ route('admin.employees.approve', $record->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">
                                    Approve
                                </button>
                            </form>

                            <form action="{{ route('admin.employees.reject', $record->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition">
                                    Reject
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center text-red-500 text-lg py-4">
                        No pending records found.
                    </div>
                @endforelse
            </div>

            {{-- Table Layout --}}
            <div id="tableLayout" class="hidden overflow-x-auto bg-white">
                <table class="w-full border-collapse border border-gray-200">
                    <thead class="linear-gradient">
                        <tr>
                            <th class="border border-gray-300 px-1 py-2 text-center">Profile Picture</th>
                            <th class="border border-gray-300 px-4 py-2 text-center">Full Name</th>
                            <th class="border border-gray-300 px-4 py-2 text-center">Position</th>
                            <th class="border border-gray-300 px-4 py-2 text-center">Department</th>
                            <th class="border border-gray-300 px-4 py-2 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pendingRecords as $record)
                            <tr class="hover:bg-gray-50 cursor-pointer" onclick="toggleModal('modal-{{ $record->id }}')">
                                <td class="border px-1 py-2 flex justify-center items-center">
                                    <img src="{{ asset('storage/' . $record->profile_picture) }}" alt="Profile Picture"
                                        class="w-12 h-12 rounded-full">
                                </td>
                                <td class="border px-4 py-2 text-center">{{ $record->first_name }} {{ $record->last_name }}</td>
                                <td class="border px-4 py-2 text-center">{{ $record->position->name }}</td>
                                <td class="border px-4 py-2 text-center">{{ $record->department->name }}</td>
                                <td class="border px-4 py-2 text-center">
                                    <div class="flex gap-3 justify-center">
                                        <form action="{{ route('admin.employees.approve', $record->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">
                                                Approve
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.employees.reject', $record->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition">
                                                Reject
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-red-500">No pending records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Modals for Detailed View --}}
            @foreach ($pendingRecords as $record)
                <div id="modal-{{ $record->id }}" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
                    <div class="bg-slate-200 p-8 rounded-lg shadow-lg max-w-7xl w-full max-h-[90vh] overflow-y-auto">
                        <div class="flex justify-between items-center">
                            <h2 class="text-2xl font-bold">Full Information</h2>
                            <button class="text-red-500" onclick="toggleModal('modal-{{ $record->id }}')">X</button>
                        </div>
                        <div class="bg-white border border-gray-300 rounded-lg shadow-sm p-9 flex flex-col relative min-h-[200px]">
                            <div class="flex items-center space-x-6 w-full">
                                <div class="flex items-center space-x-6 w-1/2 pr-6">
                                    <img src="{{ !empty($record->profile_picture) ? asset('storage/' . $record->profile_picture) : asset('storage/default.png') }}"
                                        alt="Profile Picture"
                                        class="w-32 h-32 rounded-full border border-gray-300 shadow-md">
                                    <div>
                                        <p class="text-xl font-semibold">{{ $record->position->name ?? 'N/A' }}</p>
                                        <p class="text-xl text-gray-600">{{ $record->department->name ?? 'N/A' }}</p>
                                        <p class="text-xl text-gray-600">Employee ID: {{ $record->user_id ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="border-r-2 border-dashed border-gray-300 h-32"></div>
                                <div class="w-1/2 pl-6 space-y-2">
                                    <h2 class="text-xl font-bold mb-4">Personal Information</h2>
                                    <p><span class="w-60 inline-block">First Name:</span> {{ $record->first_name ?? 'N/A' }}</p>
                                    <p><span class="w-60 inline-block">Middle Name:</span> {{ $record->middle_name ?? 'N/A' }}</p>
                                    <p><span class="w-60 inline-block">Last Name:</span> {{ $record->last_name ?? 'N/A' }}</p>
                                    <p><span class="w-60 inline-block">Date of Birth:</span>
                                        {{ !empty($record->date_of_birth) ? \Carbon\Carbon::parse($record->date_of_birth)->format('m/d/Y') : 'N/A' }}
                                    </p>
                                    <p><span class="w-60 inline-block">Gender:</span> {{ $record->gender ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                            <div class="bg-white border border-gray-300 rounded-lg p-6 shadow-sm space-y-2">
                                <h2 class="text-xl font-bold mb-4">Contact Information</h2>
                                <p><span class="w-60 inline-block">Email:</span> {{ $record->email ?? 'N/A' }}</p>
                                <p><span class="w-60 inline-block">Phone:</span> {{ $record->phone ?? 'N/A' }}</p>
                                <p><span class="w-60 inline-block">Address:</span> {{ $record->address ?? 'N/A' }}</p>
                            </div>
                            <div class="bg-white border border-gray-300 rounded-lg p-6 shadow-sm space-y-2">
                                <h2 class="text-xl font-bold mb-4">Professional Details</h2>
                                <p><span class="w-60 inline-block">Department:</span> {{ $record->department->name ?? 'N/A' }}</p>
                                <p><span class="w-60 inline-block">Position:</span> {{ $record->position->name ?? 'N/A' }}</p>
                                <p><span class="w-60 inline-block">Employment Status:</span> {{ $record->employment_status ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <script>
                function toggleModal(modalId) {
                    const modal = document.getElementById(modalId);
                    modal.classList.toggle('hidden');
                }

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
                };

                function toggleLayout() {
                    const cardLayout = document.getElementById('cardLayout');
                    const tableLayout = document.getElementById('tableLayout');
                    const toggleButton = document.getElementById('toggleButton');

                    if (cardLayout.classList.contains('hidden')) {
                        cardLayout.classList.remove('hidden');
                        tableLayout.classList.add('hidden');
                        toggleButton.textContent = 'Table View';
                        localStorage.setItem('layout', 'card');
                    } else {
                        cardLayout.classList.add('hidden');
                        tableLayout.classList.remove('hidden');
                        toggleButton.textContent = 'Card View';
                        localStorage.setItem('layout', 'table');
                    }
                }

                document.getElementById("searchInput").addEventListener("keyup", function() {
                    let query = this.value.toLowerCase();
                    let cardEmployees = document.querySelectorAll("#cardLayout > div");
                    let tableEmployees = document.querySelectorAll("#tableLayout tbody tr");
                    let cardContainer = document.getElementById("cardLayout");
                    let tableContainer = document.getElementById("tableLayout");

                    let cardFound = false;
                    let tableFound = false;

                    cardEmployees.forEach(employee => {
                        let name = employee.querySelector("p.font-bold")?.textContent.toLowerCase() || "";
                        let position = employee.querySelectorAll("p.text-gray-500")[0]?.textContent.toLowerCase() || "";
                        let department = employee.querySelectorAll("p.text-gray-500")[1]?.textContent.toLowerCase() || "";

                        if ([name, position, department].some(field => field.includes(query))) {
                            employee.style.display = "flex";
                            cardFound = true;
                        } else {
                            employee.style.display = "none";
                        }
                    });

                    tableEmployees.forEach(row => {
                        let cells = row.getElementsByTagName("td");
                        if (cells.length < 5) return;

                        let name = cells[1]?.textContent.toLowerCase() || "";
                        let position = cells[2]?.textContent.toLowerCase() || "";
                        let department = cells[3]?.textContent.toLowerCase() || "";

                        if ([name, position, department].some(field => field.includes(query))) {
                            row.style.display = "table-row";
                            tableFound = true;
                        } else {
                            row.style.display = "none";
                        }
                    });

                    // Show "No records found" if nothing matches
                    document.getElementById("noCardMessage").style.display = cardFound ? "none" : "block";
                    document.getElementById("noTableMessage").style.display = tableFound ? "none" : "table-row";
                });
            </script>
        </main>
    </div>
</body>

</html>