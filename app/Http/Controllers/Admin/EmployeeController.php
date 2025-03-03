<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\EmploymentHistory;
use App\Models\EducationalHistory;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $query = request('search');
    
        // Filter employees based on search query
        $employees = Employee::when($query, function ($q) use ($query) {
            $q->where('user_id', 'like', "%$query%")
              ->orWhere('first_name', 'like', "%$query%")
              ->orWhere('last_name', 'like', "%$query%")
              ->orWhere('status', 'like', "%$query%")
              ->orWhere('email', 'like', "%$query%")
              ->orWhereHas('position', function ($subQuery) use ($query) {
                  $subQuery->where('name', 'like', "%$query%");
              })
              ->orWhereHas('department', function ($subQuery) use ($query) {
                  $subQuery->where('name', 'like', "%$query%");
              });
            })->paginate(8)->withQueryString(); // Keep search query when paginating
    
        $employment = EmploymentHistory::whereIn('user_id', $employees->pluck('user_id'))->get()->groupBy('user_id');
        $educational = EducationalHistory::whereIn('user_id', $employees->pluck('user_id'))->get()->groupBy('user_id');
    
        // 🔥 Check if request is JSON (API) or standard (Blade)
        if (request()->wantsJson()) {
            return response()->json([
                'employees' => $employees->items(), // Removes pagination metadata
                'employment' => $employment,
                'educational' => $educational,
            ]);
        }
    
        // Return Blade view if it's a normal request
        return view('admin.employees.index', compact('employees', 'employment', 'educational'));
    }
    

    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        return redirect()->route('admin.employees.index')->with('success', 'Employee Record deleted successfully.');
    }

    public function archived()
    {
        $employees = Employee::onlyTrashed()->paginate(10);
        return view('admin.employees.archived', compact('employees'));
    }

    public function restore($id)
    {
        $employee = Employee::onlyTrashed()->findOrFail($id);
        $employee->restore();

        return redirect()->route('admin.employees.index')->with('success', 'Employee record restored successfully.');
    }
    public function dashboard()
    {
        // Fetch employee-specific data
        $employee = auth()->user(); // Get the authenticated employee
        $records = $employee->records; // Assuming you have a relationship defined

        return view('employees.dashboard', compact('employees', 'records'));
    }

    public function updateStatus(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:approved,pending,reject'
    ]);

    $employee = Employee::findOrFail($id);
    $employee->status = $request->status;
    $employee->save();

    return response()->json(['success' => true]);
}




}
