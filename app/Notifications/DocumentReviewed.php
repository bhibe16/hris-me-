<?php

namespace App\Notifications;

use App\Models\Document;
use Illuminate\Notifications\Notification;

class DocumentReviewed extends Notification
{
    protected $document;

    public function __construct(Document $document)
    {
        $this->document = $document;
    }

    // Use the database channel to store the notification in the database
    public function via($notifiable)
    {
        return ['database'];
    }

    // Store the notification content in the database
    public function toDatabase($notifiable)
    {
        return [
            'document_name' => $this->document->document_name,
            'status' => $this->document->status,
            'rejection_comment' => $this->document->rejection_comment,
            'message' => $this->document->status == 'approved'
                ? 'Your document has been approved.'
                : 'Your document has been rejected.',
        ];
    }
}

