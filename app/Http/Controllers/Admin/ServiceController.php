<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Account;
use App\AccountStartupservice;

class ServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    public function addService(Request $request)
    {
        $request->validate([
            'service_id' => 'required|integer',
            'account_id' => 'required|integer',
        ]);

        $service_id = $request->service_id;
        $account_id = $request->account_id;

        $already_exist = AccountStartupservice::where('account_id', $account_id)
                        ->where('startup_service_id', $service_id)
                        ->first();

        $account = Account::find($account_id);

        if(!$already_exist && $account->user_id==Auth::user()->id){
            $new_service = new AccountStartupservice();
            $new_service->account_id = $account_id;
            $new_service->startup_service_id = $service_id;
            $new_service->save();
        }

    }

    public function deleteService(Request $request)
    {
        $request->validate([
            'service_id' => 'required|integer',
            'account_id' => 'required|integer',
        ]);

        $service_id = $request->service_id;
        $account_id = $request->account_id;

        $already_exist = AccountStartupservice::where('account_id', $account_id)
                        ->where('startup_service_id', $service_id)
                        ->first();

        $account = Account::find($account_id);

        if($already_exist && $account->user_id==Auth::user()->id){
            $already_exist->delete();
        }

    }
}
