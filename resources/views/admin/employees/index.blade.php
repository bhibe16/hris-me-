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

<body class="main-content min-h-screen">
    
    @include('layouts.navigation')

    <div class="flex">
        @include('layouts.sidebar')


        <main class="flex-grow p-16">
            <h1 class="text-3xl font-bold mb-10 -mt-10 text-left">Employee List</h1>

            <div class="flex justify-between items-center mb-6">
                <a href="{{ route('register') }}"
                    class="bg-black text-white px-4 py-2 rounded-lg hover-gradient transition">+ Create Employee</a>

                <div class="flex items-center gap-3">
                    <form method="GET" action="{{ route('admin.employees.index') }}" class="flex items-center gap-3">
                        <div class="relative">
                            <input type="text" name="search" id="searchInput" value="{{ request('search') }}"
                                class="border border-gray-300 rounded-lg px-4 py-2 w-72 focus:ring focus:ring-yellow-300"
                                placeholder="Search employee...">
                            <button type="submit"
                                class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-yellow-500 text-white px-3 py-1 rounded-md hover:bg-yellow-600 transition">🔍</button>
                        </div>
                    </form>

                    <button id="toggleButton"
                        class="bg-yellow-500 text-black px-4 py-2 rounded-lg hover:bg-yellow-600 transition"
                        onclick="toggleLayout()">Toggle View</button>
                </div>
            </div>
            @if (session('success'))
    <div class="bg-green-500 text-white p-3 rounded-lg flex items-center">
        <svg class="w-6 h-6 mr-2 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
        </svg>
        {{ session('success') }}
    </div>
@endif

            <div id="cardLayout" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @forelse ($employees as $employee)
                    <div class="flex flex-col items-center mb-8 bg-white p-6 rounded-lg cursor-pointer hover:shadow-sm transition min-h-[300px] w-50 relative"
                        onclick="toggleModal('modal-{{ $employee->id }}')">
                        
                        <!-- Status Dropdown in Top Left Corner -->
                        <select class="absolute text-center top-2 -left-5 transform -translate-y-1/2 px-3 py-1 pr-7 pl-1 rounded-lg text-sm border focus:outline-none focus:ring 
                            {{ $employee->status === 'approved' ? 'bg-green-200 text-green-700 border-green-500' : '' }}
                            {{ $employee->status === 'reject' ? 'bg-red-200 text-red-700 border-red-500' : '' }}
                            {{ $employee->status === 'pending' ? 'bg-blue-200 text-blue-700 border-blue-500' : '' }}"
                            data-employee-id="{{ $employee->id }}"
                            onchange="updateStatus(this)" onclick="event.stopPropagation();">
                            <option value="pending" @selected($employee->status == 'pending')>Pending</option>
                            <option value="approved" @selected($employee->status == 'approved')>Approved</option>
                            <option value="reject" @selected($employee->status == 'reject')>Reject</option>
                        </select>


                        <!-- Employee Profile Picture -->
                        <img src="{{ asset('storage/' . $employee->profile_picture) }}" alt="Profile Picture"
                            class="w-24 h-24 rounded-full border border-gray-300 shadow-md mb-4">
                        
                        <!-- Employee Name -->
                        <p class="font-bold text-lg mb-2 
                            @if($employee->status == 'Inactive') text-red-500 
                            @elseif($employee->status == 'On Leave') text-blue-500 
                            @endif">
                            {{ $employee->first_name }} {{ $employee->last_name }}
                        </p>
                        
                        <!-- Employee Details -->
                        <p class="text-gray-500 text-center">{{ $employee->position->name }}</p>
                        <p class="text-gray-500 mb-4 text-center">{{ $employee->department->name }}</p>

                        <div class="flex flex-col items-start w-full space-y-3 rounded-sm p-5 bg-gray-100">
                            <div class="flex items-center space-x-2">
                                <label class="text-sm font-medium">Employee ID:</label>
                                <p class="text-sm text-gray-700">{{ $employee->user_id }}</p>
                            </div>
                            <div class="flex items-center space-x-2">
                                <label class="text-sm font-medium">Email:</label>
                                <p class="text-sm text-gray-700">{{ $employee->email }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center text-red-500 text-lg py-4">
                        No records found.
                    </div>
                @endforelse
            </div>


            <div id="tableLayout" class="hidden overflow-x-auto bg-white">
                <table class="w-full border-collapse border border-gray-200">
                    <thead class="linear-gradient">
                        <tr>
                            <th class="border border-gray-300 px-1 py-2 text-center">Profile Picture</th>
                            <th class="border border-gray-300 px-4 py-2 text-center">Employee ID</th>
                            <th class="border border-gray-300 px-4 py-2 text-center">Full Name</th>
                            <th class="border border-gray-300 px-4 py-2 text-center">Position</th>
                            <th class="border border-gray-300 px-4 py-2 text-center">Department</th>
                            <th class="border border-gray-300 px-4 py-2 text-center">Email</th>
                            <th class="border border-gray-300 px-4 py-2 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($employees as $employee)
                            <tr class="hover:bg-gray-50 cursor-pointer" onclick="toggleModal('modal-{{ $employee->id }}')">
                                <td class="border px-1 py-2 flex justify-center items-center relative">
                                    <img src="{{ asset('storage/' . $employee->profile_picture) }}" alt="Profile Picture"
                                        class="w-12 h-12 rounded-full">
                                </td>
                                <td class="border px-4 py-2 text-center">{{ $employee->user_id }}</td>
                                <td class="border px-4 py-2 text-center"> {{ $employee->first_name }} {{ $employee->last_name }}</td>
                                <td class="border px-4 py-2 text-center">{{ $employee->position->name }}</td>
                                <td class="border px-4 py-2 text-center">{{ $employee->department->name }}</td>
                                <td class="border px-4 py-2 text-center">{{ $employee->email }}</td>
                                <td class="border px-4 py-2 text-center">
                                    <select class="w-full pr-4 -pl-3  text-center rounded-lg text-sm border focus:outline-none focus:ring 
                                        {{ $employee->status === 'approved' ? 'bg-green-200 text-green-700 border-green-500' : '' }}
                                        {{ $employee->status === 'reject' ? 'bg-red-200 text-red-700 border-red-500' : '' }}
                                        {{ $employee->status === 'pending' ? 'bg-blue-200 text-blue-700 border-blue-500' : '' }}"
                                            data-employee-id="{{ $employee->id }}"
                                            onchange="updateStatus(this)" onclick="event.stopPropagation();">
                                        <option value="pending" @selected($employee->status == 'pending')>Pending</option>
                                        <option value="approved" @selected($employee->status == 'approved')>Approved</option>
                                        <option value="reject" @selected($employee->status == 'reject')>Reject</option>
                                    </select>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-red-500">No records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @foreach ($employees as $employee)
                <div id="modal-{{ $employee->id }}" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
                    <div class="bg-slate-200 p-8 rounded-lg shadow-lg max-w-7xl w-full max-h-[90vh] overflow-y-auto">
                        <div class="flex justify-between items-center">
                            <h2 class="text-2xl font-bold">Full Information</h2>
                            <button class="text-red-500" onclick="toggleModal('modal-{{ $employee->id }}')">X</button>
                        </div>
                        <div class="bg-white border border-gray-300 rounded-lg shadow-sm p-9 flex flex-col relative min-h-[200px]">
                            <div class="flex items-center space-x-6 w-full">
                                <div class="flex items-center space-x-6 w-1/2 pr-6">
                                    <img src="{{ !empty($employee->profile_picture) ? asset('storage/' . $employee->profile_picture) : asset('storage/default.png') }}"
                                        alt="Profile Picture"
                                        class="w-32 h-32 rounded-full border border-gray-300 shadow-md">
                                    <div>
                                        <p class="text-xl font-semibold">{{ $employee->position->name ?? 'N/A' }}</p>
                                        <p class="text-xl text-gray-600">{{ $employee->department->name ?? 'N/A' }}</p>
                                        <p class="text-xl text-gray-600">Employee ID: {{ $employee->user_id ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="border-r-2 border-dashed border-gray-300 h-32"></div>
                                <div class="w-1/2 pl-6 space-y-2">
                                    <h2 class="text-xl font-bold mb-4">Personal Information</h2>
                                    <p><span class="w-60 inline-block">First Name:</span> {{ $employee->first_name ?? 'N/A' }}</p>
                                    <p><span class="w-60 inline-block">Middle Name:</span> {{ $employee->middle_name ?? 'N/A' }}</p>
                                    <p><span class="w-60 inline-block">Last Name:</span> {{ $employee->last_name ?? 'N/A' }}</p>
                                    <p><span class="w-60 inline-block">Date of Birth:</span>
                                        {{ !empty($employee->date_of_birth) ? \Carbon\Carbon::parse($employee->date_of_birth)->format('m/d/Y') : 'N/A' }}
                                    </p>
                                    <p><span class="w-60 inline-block">Gender:</span> {{ $employee->gender ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                            <div class="bg-white border border-gray-300 rounded-lg p-6 shadow-sm space-y-2">
                                <h2 class="text-xl font-bold mb-4">Contact Information</h2>
                                <p><span class="w-60 inline-block">Email:</span> {{ $employee->email ?? 'N/A' }}</p>
                                <p><span class="w-60 inline-block">Phone:</span> {{ $employee->phone ?? 'N/A' }}</p>
                                <p><span class="w-60 inline-block">Address:</span> {{ $employee->address ?? 'N/A' }}</p>
                            </div>
                            <div class="bg-white border border-gray-300 rounded-lg p-6 shadow-sm space-y-2">
                                <h2 class="text-xl font-bold mb-4">Professional Details</h2>
                                <p><span class="w-60 inline-block">Department:</span> {{ $employee->department->name ?? 'N/A' }}</p>
                                <p><span class="w-60 inline-block">Position:</span> {{ $employee->position->name ?? 'N/A' }}</p>
                                <p><span class="w-60 inline-block">Employment Status:</span> {{ $employee->employment_status ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <!-- Employment History and Educational Background Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                            <!-- Employment History Cards -->
                            <div class="bg-white border border-gray-300 rounded-lg p-6 shadow-sm">
                                <div class="flex justify-between items-center mb-4">
                                    <h2 class="text-xl font-bold mb-2">Work Experience</h2>
                                </div>
                                <div class="relative pl-6">
                                    <div class="absolute left-2 top-9 bottom-9 w-1 bg-gray-500"></div>
                                    @forelse ($employment[$employee->user_id] ?? [] as $record)
                                        <div class="relative rounded-lg p-2">
                                            <div class="flex items-start">
                                                <div class="relative flex items-center gap-3">
                                                    <div class="absolute -left-7 w-3 h-3 bg-gray-500 rounded-full"></div>
                                                    <div class="ml-5 flex-1">
                                                        <h4 class="text-lg font-semibold text-gray-900">
                                                            {{ $record->position ?? 'N/A' }} at
                                                            {{ $record->company_name ?? 'N/A' }}
                                                        </h4>
                                                        <p class="text-sm text-gray-600">
                                                            {{ $record->start_date ? \Carbon\Carbon::parse($record->start_date)->format('M Y') : 'N/A' }}
                                                            -
                                                            @if (empty($record->end_date))
                                                                Present
                                                            @else
                                                                {{ \Carbon\Carbon::parse($record->end_date)->format('M Y') }}
                                                            @endif
                                                            ({{ $record->start_date ? \Carbon\Carbon::parse($record->start_date)->diffInMonths(\Carbon\Carbon::now()) . ' months' : 'N/A' }})
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

                            <!-- Educational Background Cards -->
                            <div class="bg-white border border-gray-300 rounded-lg p-6 shadow-sm">
                                <div class="flex justify-between items-center mb-4">
                                    <h2 class="text-xl font-bold mb-2">Educational Background</h2>
                                </div>
                                <div class="relative pl-6">
                                    <div class="absolute left-2 top-14 bottom-12 w-1 bg-gray-500"></div>
                                    @php
                                        $sortedEducational = collect($educational[$employee->user_id] ?? [])->sortBy('start_year');
                                    @endphp
                                    @forelse ($sortedEducational as $record)
                                        <div class="relative rounded-lg p-2">
                                            <div class="flex items-start">
                                                <div class="relative flex items-center gap-3">
                                                    <div class="absolute -left-7 w-3 h-3 bg-gray-500 rounded-full"></div>
                                                    <div class="ml-5 flex-1">
                                                        <h4 class="text-lg font-semibold text-gray-900">
                                                            {{ $record->education_level ?? 'N/A' }}
                                                        </h4>
                                                        <p class="text-sm text-gray-600">
                                                            {{ $record->school_name ?? 'N/A' }}
                                                        </p>
                                                        <p class="text-sm text-gray-600">
                                                            {{ $record->start_year ? \Carbon\Carbon::parse($record->start_year)->format('Y') : 'N/A' }} - 
                                                            {{ $record->end_year ? \Carbon\Carbon::parse($record->end_year)->format('Y') : 'N/A' }}    
                                                        </p>
                                                        <p class="text-sm text-gray-600">
                                                            {{ $record->graduation_status ?? 'N/A' }}
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
                        </div>
                        <!-- Delete Button and Form -->
                        <div class="mt-6 flex justify-end">
                        <form action="{{ url('admin/employees/' . $employee->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this employee?');">
    @csrf
    @method('DELETE')
    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">
        Delete Record
    </button>
</form>

                        </div>
                    </div>
                </div>
            @endforeach

            <div class="flex justify-center mt-8">{{ $employees->links() }}</div>
        </main>
    </div>

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
        let userId = employee.getAttribute("data-user-id")?.toLowerCase() || "";
        let name = employee.querySelector("p.font-bold")?.textContent.toLowerCase() || "";
        let position = employee.querySelectorAll("p.text-gray-500")[0]?.textContent.toLowerCase() || "";
        let department = employee.querySelectorAll("p.text-gray-500")[1]?.textContent.toLowerCase() || "";

        if ([userId, name, position, department].some(field => field.includes(query))) {
            employee.style.display = "flex"; // Ensure employee cards show properly
            cardFound = true;
        } else {
            employee.style.display = "none";
        }
    });

    tableEmployees.forEach(row => {
        let cells = row.getElementsByTagName("td");
        if (cells.length < 6) return; // Ensure row has enough columns

        let userId = cells[1]?.textContent.toLowerCase() || "";
        let name = cells[2]?.textContent.toLowerCase() || "";
        let position = cells[3]?.textContent.toLowerCase() || "";
        let department = cells[4]?.textContent.toLowerCase() || "";
        let email = cells[5]?.textContent.toLowerCase() || "";

        if ([userId, name, position, department, email].some(field => field.includes(query))) {
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

function updateStatus(selectElement) {
    const employeeId = selectElement.dataset.employeeId;
    const newStatus = selectElement.value;
    const originalValue = selectElement.dataset.originalValue;

    fetch(`/employees/${employeeId}/update-status`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ status: newStatus })
    })
    .then(response => {
        if (!response.ok) throw new Error('Update failed');

        // Update select background color dynamically
        selectElement.classList.remove('bg-green-200', 'text-green-700', 'border-green-500', 
                                       'bg-red-200', 'text-red-700', 'border-red-500', 
                                       'bg-blue-200', 'text-blue-700', 'border-blue-500');

        if (newStatus === 'approved') {
            selectElement.classList.add('bg-green-200', 'text-green-700', 'border-green-500');
        } else if (newStatus === 'reject') {
            selectElement.classList.add('bg-red-200', 'text-red-700', 'border-red-500');
        } else {
            selectElement.classList.add('bg-blue-200', 'text-blue-700', 'border-blue-500');
        }

        // Refresh the page after successful update
        location.reload();
    })
    .catch(error => {
        console.error('Error:', error);
        selectElement.value = originalValue;
    });
}

    </script>
</body>

</html>