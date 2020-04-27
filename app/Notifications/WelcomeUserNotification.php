<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Password;

class WelcomeUserNotification extends Notification
{
    use Queueable;

    protected $user;

    protected $token;

    /**
     * Create a new notification instance.
     *
     * @param \App\Models\User $user
     */
    public function __construct($user)
    {
        $this->user = $user;

        $this->token = Password::getRepository()->create($user);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)->subject('Welcome to '.ucfirst(config('app.name')).' ordering portal')
            ->greeting('Hello, '.$this->user->name)
            ->line('Your ordering portal account has now been activated for '.config('app.url'))
            ->line('You will need to set a password before you can use the account, click the button below to do so.')
            ->action('Set your password', config('app.url').'/password/reset/'.$this->token.'?email='.$this->user->email)
            ->line('This link will only be active for 1 Hour, after you will need to perform a manual reset by clicking "Reset Password" on the login page!')
            ->line('Thank you for joining us!')->salutation('Regards, '.ucfirst(config('app.name')));
    }
}
