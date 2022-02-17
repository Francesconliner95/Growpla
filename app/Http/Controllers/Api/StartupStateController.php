<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
// use Illuminate\Support\Facades\Auth;
use App\StartupState;



class StartupStateController extends Controller
{

    public function getStartupStates(Request $request) {

        $startupStates = StartupState::all();

        return response()->json([
            'success' => true,
            'results' => [
                'startupStates' => $startupStates,
            ]
        ]);
    }

}
