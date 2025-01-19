<?php

namespace App\Notifications;

use Carbon\Carbon;
use Closure;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Log;



class ResetPasswordNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private string $token;

    /**
     * The callback that should be used to create the reset password URL.
     *
     * @var Closure|null
     */
    public static ?Closure $createUrlCallback;

    /**
     * The callback that should be used to build the mail message.
     *
     * @var Closure|null
     */
    public static ?Closure $toMailCallback;

    /**
     * Create a new notification instance.
     */
    public function __construct($token)
    {
        $this->token = $token;
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
     * Get the reset URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    protected function resetUrl(mixed $notifiable): string
    {
        if (static::$createUrlCallback) {
            return call_user_func(static::$createUrlCallback, $notifiable, $this->token);
        }

        return url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));
    }



    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage|null
    {
        try {
            if (static::$toMailCallback) {
                return call_user_func(static::$toMailCallback, $notifiable, $this->token);
            }

            $resetPasswordUrl = $this->resetUrl($notifiable);


            Log::info('Sending verification email to: ' . $notifiable->email);

            return (new MailMessage)
                ->subject('Welcome to ' . config('app.name') . ' - Reset Password Link')
                ->view('emails.resetPassword', [
                    'user' => $notifiable->name,
                    'resetPasswordUrl' => $resetPasswordUrl,
                ]);
        } catch (\Exception $e) {
            Log::error('Error sending verification email: ' . $e->getMessage());
            return null;
        }
    }


    /**
     * Set a callback that should be used when creating the reset password button URL.
     *
     * @param Closure $callback
     * @return void
     */
    public static function createUrlUsing(Closure $callback): void
    {
        static::$createUrlCallback = $callback;
    }

    /**
     * Set a callback that should be used when building the notification mail message.
     *
     * @param Closure $callback
     * @return void
     */
    public static function toMailUsing(Closure $callback): void
    {
        static::$toMailCallback = $callback;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
