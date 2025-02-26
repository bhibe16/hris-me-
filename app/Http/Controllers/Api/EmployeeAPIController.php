<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class EmployeeAPIController extends Controller
{
    public function index()
    {
        $token = 'API TOKEN HERE'; // Insert your token here, contact Julius for the token
        
        $response = Http::withToken($token)->withoutVerifying()->get('https://hr1.gwamerchandise.com/api/employee/');
        
        if ($response->successful()) {
            $data = $response->json(); // Convert API response to an array
            return view('admin.index', compact('data')); // Pass data into your Blade file
        } else {
            return back()->with('error', 'Failed to fetch employee data.');
        }
    }
}
