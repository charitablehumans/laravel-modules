<?php

namespace Modules\Transactions\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Modules\Transactions\Models\Transactions;

class StatusNew extends Notification implements ShouldQueue
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
            ->line(trans('cms::cms.you_get_a_new_order').'.')
            ->line(trans('cms::cms.transaction_details_are_given_below').':')
            ->line(trans('validation.attributes.transaction_id').': '.$this->transaction->id)
            ->line(trans('validation.attributes.payment_date').': '.$this->transaction->payment_date)
            ->line(trans('validation.attributes.amount').': '.number_format($this->transaction->grand_total))
            ->action(trans('cms::cms.view'), route('backend.transactions.'.$this->transaction->type.'.show', $this->transaction->id))
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
