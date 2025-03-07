<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HRIS - Archived Employees</title>
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
                
                <!-- Title Section -->
                <div class="mb-6">
                    <h1 class="text-3xl font-bold mb-2">Archived Employees</h1>
                

                @if (session('success'))
    <div class="bg-red-500 text-white p-3 rounded-lg flex items-center">
        <svg class="w-6 h-6 mr-2 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
        {{ session('success') }}
    </div>
@endif
</div>

                <!-- Table Layout -->
                <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
                    <table class="w-full border-collapse text-md">
                        <thead class="bg-gray-100 text-gray-700 uppercase text-left z-10">
                            <tr class="border-b">  
                                <th class=" p-4 font-semibold">Profile Picture</th>
                                <th class="p-4 font-semibold">ID</th>
                                <th class="p-4 font-semibold">Name</th>
                                <th class="p-4 font-semibold">Department</th>
                                <th class="p-4 font-semibold">Position</th>
                                <th class="p-4 font-semibold">Email</th>
                                <th class="p-4 font-semibold text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($employees as $employee)
                                <tr class="hover:bg-gray-50 transition">
                                <td class="border px-1 py-2 flex justify-center"><img
                                        src="{{ asset('storage/' . $employee->profile_picture) }}"
                                        alt="Profile Picture" class="w-12 h-12 rounded-full"></td>
                                <td class="border  px-4 py-2 text-center">{{ $employee->user_id}}</td>
                                <td class="border  px-4 py-2 text-center">{{ $employee->first_name }} {{ $employee->last_name }}</td>
                                <td class="border  px-4 py-2 text-center">{{ $employee->department->name }}</td>
                                <td class="border  px-4 py-2 text-center">{{ $employee->position->name }}</td>
                                <td class="border px-4 py-2 text-center">{{ $employee->email }}</td>
                                    <td class="p-4 text-center">
                                        <form action="{{ route('employees.restore', $employee->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition">Restore</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $employees->links() }}
                </div>

            </div>
        </main>
    </div>

</body>
</html>