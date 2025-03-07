<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EducationalHistory;

class EducationalHistoryController extends Controller
{

    public function index()
    {
        // Fetch educational history records for the authenticated user
        $educationalHistory = EducationalHistory::where('user_id', auth()->user()->user_id)->get();

        return view('employee.records.index', compact( 'educationalHistory'));
    }

    // Show the form to create educational history
    public function createEducation()
    {
        // Check if the user has already created 3 education records
        $existingEducationRecords = EducationalHistory::where('user_id', auth()->user()->user_id)->count();

        if ($existingEducationRecords >= 3) {
            return redirect()->route('employee.records.index')
                             ->with('error', 'You can only have a maximum of 3 education history records.');
        }

        return view('employee.educational-history.create');
    }

    // Store educational history
    public function storeEducation(Request $request)
    {
        // Validate input data
        $request->validate([
            'school_name' => 'required|string|max:255',
            'education_level' => 'required|string|max:255', // 'Junior High', 'Senior High', or 'Tertiary'
            'start_year' => 'nullable|date',
            'end_year' => 'nullable|date',
            'graduation_status' => 'required|string|in:Completed,Not Completed',
            'track_strand' => 'nullable|string|max:255', // Only for Senior High
            'program' => 'nullable|string|max:255', // Only for Senior High
        ]);

        // Create educational history record
        EducationalHistory::create([
            'school_name' => $request->school_name,
            'education_level' => $request->education_level,
            'start_year' => $request->start_year,
            'end_year' => $request->end_year,
            'graduation_status' => $request->graduation_status,
            'track_strand' => $request->track_strand,
            'program' => $request->program,
            'user_id' => auth()->user()->user_id, // Associate with the authenticated user
        ]);

        return redirect()->route('employee.records.index')->with('success', 'Educational history created successfully.');
    }

    // Edit an educational history
    public function editEducation($id)
    {
        // Fetch the educational history for the authenticated user
        $education = EducationalHistory::where('user_id', auth()->user()->user_id)->findOrFail($id);

        return view('employee.educational-history.edit', compact('education'));
    }

    // Update educational history
    public function updateEducation(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'school_name' => 'required|string|max:255',
            'education_level' => 'required|string|max:255',
            'start_year' => 'nullable|date',
            'end_year' => 'nullable|date',
            'graduation_status' => 'required|string|in:Completed,Not Completed',
            'track_strand' => 'nullable|string|max:255', // Only for Senior High
            'program' => 'nullable|string|max:255',
        ]);

        // Fetch the record for the authenticated user
        $education = EducationalHistory::where('user_id', auth()->user()->user_id)->findOrFail($id);

        // Update the educational history record
        $education->update([
            'school_name' => $request->school_name,
            'education_level' => $request->education_level,
            'start_year' => $request->start_year,
            'end_year' => $request->end_year,
            'graduation_status' => $request->graduation_status,
            'track_strand' => $request->track_strand,
            'program' => $request->track_strand,
        ]);

        return redirect()->route('employee.records.index')->with('success', 'Educational history updated successfully.');
    }

    // Delete educational history record
    public function destroyEducation($id)
    {
        // Fetch the record that belongs to the authenticated user
        $education = EducationalHistory::where('user_id', auth()->user()->user_id)->findOrFail($id);

        // Delete the record
        $education->delete();

        return redirect()->route('employee.records.index')->with('success', 'Educational history deleted successfully.');
    }
}

