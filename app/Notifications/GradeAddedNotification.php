<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class GradeAddedNotification extends Notification
{
    use Queueable;

    public $grade;
    public function __construct($grade)
    {
        $this->grade = $grade;
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
            'message' => 'New grade added',
            'url' => route('student.grades.index'),
            'marks' => $this->grade->marks,
            'subject_id' => $this->grade->subject_id,
            'student_id' => $this->grade->student_id,
        ];
    }
}
