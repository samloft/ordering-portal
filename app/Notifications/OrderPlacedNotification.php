<?php

namespace App\Notifications;

use App\Models\GlobalSettings;
use App\Models\OrderHeader;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderPlacedNotification extends Notification
{
    public $order;

    public $user;

    /**
     * Create a new notification instance.
     *
     * @param $order
     */
    public function __construct($order)
    {
        $this->order = $order;

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
        //return (new MailMessage())->line('The introduction to the notification.')->action('Notification Action', url('/'))->line('Thank you for using our application!');

        $order = OrderHeader::where('customer_code', auth()->user()->customer->code)->where('order_number', decodeUrl($this->order['order_number']))->firstOrFail();
        $company_details = json_decode(GlobalSettings::key('company-details'), true);

        $pdf = PDF::loadView('pdf.order', compact('order', 'company_details'))->output();

        return (new MailMessage())
            ->subject('Ordering portal - Order Confirmation')
            ->greeting('Hello, '.$this->user->name)
            ->line('Thank you for your order.')
            ->line('Some other stuff and things')
            ->attachData($pdf, $this->order['order_number'].'.pdf');
    }
}
