<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    // Admin: View all documents that need to be reviewed
    public function index(Request $request)
    {
        $status = $request->query('status', 'pending'); // Default to 'pending'
        
        $documents = Document::when($status !== 'all', function ($query) use ($status) {
            return $query->where('status', $status);
        })->get();

        
        return view('admin.documents.index', compact('documents', 'status'));
    }

    // Admin: Review a document (approve/reject)
    public function review(Document $document, Request $request)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'rejection_comment' => 'nullable|string|max:500',
        ]);

        $document->update([
            'status' => $request->status,
            'rejection_comment' => $request->status == 'rejected' ? $request->rejection_comment : null,
        ]);

        // Notify the employee about the document review status (Notification)
        $document->user->notify(new \App\Notifications\DocumentReviewed($document));

        return back()->with('success', 'Document review status updated!');
    }

    public function viewDocument(Document $document)
    {
        // Check if the user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login');
        }
    
        // Show 403 if user is not an admin
        if (auth()->user()->role !== 'admin' && auth()->user()->role !== 'hr3') {
            abort(403, 'Unauthorized access');
        }
        
        // Get the URL of the document stored in the public directory
        $documentUrl = asset('storage/' . $document->file_path);
    
        // Check the file type (PDF, DOC, DOCX)
        $fileExtension = pathinfo($document->file_path, PATHINFO_EXTENSION);
        $isPdf = in_array($fileExtension, ['pdf']);
        $isDoc = in_array($fileExtension, ['doc', 'docx']);
        $isImage = in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']);
    
        return view('admin.documents.view', compact('documentUrl', 'isPdf', 'isDoc', 'isImage', 'document'));
    }
    public function apiIndex()
    {
        $documents = Document::all();
    
        return response()->json([
            'documents' => $documents
        ], 200);
    }

}

