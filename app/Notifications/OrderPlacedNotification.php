<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class OrderPlacedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array
     */
    public function via(): array
    {
        return ['mail', 'slack'];
    }

    /**
     * @return \Illuminate\Notifications\Messages\SlackMessage
     */
    public function toSlack(): SlackMessage
    {
        return (new SlackMessage())->from('Online Ordering')->to('#online-ordering')
            ->success()
            ->content('['.ucfirst(config('app.name')).'] - Order has been placed')
            ->attachment(static function ($attachment) {
                $attachment->title('Order Number 1322')
                    ->fields([
                        'OrderTrackingLine' => '12',
                        'Amount'            => '£1,234',
                        'Customer'          => 'SCO100',
                        'Was Awesome'       => ':-1:',
                    ]);
            });
    }

    /**
     * Get the mail representation of the notification.
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail(): MailMessage
    {
        return (new MailMessage())->line('The introduction to the notification.')->action('Notification Action', url('/'))->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array
     */
    public function toArray()
    {
        return [
        ];
    }
}
