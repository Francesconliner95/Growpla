<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Cooperation;
use App\Account;

class CooperationController extends Controller
{

    public function getCooperation(Request $request) {

        $request->validate([
            'account_id' => 'required|integer',
        ]);

        $account_id = $request->account_id;

        $cooperations = Cooperation::where('account_id',$account_id)
        ->join('accounts','accounts.id','=','cooperation_account_id')
        ->select('accounts.id', 'accounts.image', 'accounts.name', 'cooperations.confirmed')
        ->get();

        return response()->json([
            'success' => true,
            'results' => [
                'cooperations' => $cooperations,
            ]
        ]);
    }

}
