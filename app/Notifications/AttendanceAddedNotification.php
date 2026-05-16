<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AttendanceAddedNotification extends Notification
{
    use Queueable;

    public $attendance;
    public function __construct($attendance)
    {
        $this->attendance = $attendance;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }



    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => 'New attendance added',
            'url' => route('student.attendance.index'),
            'status' => $this->attendance->status,
            'subject_id' => $this->attendance->subject_id,
            'student_id' => $this->attendance->student_id,
        ];
    }
}
