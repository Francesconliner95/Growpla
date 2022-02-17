<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Mail\MailRegistration;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    public function sendEmail(Request $request) {

        $request->validate([
            'email' => 'required|email',
        ]);
        $email = $request->email;
        
        Mail::to($email)
        ->queue(new MailRegistration());
    }

}
