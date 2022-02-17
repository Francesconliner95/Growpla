<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
//use Illuminate\Queue\SerializesModels;

class MailNotification extends Mailable implements ShouldQueue
{
    use Queueable;

    public $data;

    public function __construct($_data)
    {
        $this->data = $_data;
    }

    public function build()
    {
        return $this->view('admin.mails.mail-notification-body');

    }
}
