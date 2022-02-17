<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Account;
use App\AccountType;
use App\FilterNotification;


class FilterNotificationController extends Controller
{

    public function setFilterNotf(Request $request)
    {
        $request->validate([
            'account_id' => 'required|integer',
            'filter_not_type_id' => 'required|integer',
        ]);

        $account_id = $request->account_id;
        $filter_not_type_id = $request->filter_not_type_id;

        $already_exist = FilterNotification::where('account_id',$account_id)
        ->where('filter_not_type_id',$filter_not_type_id)->first();

        $account = Account::find($account_id);

        $can = true;

        if ($filter_not_type_id==2 && $account->account_type_id==1) {
            $can = false;
        }else if ($filter_not_type_id==3 && $account->account_type_id!=1) {
            $can = false;
        }

        if($account->user_id == Auth::user()->id && $can){
            if($already_exist){
                $already_exist->delete();
            }else{
                $new_filter_notf = new FilterNotification();
                $new_filter_notf->account_id = $account_id;
                $new_filter_notf->filter_not_type_id = $filter_not_type_id;
                $new_filter_notf->save();
            }
        }
    }

    public function getFilterNotf(Request $request)
    {
        $request->validate([
            'account_id' => 'required|integer',
        ]);

        $account_id = $request->account_id;

        $filter_notfs = FilterNotification::where('account_id',$account_id)
        ->get();

        return response()->json([
            'success' => true,
            'results' => [
                'filter_notfs' => $filter_notfs,
            ]
        ]);

    }

}
