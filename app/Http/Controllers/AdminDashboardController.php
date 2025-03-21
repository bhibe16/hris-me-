<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Get the total number of employees
        $totalEmployees = Employee::count();
        $statusCounts = Employee::select('status', \DB::raw('count(*) as count'))
        ->groupBy('status')
        ->pluck('count', 'status');
    
    // Pass the data to the dashboard view
    return view('admin.dashboard', [
        'totalEmployees' => $totalEmployees,
        'statusCounts' => $statusCounts // Add this line
    ]);
      
    }
}

