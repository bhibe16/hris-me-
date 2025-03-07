<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EmployeeAPIController extends Controller
{
    public function index()
    {
        try {
            $response = Http::withoutVerifying()->get('https://hr1.gwamerchandise.com/api/employee');
            
            if (!$response->successful()) {
                Log::error('API Request Failed', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                return redirect()->back()->with('error', 'Failed to fetch employees. Status: ' . $response->status());
            }

            $employees = $response->json();
            
            // Validate response structure
            if (!is_array($employees)) {
                throw new \Exception('Invalid API response format');
            }

            return view('admin.newhiredemp.index', [
                'employees' => $employees
            ]);

        } catch (\Exception $e) {
            Log::error('API Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error fetching data: ' . $e->getMessage());
        }
    }
    public function updateStatus(Request $request, $employeeId)
{
    // Validate request
    $request->validate([
        'status' => 'required|in:pending,approved,reject'
    ]);

    // Update logic here (this is where you'd call your API)
    // For demo purposes, we'll just redirect back
    return redirect()->back()
        ->with('success', 'Status updated successfully')
        ->withInput();
}
}