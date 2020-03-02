<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class OrderPlacedNotification extends Notification
{
    use Queueable;

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
        //return ['mail', 'slack'];
        return ['mail'];
    }

    ///**
    // * @return \Illuminate\Notifications\Messages\SlackMessage
    // */
    //public function toSlack(): SlackMessage
    //{
    //    return (new SlackMessage())->from('Online Ordering')->to('#online-ordering')
    //        ->success()
    //        ->content('['.ucfirst(config('app.name')).'] - Order has been placed')
    //        ->attachment(static function ($attachment) {
    //            $attachment->title('Order Number 1322')
    //                ->fields([
    //                    'OrderTrackingLine' => '12',
    //                    'Amount'            => '£1,234',
    //                    'Customer'          => 'SCO100',
    //                    'Was Awesome'       => ':-1:',
    //                ]);
    //        });
    //}

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

        return (new MailMessage())
            ->greeting('Hello, '.$this->user->name)
            ->line('Thank you for your order.')
            //->action('Create password', route('cms.password.reset', $this->token))
            ->line('Some other stuff and things');
    }

    ///**
    // * Get the array representation of the notification.
    // *
    // * @return array
    // */
    //public function toArray()
    //{
    //    return [
    //    ];
    //}
}
