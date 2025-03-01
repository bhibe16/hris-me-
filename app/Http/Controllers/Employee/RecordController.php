<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Position;
use App\Notifications\EmployeeActivityNotification;
use App\Models\User;

class RecordController extends Controller
{
    public function index()
    {
        // Fetch the employee record for the authenticated user
        $record = Employee::where('user_id', auth()->user()->user_id)->get();
        return view('employee.records.index', compact('record'));
    }

    public function create()
    {
        // Check if the employee already has a record
        $existingRecord = Employee::where('user_id', auth()->user()->user_id)->first();

        if ($existingRecord) {
            return redirect()->route('employee.records.index')
                            ->with('error', 'You already have an existing record.');
        }

        // Fetch departments with their positions
        $departments = Department::with('positions')->get();

        return view('employee.records.create', [
            'userEmail' => auth()->user()->email,
            'departments' => $departments // ✅ Pass departments to the view
        ]);
    }

    public function store(Request $request)
    {
        // Check if the employee already has a record
        $existingRecord = Employee::where('user_id', auth()->user()->user_id)->first();

        if ($existingRecord) {
            return redirect()->route('employee.records.index')
                            ->with('error', 'You can only create one record.');
        }

        // Validate the request
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:employees',
            'department' => 'required|exists:departments,id',
            'position' => 'required|exists:positions,id',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:500',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|string|max:50',
            'nationality' => 'nullable|string|max:100',
            'marital_status' => 'nullable|string|max:50',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'employment_status' => 'nullable|string|max:50',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Handle profile picture upload
        $profilePicturePath = null;
        if ($request->hasFile('profile_picture')) {
            $profilePicturePath = $request->file('profile_picture')->store('profile_pictures', 'public');
        }

        // Create the employee record
        Employee::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'middle_name' => $request->middle_name,
            'email' => auth()->user()->email,
            'department_id' => $request->department, // ✅ Store department ID
            'position_id' => $request->position,    // ✅ Store position ID
            'phone' => $request->phone,
            'address' => $request->address,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'nationality' => $request->nationality,
            'marital_status' => $request->marital_status,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'employment_status' => $request->employment_status,
            'user_id' => auth()->user()->user_id, // ✅ Use custom user_id
            'profile_picture' => $profilePicturePath,
        ]);

        // Notify admins
        $admin = User::where('role', 'admin')->get(); // Fetch admin users
        foreach ($admin as $admin) {
            $admin->notify(new EmployeeActivityNotification(
                auth()->user()->name . " has created a new employee record."
            ));
        }

        return redirect()->route('employee.records.index')->with('success', 'Employee record created successfully.');
    }

    public function edit($id)
    {
        // Fetch the employee record for editing
        $record = Employee::where('user_id', auth()->user()->user_id)
            ->with(['department', 'position']) // ✅ Load department and position relationships
            ->findOrFail($id);

        // Fetch all departments and positions
        $departments = Department::all();
        $positions = Position::all();

        return view('employee.records.edit', compact('record', 'departments', 'positions'));
    }

    public function update(Request $request, $id)
    {
        // Validate the request
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $id,
            'department_id' => 'required|exists:departments,id',
            'position_id' => 'required|exists:positions,id',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:500',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|string|max:50',
            'nationality' => 'nullable|string|max:100',
            'marital_status' => 'nullable|string|max:50',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'employment_status' => 'nullable|string|max:50',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Fetch the employee record
        $record = Employee::where('user_id', auth()->user()->user_id)->findOrFail($id);

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            // Delete the old profile picture if it exists
            if ($record->profile_picture) {
                Storage::disk('public')->delete($record->profile_picture);
            }

            // Store the new profile picture
            $profilePicturePath = $request->file('profile_picture')->store('profile_pictures', 'public');
            $validatedData['profile_picture'] = $profilePicturePath;
        }

        // Update the employee record
        $record->update($validatedData);

        // Notify admins
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new EmployeeActivityNotification(
                auth()->user()->name . " has updated an employee record."
            ));
        }

        return redirect()->route('employee.records.index')->with('success', 'Record updated successfully.');
    }

    public function destroy($id)
    {
        // Fetch and delete the employee record
        $record = Employee::where('user_id', auth()->user()->user_id)->findOrFail($id);
        $record->delete();

        return redirect()->route('employee.records.index')->with('success', 'Record deleted successfully.');
    }
}