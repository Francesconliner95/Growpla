<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Mail\MailRegistration;
use Illuminate\Support\Facades\Mail;
use App\Incubator;
use App\Region;

class HomeController extends Controller
{
    // public function sendEmail(Request $request) {
    //
    //     $request->validate([
    //         'email' => 'required|email',
    //     ]);
    //     $email = $request->email;
    //
    //     Mail::to($email)
    //     ->queue(new MailRegistration());
    // }

    public function getAllIncubators() {

        $incubators = Incubator::where('hidden',null)
            ->join('regions','regions.id','=','incubators.region_id')
            ->select('incubators.*','regions.name as region_name')
            ->orderBy('name')->get();

        return response()->json([
            'success' => true,
            'results' => [
                'incubators' => $incubators,
            ]
        ]);
    }

}
