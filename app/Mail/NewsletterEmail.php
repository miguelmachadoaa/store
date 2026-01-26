<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewsletterEmail extends Mailable
{
    public $content;

    public function __construct($content)
    {
        $this->content = $content;
    }

    public function build()
    {
        return $this->subject('Novedades de nuestra tienda')
                    ->view('emails.newsletter');
    }
}

