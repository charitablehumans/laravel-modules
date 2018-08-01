<?php

namespace Modules\Users\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class VerificationCodeVerify extends Notification implements ShouldQueue
{
    use Queueable;

    protected $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $view = 'frontend/default/mail/modules/users/verification_code_verify';

        if (view()->exists($view)) {
            app()->setLocale('id');
            $data['actionText'] = trans('cms::cms.verify');
            $data['actionUrl'] = route('frontend.authentication.verify', ['email' => $this->user->email]);
            $data['user'] = $this->user;
            return (new MailMessage)->view($view, $data);
        }

        return (new MailMessage)
            ->line('Please verify and use this verification code: '.$this->user->verification_code.'.')
            ->action(trans('cms::cms.verify'), route('frontend.authentication.verify', ['email' => $this->user->email]))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
