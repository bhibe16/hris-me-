<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="logout-url" content="{{ route('logout') }}">
    <title>HRIS - Upload Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    <!-- Navigation Bar -->
    @include('layouts.navigation')

    <div class="flex flex-grow">
        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Main Content -->
        <main class="flex-grow p-6 sm:p-12">
            <div class="bg-white p-8 rounded-xl shadow-md text-gray-800 max-w-2xl mx-auto">
                <h1 class="text-3xl font-bold mb-6 text-center">Upload New Document</h1>

                <!-- Upload Form -->
                <form action="{{ route('employee.documents.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Document Type -->
                    <div>
                        <label for="document_type" class="block text-sm font-semibold text-gray-700 mb-2 capitalize">Document Type</label>
                        <select name="document_type" id="document_type" required
                                class="w-full p-3 border rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="" disabled selected>Select Document Type</option>
                            @foreach(App\Models\Document::DOCUMENT_TYPES as $category => $types)
                                <optgroup label="{{ ucfirst(str_replace('_', ' ', $category)) }}">
                                    @foreach($types as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>

                    <!-- Document File -->
                    <div>
                        <label for="document_file" class="block text-sm font-semibold text-gray-700 mb-2">Document File (PDF/JPG/PNG only)</label>
                        <input type="file" name="document_file" id="document_file" required
                               accept=".pdf,.jpg,.jpeg,.png"
                               class="w-full p-3 border rounded-lg shadow-sm bg-white cursor-pointer focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-center">
                        <button type="submit" 
                                class="bg-blue-600 text-white px-6 py-3 rounded-lg shadow-lg hover:bg-blue-700 transition-all">
                            Upload Document
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.querySelector('form');
            
            form.addEventListener('submit', function (e) {
                const selectedOption = document.querySelector('#document_type').value;
                
                // Capitalize the selected option value before submitting
                const capitalizedValue = selectedOption.split('_').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join('_');
                
                // Set the capitalized value back to the select element
                document.querySelector('#document_type').value = capitalizedValue;
            });
        });
    </script>

</body>
</html>
