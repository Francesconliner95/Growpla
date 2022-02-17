<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\AccountType;



class AccountTypesController extends Controller
{

    public function getAccountTypes(Request $request) {

        $accountTypes = AccountType::all();

        return response()->json([
            'success' => true,
            'results' => [
                'accountTypes' => $accountTypes,
            ]
        ]);
    }

}
