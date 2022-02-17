<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Account;
use App\AccountType;
use App\FilterMessage;


class FilterMessageController extends Controller
{

    public function setFilterMessage(Request $request)
    {
        $request->validate([
            'account_id' => 'required|integer',
            'account_type_id' => 'required|integer',
            'startup_state_id' => 'nullable|integer',
        ]);

        $account_id = $request->account_id;
        $account_type_id = $request->account_type_id;
        $startup_state_id = $request->startup_state_id;

        $account = Account::find($account_id);

        if($account->user_id == Auth::user()->id){

            if($account_type_id==1){
                $already_exist = FilterMessage::where('account_id',$account_id)
                                ->where('account_type_id',$account_type_id)
                                ->where('startup_state_id',$startup_state_id)
                                ->first();
                if($already_exist){
                    $already_exist->delete();
                }else{
                    $new_filter_message = new FilterMessage();
                    $new_filter_message->account_id = $account_id;
                    $new_filter_message->account_type_id = $account_type_id;
                    $new_filter_message->startup_state_id = $startup_state_id;
                    $new_filter_message->save();
                }
            }else{
                $already_exist = FilterMessage::where('account_id',$account_id)
                ->where('account_type_id',$account_type_id)->first();
                if($already_exist){
                    $already_exist->delete();
                }else{
                    $new_filter_message = new FilterMessage();
                    $new_filter_message->account_id = $account_id;
                    $new_filter_message->account_type_id = $account_type_id;
                    $new_filter_message->save();
                }
            }
        }
    }

    public function getFilterMessage(Request $request)
    {
        $request->validate([
            'account_id' => 'required|integer',
        ]);

        $account_id = $request->account_id;

        $filter_messages = FilterMessage::where('account_id',$account_id)
        ->get();

        return response()->json([
            'success' => true,
            'results' => [
                'filter_messages' => $filter_messages,
            ]
        ]);

    }

}
