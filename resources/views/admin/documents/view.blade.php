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
<body class="main-content min-h-screen flex flex-col bg-gray-100">

    <!-- Navigation Bar -->
    @include('layouts.navigation')

    <div class="flex flex-grow">
        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Centered Card Container -->
        <div class="flex flex-grow justify-center items-center p-6">
            <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-4xl">
                <h1 class="text-2xl font-bold text-gray-800 mb-4">Document: {{ $document->document_name }}</h1>

                <!-- Display Document Based on Type -->
                <div class="mb-6 border border-gray-300 rounded-lg overflow-hidden">
                    @if($isPdf)
                        <!-- Display PDF with modified width and height -->
                        <iframe src="{{ $documentUrl }}" width="100%" height="600px" class="rounded-lg"></iframe>
                    @elseif($isImage)
                        <!-- Display Image -->
                        <img src="{{ $documentUrl }}" alt="Document Image" class="w-full rounded-lg">
                    @elseif($isDoc)
                        <!-- Display DOC/DOCX -->
                        <p class="text-gray-600">This document is in DOC/DOCX format. You can <a href="{{ $documentUrl }}" class="text-blue-600 hover:underline">download the file</a> to view it.</p>
                    @else
                        <p class="text-gray-600">Document type is not supported for viewing.</p>
                    @endif
                </div>

                <!-- Document Details -->
                <div class="text-gray-700 mb-4">
                    <p><strong>Document Type:</strong> 
                        @foreach(App\Models\Document::DOCUMENT_TYPES as $category => $types)
                            @if(array_key_exists($document->document_type, $types))
                                {{ $types[$document->document_type] }}
                                @break
                            @endif
                        @endforeach
                    </p>
                    <p><strong>Status:</strong> {{ ucfirst($document->status) }}</p>
                    <p><strong>Uploaded by:</strong> {{ $document->user->name }}</p>
                </div>

                <!-- Approval/Rejection Form -->
                <form action="{{ route('admin.documents.review', $document) }}" method="POST" class="mt-6 bg-gray-50 p-6 rounded-lg shadow-md">
                    @csrf
                    <label for="status" class="block font-semibold mb-2 text-gray-700">Review Document:</label>

                    <select name="status" class="w-full p-3 border rounded-md focus:ring-blue-500 focus:border-blue-500">
                        <option value="approved" {{ $document->status == 'approved' ? 'selected' : '' }}>Approve</option>
                        <option value="rejected" {{ $document->status == 'rejected' ? 'selected' : '' }}>Reject</option>
                    </select>

                    <textarea name="rejection_comment" placeholder="Rejection Reason (if any)" 
                              class="w-full mt-3 p-3 border rounded-md focus:ring-red-500 focus:border-red-500"></textarea>

                    <button type="submit" 
                            class="mt-4 w-full bg-blue-600 text-white px-5 py-2 rounded-lg shadow-md hover:bg-blue-700 transition">
                        Submit
                    </button>
                </form>

                <!-- Back Button -->
                <div class="mt-4 text-center">
                    <a href="{{ route('admin.documents.index') }}" class="text-blue-600 font-medium hover:underline hover:text-blue-800 transition">
                        ← Back to Documents
                    </a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
