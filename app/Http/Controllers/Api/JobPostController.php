<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class JobPostController extends Controller
{
    public function index()
    {
        $token = 'API TOKEN HERE'; // Replace with your actual token
        
        $response = Http::withToken($token)
            ->withoutVerifying()
            ->get('https://hr1.gwamerchandise.com/api/jobpost'); // Update API endpoint for job posts

        if ($response->successful()) {
            $jobPosts = $response->json(); // Convert API response to an array
            return view('admin.jobpost.index', compact('jobPosts')); // FIXED: Match variable name
        } else {
            return back()->with('error', 'Failed to fetch job post data.');
        }
    }
}
