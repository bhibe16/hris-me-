<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PayslipController extends Controller
{
    public function index()
    {
        $token = 'API TOKEN HERE'; // Replace with your actual token
        
        $response = Http::withToken($token)
            ->withoutVerifying()
            ->get('https://hr4.gwamerchandise.com/pages/api/payslip_api.php'); // Update API endpoint for payslips

        if ($response->successful()) {
            $payslips = $response->json(); // Convert API response to an array
            return view('admin.payslip.index', compact('payslips')); // Pass data to Blade view
        } else {
            return back()->with('error', 'Failed to fetch payslip data.');
        }
    }
}
