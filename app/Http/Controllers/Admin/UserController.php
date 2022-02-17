<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ViewErrorBag;

class UserController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['auth','verified']);
    // }

    public function getUser(Request $request){

        if(Auth::check()){
            $result = Auth::user()->id;
        }else{
            $result = false;
        }

        return response()->json([
            'success' => true,

            'results' => [
                'user_id' => $result,
            ]
        ]);

    }
}
