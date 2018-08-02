<?php

namespace Modules\Transactions\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Modules\Transactions\Models\Transactions;

class PaymentStatusTrue extends Notification implements ShouldQueue
{
    use Queueable;

    protected $transaction;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Transactions $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line(trans('cms::cms.payment_success').'.')
            ->line(trans('cms::cms.transaction_details_are_given_below').':')
            ->line(trans('validation.attributes.transaction_id').': '.$this->transaction->id)
            ->line(trans('validation.attributes.amount').': '.number_format($this->transaction->grand_total))
            ->line(trans('validation.attributes.payment_status').': '.trans('cms::cms.success'))
            // ->action('Notification Action', 'https://laravel.com')
            ->line(trans('cms::cms.thank_you_for_using_our_application').'!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
