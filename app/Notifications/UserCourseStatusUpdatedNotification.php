<?php

namespace App\Notifications;

use App\Enum\Users\StatusEnum;
use App\Models\UserCourse;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class UserCourseStatusUpdatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(private readonly UserCourse $userCourse)
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage|null
    {
        try {
            $statusMessage = match ($this->userCourse->status) {
                StatusEnum::PAID->value => 'telah dibayar',
                StatusEnum::CANCELED->value => 'telah dibatalkan',
                StatusEnum::COMPLETED->value => 'telah selesai',
                default => 'telah diperbarui'
            };

            Log::info('Sending course status update email to: ' . $notifiable->email);

            return (new MailMessage)
                ->subject('Status Course Diperbarui - ' . config('app.name'))
                ->view('emails.userCourseStatusUpdated', [
                    'user' => $notifiable->name,
                    'courseName' => $this->userCourse->course->title,
                    'childName' => $this->userCourse->children->name,
                    'status' => $statusMessage
                ]);
        } catch (\Exception $e) {
            Log::error('Error sending course status update email: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'user_course_id' => $this->userCourse->id,
            'status' => $this->userCourse->status
        ];
    }
}
