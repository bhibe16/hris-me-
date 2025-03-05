<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Employee;


class DocumentController extends Controller
{
    // Display the document upload form
    public function showForm()
    {
        return view('employee.documents.upload');
    }

    // Store a newly created document
    public function store(Request $request)
{
    $request->validate([
        'document_type' => 'required|string|max:255', // ✅ Validate document type
        'document_file' => 'required|file|mimes:pdf,jpeg,png|max:2048',
    ]);

    if ($request->hasFile('document_file') && $request->file('document_file')->isValid()) {
        $file = $request->file('document_file');
        $path = $file->storeAs('documents', time() . '-' . $file->getClientOriginalName(), 'public');

        // ✅ Fetch employee details from the employees table
        $employee = Employee::where('user_id', auth()->user()->user_id)->first();

        if (!$employee) {
            return back()->with('error', 'Employee record not found.');
        }
        \Log::info('Employee Found:', ['id' => $employee->id, 'user_id' => $employee->user_id]);

        // ✅ Save document details in the database
        Document::create([
            'user_id' => $employee->user_id, // ✅ Store user_id from employees table
            'first_name' => $employee->first_name, // ✅ Store first name
            'last_name' => $employee->last_name, // ✅ Store last name
            'document_type' => $request->document_type, // ✅ Store document type
            'file_path' => $path,
            'status' => 'pending', // Default status
        ]);

        return redirect()->route('employee.documents.index')->with('success', 'Document uploaded successfully!');
    }

    return back()->with('error', 'Failed to upload the document.');
}


    // View all documents uploaded by the employee
    public function index()
    {
        $documents = Document::where('user_id', auth()->user()->user_id)->get(); // ✅ Use custom user_id
        return view('employee.documents.index', compact('documents'));
    }

    // Delete a document
    public function destroy($id)
    {
        $document = Document::where('user_id', auth()->user()->user_id)->findOrFail($id);

        // Delete the file from storage
        Storage::disk('public')->delete($document->file_path);

        // Delete the document record from the database
        $document->delete();

        return redirect()->route('employee.documents.index')->with('success', 'Document deleted successfully.');
    }
}
