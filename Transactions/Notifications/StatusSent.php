<?php

namespace Modules\Transactions\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Modules\Transactions\Models\Transactions;

class StatusSent extends Notification implements ShouldQueue
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
            ->line(trans('cms::cms.goods_have_been_shipped').'.')
            ->line(trans('cms::cms.transaction_details_are_given_below').':')
            ->line(trans('validation.attributes.transaction_id').': '.$this->transaction->id)
            ->line(trans('validation.attributes.receipt_number').': '.$this->transaction->receipt_number)
            ->line(trans('cms::cms.shipment').': '.$this->transaction->transactionShipment->name.', '.$this->transaction->transactionShipment->service.' ('.$this->transaction->transactionShipment->description.')')
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
