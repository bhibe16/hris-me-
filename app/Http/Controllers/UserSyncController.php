<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserSyncController extends Controller
{
    public function syncUsers()
    {
        try {
            // Fetch data from API
            $response = Http::get('https://admin.gwamerchandise.com/api/users');

            if ($response->successful()) {
                $users = $response->json()['users'] ?? []; // Ensure 'users' key exists

                foreach ($users as $userData) {
                    // Ensure phoneNumber is not null
                    $phoneNumber = $userData['phoneNumber'] ?? 'N/A';

                    // Ensure all required fields exist
                    $user = User::updateOrCreate(
                        ['email' => $userData['email']], // Prevent duplicate emails
                        [
                            'name'        => $userData['name'] ?? 'Unknown',
                            'email'       => $userData['email'],
                            'role'        => $userData['role'] ?? 'user',
                            'status'      => $userData['status'] ?? 'Inactive',
                            'phoneNumber' => $phoneNumber,
                            'address'     => $userData['address'] ?? 'Not Provided',
                            'profilePic'  => $userData['profilePic'] ?? null,
                            'coverPic'    => $userData['coverPic'] ?? null,
                            'created_at'  => optional($userData)['createdAt'] ?? now(),
                            'updated_at'  => optional($userData)['updatedAt'] ?? now(),
                            'password'    => Hash::make('password'), // Secure default password
                        ]
                    );
                }

                return response()->json(['message' => 'Users synchronized successfully']);
            }

            Log::error('User Sync Error: API request failed');
            return response()->json(['error' => 'Failed to fetch users'], 500);
        } catch (\Exception $e) {
            Log::error('User Sync Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'An error occurred while syncing users'], 500);
        }
    }
}
