<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Account;
use App\AccountType;
use App\FilterMail;


class FilterMailController extends Controller
{

    public function setFilterMail(Request $request)
    {
        $request->validate([
            'account_id' => 'required|integer',
            'filter_type_id' => 'required|integer',
        ]);

        $account_id = $request->account_id;
        $filter_type_id = $request->filter_type_id;

        $already_exist = FilterMail::where('account_id',$account_id)
        ->where('filter_type_id',$filter_type_id)->first();

        $account = Account::find($account_id);

        $can = true;

        if ($filter_type_id==2 && $account->account_type_id==1) {
            $can = false;
        }else if ($filter_type_id==3 && $account->account_type_id!=1) {
            $can = false;
        }

        if($account->user_id == Auth::user()->id && $can){
            if($already_exist){
                $already_exist->delete();
            }else{
                $new_filter_mail = new FilterMail();
                $new_filter_mail->account_id = $account_id;
                $new_filter_mail->filter_type_id = $filter_type_id;
                $new_filter_mail->save();
            }
        }
    }

    public function getFilterMail(Request $request)
    {
        $request->validate([
            'account_id' => 'required|integer',
        ]);

        $account_id = $request->account_id;

        $filter_mails = FilterMail::where('account_id',$account_id)
        ->get();

        return response()->json([
            'success' => true,
            'results' => [
                'filter_mails' => $filter_mails,
            ]
        ]);

    }

}
