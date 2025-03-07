<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee; // Import Employee model

class EmployeeActivityNotification extends Notification
{
    use Queueable;

    protected $message;
    protected $avatar;
    protected $name;

    public function __construct($message, $avatar, $name)
    {
        $this->message = $message;
        $this->avatar = $avatar;
        $this->name = $name;
    }

    public function via($notifiable)
    {
        return ['database'];
    }
    public function toDatabase($notifiable)
    {
        return [
            'message' => $this->message,
            'url' => route('admin.notifications'),
            'profile' => [
                'avatar' => $this->avatar ?? null, // ✅ This should be the RELATIVE path
                'name' => $this->name ?? 'Admin',
            ],
        ];
    }
}