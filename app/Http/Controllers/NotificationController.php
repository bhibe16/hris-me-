<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee; // Import Employee model

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()->notifications; // Fetch all notifications
        $employee = Employee::where('user_id', Auth::id())->first(); // Get employee data

        return view('admin.notifications', compact('notifications', 'employee')); // Pass to view
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return back()->with('success', 'All notifications marked as read.');
    }

    public function deleteSelected(Request $request)
    {
        $notificationIds = explode(',', $request->selected_notifications);
        Auth::user()->notifications()->whereIn('id', $notificationIds)->delete();
        return back()->with('success', 'Selected notifications deleted.');
    }

    // ✅ Store notification with Employee profile picture
    public function toDatabase($notifiable)
    {
        $employee = Employee::where('user_id', auth()->id())->first(); // Get employee record

        return [
            'message' => auth()->user()->name . " has updated their profile.",
            'profile' => [
                'name' => auth()->user()->name,
                'avatar' => $employee && $employee->profile_picture
                    ? asset('storage/' . $employee->profile_picture)
                    : asset('default-avatar.png'),
            ],
            'url' => route('employee.profile', auth()->id()),
        ];
    }
}
