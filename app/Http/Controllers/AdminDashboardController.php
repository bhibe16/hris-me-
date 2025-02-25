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

        // Pass the data to the dashboard view
        return view('admin.dashboard', [
            'totalEmployees' => $totalEmployees
        ]);
    }
}

