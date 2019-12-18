<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Password;

class Welcome extends Mailable
{
    use Queueable, SerializesModels;

    /** @var \App\Models\User */
    public $user;

    /** @var string */
    public $token;

    /**
     * Create a new message instance.
     *
     * @param \App\Models\User $user
     */
    public function __construct($user)
    {
        $this->user = $user;

        $this->token = Password::getRepository()->create($user);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): self
    {
        return $this
            ->to($this->user->email)
            ->subject('Welcome to '.ucfirst(config('app.name')).' ordering portal')
            ->markdown('mails.welcome');
    }
}
