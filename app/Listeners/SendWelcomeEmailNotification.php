<?php

namespace App\Listeners;

use App\Mail\WelcomeMail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmailNotification
{
    /**
     * Create the event listener.
     */
    public function __construct() {}

    /**
     * Handle the event.
     */
    public function handle(Registered $event): void
    {
        /** @var \App\Models\User $user */
        $user = $event->user;

        Mail::to($user->email)->send(new WelcomeMail($user));
    }
}
