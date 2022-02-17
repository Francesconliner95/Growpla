<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\MailMessage;
use Illuminate\Support\Facades\Mail;
use App\Account;

class MailController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    // public function mailMessage(Request $request)
    // {
    //     $request->validate([
    //         'mail' => 'required',
    //         'message' => 'required',
    //     ]);
    //
    //     $mail = $request->mail;
    //     $message = $request->message;
    //
    //     Mail::to($mail)->send(new MailMessage($message));
    // }


}
