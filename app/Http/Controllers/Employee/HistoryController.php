<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmploymentHistory;

class HistoryController extends Controller
{
    public function index()
    {
        $history = EmploymentHistory::where('user_id', auth()->user()->user_id)->get();
    
        return view('employee.records.index', compact('history'));
    }

    public function create()
    {
        // Check if the employee has already created 3 records
        $existingRecords = EmploymentHistory::where('user_id', auth()->user()->user_id)->count();
    
        if ($existingRecords >= 3) {
            // Redirect to the history index with an error message if they have 3 records
            return redirect()->route('employee.records.index')
                             ->with('error', 'You can only have a maximum of 3 history records.');
        }
    
        return view('employee.history.create');
    }

    public function destroy($id)
    {
        // Fetch the record that belongs to the authenticated user
        $record = EmploymentHistory::where('user_id', auth()->user()->user_id)->findOrFail($id);

        // Delete the record
        $record->delete();

        return redirect()->route('employee.records.index')->with('success', 'History deleted successfully.');
    }

    public function store(Request $request)
    {
        // Check if the employee has already created 3 records
        $existingRecords = EmploymentHistory::where('user_id', auth()->user()->user_id)->count();
    
        if ($existingRecords >= 3) {
            // Redirect back with an error message if the employee already has 3 history records
            return redirect()->route('employee.records.index')
                             ->with('error', 'You can only have a maximum of 3 history records.');
        }
    
        // Validate input data
        $request->validate([
            'company_name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);
    
        // Create the employee history
        EmploymentHistory::create([
            'company_name' => $request->company_name,
            'position' => $request->position,
            'address' => $request->address,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'user_id' => auth()->user()->user_id, // Associate with the authenticated user
        ]);
    
        // Redirect to the history index with a success message
        return redirect()->route('employee.records.index')->with('success', 'Employee history created successfully.');
    }

    // Show the form for editing an employee's history
    public function edit($id)
    {
        // Fetch the history that belongs to the authenticated user
        $record = EmploymentHistory::where('user_id', auth()->user()->user_id)->findOrFail($id);

        // Return the view with the history data
        return view('employee.history.edit', compact('record'));
    }

    // Update an employee's history
    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'company_name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);
    
        $record = EmploymentHistory::where('user_id', auth()->user()->user_id)
        ->where('id', $id)
        ->firstOrFail();
    
        // Update the record
        $record->update([
            'company_name' => $request->company_name,
            'position' => $request->position,
            'address' => $request->address,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);
        return redirect()->route('employee.records.index')->with('success', 'History updated successfully.');
    }
}
