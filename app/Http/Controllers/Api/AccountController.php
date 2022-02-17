<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Account;



class AccountController extends Controller
{

    public function getAccount(Request $request) {

        $request->validate([
            'account_id' => 'required|integer',
            'account_name' => 'required|min:1|max:50',
        ]);

        $account_id = $request->account_id;
        $account_name = $request->account_name;

        $accounts = Account::where('id','!=', $account_id)
                    ->where('name','LIKE', '%'.$account_name.'%')
                    ->get();
                            //mi cerca una parte della parola

        return response()->json([
            'success' => true,
            'results' => [
                'accounts' => $accounts,
            ]
        ]);
    }

    public function getLastAccounts(Request $request) {

        $last_accounts =
        Account::orderBy('id', 'desc')
        ->join('account_types','account_types.id','=','account_type_id')
        ->select('accounts.id', 'accounts.name', 'accounts.image', 'account_types.name as accountTypeName','account_types.name_en as accountTypeName_en')
        ->take(7)
        ->get();

        return response()->json([
            'success' => true,
            'results' => [
                'last_accounts' => $last_accounts,
            ]
        ]);
    }

}
