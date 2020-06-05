<?php

namespace App\Notifications;

use App\Exports\ConfirmationPDF;
use App\Models\Customer;
use App\Models\GlobalSettings;
use App\Models\OrderHeader;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Storage;

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

        $this->uploadConfirmation($pdf, $order);

        return (new MailMessage())->subject('Ordering portal - Order Confirmation')
            ->greeting('Hello, '.$this->user->name)
            ->line('Thank you for your order. Your order number is '.$order->order_number.'.')
            ->line('Please find attached your order confirmation.')
            ->line('Please check the contents and report any discrepancies to our sales office on '.$company_details['telephone'].'.')
            ->salutation('Regards, '.ucfirst(config('app.name')))
            ->attachData($pdf, $this->order['order_number'].'.pdf');
    }

    /**
     * @param $pdf
     * @param $order
     */
    public function uploadConfirmation($pdf, $order): void
    {
        $tag = $this->tagFile($order);

        Storage::disk('ftp')->put($order->order_number.'.pdf', $pdf);
        Storage::disk('ftp')->put($order->order_number.'.tag', $tag);
    }

    /**
     * @param $order
     *
     * @return string
     */
    public function tagFile($order): string
    {
        $customer = Customer::where('code', $order->customer_code)->first();

        $ftp_tag = env('FTP_TAG') ? env('FTP_TAG').'_' : '';

        $file = "{$ftp_tag}SALESORDER\r\n";
        $file .= 'ARCH_DATE:'.date('d/m/Y')."\r\n";
        $file .= "ARCH_USER:Devloft\r\n";
        $file .= 'SALES_ORDER_NUMBER:'.$order->order_number."\r\n";
        $file .= 'CUSTOMER_ORDER_NUMBER:'.$order->reference."\r\n";
        $file .= 'CUSTOMER_CODE:'.$order->customer_code."\r\n";
        $file .= 'CUSTOMER_NAME:'.($customer->name ?? 'Unknown')."\r\n";
        $file .= 'AMOUNT:'.$order->value."\r\n";
        $file .= 'USER_NAME:IS';

        return $file;
    }
}
