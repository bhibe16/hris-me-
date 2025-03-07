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
<body class="bg-gray-100 min-h-screen">
    <!-- Navigation Bar -->
    @include('layouts.navigation')

    <div class="flex">
        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Main Content -->
        <main class="flex-1 p-6">
            <div class="max-w-3xl mx-auto bg-white p-6 shadow-md rounded-lg">
                <h2 class="text-xl font-semibold mb-4 text-gray-800">Educational History</h2>

                <form action="{{ route('employee.educational-history.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- School Name -->
                        <div>
                            <label for="school_name" class="block text-sm font-medium text-gray-700">School Name</label>
                            <input type="text" name="school_name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Education Level -->
                        <div>
                            <label for="education_level" class="block text-sm font-medium text-gray-700">Education Level</label>
                            <select name="education_level" id="education_level" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" onchange="toggleFields()">
                                <option value="Junior High">Junior High</option>
                                <option value="Senior High">Senior High</option>
                                <option value="Tertiary">Tertiary</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Start Year -->
                        <div>
                            <label for="start_year" class="block text-sm font-medium text-gray-700">Start Year</label>
                            <input type="date" name="start_year" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- End Year -->
                        <div>
                            <label for="end_year" class="block text-sm font-medium text-gray-700">End Year</label>
                            <input type="date" name="end_year" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>

                    <!-- Graduation Status -->
                    <div>
                        <label for="graduation_status" class="block text-sm font-medium text-gray-700">Graduation Status</label>
                        <select name="graduation_status" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="Completed">Completed</option>
                            <option value="Not Completed">Not Completed</option>
                        </select>
                    </div>

                    <!-- Track/Strand (Only for Senior High) -->
                    <div id="track_strand_field">
                        <label for="track_strand" class="block text-sm font-medium text-gray-700">Track/Strand (For Senior High)</label>
                        <input type="text" name="track_strand" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Program (Only for Tertiary) -->
                    <div id="program_field">
                        <label for="program" class="block text-sm font-medium text-gray-700">Program (For College)</label>
                        <input type="text" name="program" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md shadow-sm hover:bg-blue-700">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
        function toggleFields() {
            const educationLevel = document.getElementById('education_level').value;
            const trackStrandField = document.getElementById('track_strand_field');
            const programField = document.getElementById('program_field');

            if (educationLevel === 'Senior High') {
                trackStrandField.style.display = 'block';
                programField.style.display = 'none';
            } else if (educationLevel === 'Tertiary') {
                trackStrandField.style.display = 'none';
                programField.style.display = 'block';
            } else {
                trackStrandField.style.display = 'none';
                programField.style.display = 'none';
            }
        }

        // Call function on page load to set correct visibility
        window.onload = toggleFields;
    </script>
</body>
</html>
