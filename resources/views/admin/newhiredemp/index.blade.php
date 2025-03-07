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

        <div class="flex-grow p-16">
            <h1 class="text-3xl font-bold mb-10 -mt-10 text-left">New Hired Employees</h1>

            <div class="flex justify-end items-center mb-6"> <!-- Changed to justify-end -->
                <form method="GET" action="#" class="flex items-center gap-3">
                    <div class="relative">
                        <input type="text" name="search" id="searchInput" value=""
                            class="border border-gray-300 rounded-lg px-4 py-2 w-72 focus:ring focus:ring-yellow-300"
                            placeholder="Search employees...">
                        <button type="submit"
                            class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-yellow-500 text-white px-3 py-1 rounded-md hover:bg-yellow-600 transition">🔍</button>
                    </div>
                </form>
            </div>

            <!-- Table Layout Only -->
            <div class="overflow-x-auto bg-white">
                <table class="w-full border-collapse border border-gray-200">
                    <thead class="linear-gradient">
                        <tr>
                            <th class="border border-gray-300 px-4 py-2">ID</th>
                            <th class="border border-gray-300 px-4 py-2">Name</th>
                            <th class="border border-gray-300 px-4 py-2">Position</th>
                            <th class="border border-gray-300 px-4 py-2">Department</th>
                            <th class="border border-gray-300 px-4 py-2">Email</th>
                            <th class="border border-gray-300 px-4 py-2">Contact</th>
                            <th class="border border-gray-300 px-4 py-2">Salary</th>
                            <th class="border border-gray-300 px-4 py-2">Status</th>
                            <th class="border border-gray-300 px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employees as $employee)
                        <tr class="hover:bg-gray-50">
                            <td class="border px-4 py-2">{{ $employee['id'] }}</td>
                            <td class="border px-4 py-2">{{ $employee['first_name'] }} {{ $employee['last_name'] }}</td>
                            <td class="border px-4 py-2">{{ $employee['job_position'] }}</td>
                            <td class="border px-4 py-2">{{ $employee['department'] }}</td>
                            <td class="border px-4 py-2">{{ $employee['email'] }}</td>
                            <td class="border px-4 py-2">{{ $employee['contact'] }}</td>
                            <td class="border px-4 py-2">{{ $employee['salary'] }}</td>
                            <td class="border px-4 py-2">
                                <select class="w-full px-2 py-1 text-center rounded-lg text-sm border bg-blue-200 text-blue-700 border-blue-500"
                                    onchange="updateStatus(this)">
                                    <option value="pending" selected>Pending</option>
                                    <option value="approved">Approved</option>
                                    <option value="reject">Reject</option>
                                </select>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Modals -->
            @foreach ($employees as $employee)
            <div id="modal-{{ $employee['id'] }}" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-slate-200 p-8 rounded-lg shadow-lg max-w-3xl w-full max-h-[90vh] overflow-y-auto">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-2xl font-bold">Employee Details</h2>
                        <button class="text-red-500" onclick="toggleModal('modal-{{ $employee['id'] }}')">✕</button>
                    </div>
                    
                    <div class="bg-white p-6 rounded-lg space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="font-semibold">Full Name:</p>
                                <p>{{ $employee['first_name'] }} {{ $employee['middle_name'] ?? '' }} {{ $employee['last_name'] }}</p>
                            </div>
                            <div>
                                <p class="font-semibold">Birth Date:</p>
                                <p>{{ $employee['birth_date'] }}</p>
                            </div>
                            <div>
                                <p class="font-semibold">Gender:</p>
                                <p>{{ $employee['gender'] }}</p>
                            </div>
                            <div>
                                <p class="font-semibold">Contact:</p>
                                <p>{{ $employee['contact'] }}</p>
                            </div>
                            <div>
                                <p class="font-semibold">Job Position:</p>
                                <p>{{ $employee['job_position'] }}</p>
                            </div>
                            <div>
                                <p class="font-semibold">Department:</p>
                                <p>{{ $employee['department'] }}</p>
                            </div>
                            <div>
                                <p class="font-semibold">Salary:</p>
                                <p>{{ $employee['salary'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>

    <script>
        function toggleModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.toggle('hidden');
        }

        function updateStatus(selectElement) {
            // Implement your status update logic here
            console.log('Status updated:', selectElement.value);
        }
    </script>
</body>

</html>