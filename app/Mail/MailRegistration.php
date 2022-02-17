<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
//use Illuminate\Queue\SerializesModels;

class MailRegistration extends Mailable implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {

    }

    public function build()
    {
        return $this->view('guest.mails.mail-registration-body');

    }
}
