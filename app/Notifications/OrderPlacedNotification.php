<?php

namespace App\Notifications;

use App\Exports\ConfirmationPDF;
use App\Models\GlobalSettings;
use App\Models\OrderHeader;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class OrderPlacedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $order;

    public $collection_message;

    public $user;

    /**
     * Create a new notification instance.
     *
     * @param $order
     * @param $collection_message
     */
    public function __construct($order, $collection_message)
    {
        $this->order = $order;

        $this->collection_message = $collection_message;

        $this->user = auth()->user();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param $notifiable
     *
     * @return array
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable): MailMessage
    {
        $order = OrderHeader::where('customer_code', $this->order['customer_code'])
            ->where('order_number', decodeUrl($this->order['order_number']))->firstOrFail();

        $company_details = json_decode(GlobalSettings::key('company-details'), true);

        $pdf = (new ConfirmationPDF($order, $this->collection_message, $this->user->id))->download(false);

        return (new MailMessage())->subject('Ordering portal - Order Confirmation')
            ->greeting('Hello, '.$this->user->name)
            ->line('Thank you for your order. Your order number is '.$order->order_number.'.')
            ->line('Please find attached your order confirmation.')
            ->line('Please check the contents and report any discrepancies to our sales office on '.$company_details['telephone'].'.')
            ->salutation('Regards, '.ucfirst(config('app.name')))
            ->attachData($pdf, $this->order['order_number'].'.pdf');
    }
}
