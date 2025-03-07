<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="logout-url" content="{{ route('logout') }}">
    <title>HRIS - Employee History</title>
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
            <div class="bg-white p-6 rounded-lg shadow-lg text-gray-700 max-w-4xl mx-auto">
                <h1 class="text-2xl font-semibold text-gray-800 mb-4">My Documents</h1>

                <!-- Upload Button -->
                <div class="flex justify-end mb-4">
                    <a href="{{ route('employee.documents.upload') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition">
                        + Upload New Document
                    </a>
                </div>

                @if($documents->isEmpty())
                    <p class="text-gray-500 text-center py-4">No documents found.</p>
                @else
                    <div class="overflow-x-auto border rounded-lg">
                        <table class="w-full border-collapse">
                            <thead class="bg-gray-200">
                                <tr>
                                    <th class="text-left p-3">Document Name</th>
                                    <th class="text-left p-3">Uploaded Date</th>
                                    <th class="text-left p-3">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                @foreach($documents as $document)
                                    <tr class="border-b hover:bg-gray-100 transition">
                                        <td class="p-3">
                                            @foreach(App\Models\Document::DOCUMENT_TYPES as $category => $types)
                                                @if(array_key_exists($document->document_type, $types))
                                                    {{ $types[$document->document_type] }}
                                                    @break
                                                @endif
                                            @endforeach
                                        </td>
                                        <td class="p-3">{{ $document->created_at->format('M d, Y') }}</td>
                                        <td class="p-3">
                                            <span class="px-2 py-1 rounded text-white text-sm 
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
                @endif
            </div>
        </main>
    </div>
</body>
</html>
