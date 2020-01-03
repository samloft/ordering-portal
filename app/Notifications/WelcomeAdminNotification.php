<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Password;

class WelcomeAdminNotification extends Notification
{
    use Queueable;

    /** @var \App\Models\Admin */
    public $admin;

    /** @var string */
    public $token;

    /**
     * Create a new notification instance.
     *
     * @param $admin
     */
    public function __construct($admin)
    {
        $this->admin = $admin;

        $this->token = Password::getRepository()->create($admin);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
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
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->greeting('Hello, '.$this->admin->name)
            ->line('You have had an CMS admin account created for you, now you will need to set a password for your account be clicking the button below.')
            ->action('Create password', route('cms.password.reset', $this->token))
            ->line('This link will only be active for 1 Hour, after you will need to perform a manual reset by clicking "Reset Password" on the login page!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return [//
        ];
    }
}
