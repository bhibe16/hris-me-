<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="logout-url" content="{{ route('logout') }}">
    <title>HRIS - Edit Educational History</title>
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
                <h2 class="text-xl font-semibold mb-4 text-gray-800">Edit Educational History</h2>

                <form action="{{ route('employee.educational-history.update', $education->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- School Name -->
                        <div>
                            <label for="school_name" class="block text-sm font-medium text-gray-700">School Name</label>
                            <input type="text" name="school_name" value="{{ $education->school_name }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Education Level -->
                        <div>
                            <label for="education_level" class="block text-sm font-medium text-gray-700">Education Level</label>
                            <select name="education_level" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="Junior High" {{ $education->education_level == 'Junior High' ? 'selected' : '' }}>Junior High</option>
                                <option value="Senior High" {{ $education->education_level == 'Senior High' ? 'selected' : '' }}>Senior High</option>
                                <option value="Tertiary" {{ $education->education_level == 'Tertiary' ? 'selected' : '' }}>Tertiary</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Start Year -->
                        <div>
                            <label for="start_year" class="block text-sm font-medium text-gray-700">Start Year</label>
                            <input type="date" name="start_year" value="{{ $education->start_year }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- End Year -->
                        <div>
                            <label for="end_year" class="block text-sm font-medium text-gray-700">End Year</label>
                            <input type="date" name="end_year" value="{{ $education->end_year }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>

                    <!-- Graduation Status -->
                    <div>
                        <label for="graduation_status" class="block text-sm font-medium text-gray-700">Graduation Status</label>
                        <select name="graduation_status" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="Completed" {{ $education->graduation_status == 'Completed' ? 'selected' : '' }}>Completed</option>
                            <option value="Not Completed" {{ $education->graduation_status == 'Not Completed' ? 'selected' : '' }}>Not Completed</option>
                        </select>
                    </div>

                    <!-- Track/Strand (Only for Senior High) -->
                    <div>
                        <label for="track_strand" class="block text-sm font-medium text-gray-700">Track/Strand (For Senior High)</label>
                        <input type="text" name="track_strand" value="{{ $education->track_strand }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Program (Only for College) -->
                    <div>
                        <label for="program" class="block text-sm font-medium text-gray-700">Program (For College)</label>
                        <input type="text" name="program" value="{{ $education->program }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('employee.records.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md shadow-sm hover:bg-gray-600">Cancel</a>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md shadow-sm hover:bg-blue-700">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const educationLevel = document.querySelector('select[name="education_level"]');
        const trackStrandField = document.querySelector('input[name="track_strand"]').closest('div');
        const programField = document.querySelector('input[name="program"]')?.closest('div');

        function toggleFields() {
            const selectedLevel = educationLevel.value;

            if (selectedLevel === "Junior High") {
                trackStrandField.style.display = "none";
                if (programField) programField.style.display = "none";
            } else if (selectedLevel === "Senior High") {
                trackStrandField.style.display = "block";
                if (programField) programField.style.display = "none";
            } else if (selectedLevel === "Tertiary") {
                trackStrandField.style.display = "none";
                if (programField) programField.style.display = "block";
            }
        }

        // Initial call to set the correct visibility when editing
        toggleFields();

        // Listen for changes
        educationLevel.addEventListener("change", toggleFields);
    });
</script>

</body>
</html>
