<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Cooperation;
use App\Account;
use App\Notification;

class CooperationController extends Controller
{

    public function addCooperation(Request $request)
    {

        $request->validate([
            'cooperation_id' => 'required|integer',
            'account_id' => 'required|integer',
        ]);

        $your_account_id = $request->cooperation_id;
        $my_account_id = $request->account_id;

        $already_exist = Cooperation::where('account_id', $my_account_id)
                        ->where('cooperation_account_id', $your_account_id)->first();

        $my_account = Account::find($my_account_id);

        $user_id = Auth::user()->id;

        $your_account = Account::find($your_account_id);

        if(!$already_exist && $my_account->user_id==$user_id && $my_account_id!=$your_account_id){

            $new_cooperation = new Cooperation();
            $new_cooperation->account_id = $my_account_id;
            $new_cooperation->cooperation_account_id = $your_account_id;
            $new_cooperation->save();

            $new_notification = new Notification;
            $new_notification->user_id = $your_account->user_id;
            $new_notification->ref_account_id = $my_account->id;
            $new_notification->type = 5;
            $new_notification->message = $my_account->name.' ti ha aggiunto alle sue collaborazioni, vai sul suo profilo per confermare';
            $new_notification->save();

        }

    }

    public function deleteCooperation(Request $request)
    {

        $request->validate([
            'cooperation_id' => 'required|integer',
            'account_id' => 'required|integer',
        ]);

        $cooperation_id = $request->cooperation_id;
        $account_id = $request->account_id;

        $cooperation = Cooperation::where('account_id', $account_id)
                        ->where('cooperation_account_id', $cooperation_id)->first();

        $account = Account::find($account_id);

        $user_id = Auth::user()->id;

        if($cooperation && $account->user_id==$user_id){
            $cooperation->delete();
        }

    }

    public function confirmCooperation(Request $request)
    {

        $request->validate([
            'recipient_id' => 'required|integer',
            'sender_id' => 'required|integer',
        ]);

        $recipient_id = $request->recipient_id;
        $sender_id = $request->sender_id;
        $user_id = Auth::user()->id;

        $cooperation = Cooperation::where('account_id', $sender_id)
                        ->where('cooperation_account_id', $recipient_id)->first();

        $recipient_account = Account::find($recipient_id);

        if($cooperation && $recipient_account->user_id==$user_id){

            $cooperation->confirmed = 1;
            $cooperation->update();

            $account_sender = Account::find($sender_id);
            //NOTIFICA
            $new_notification = new Notification;
            $new_notification->user_id = $account_sender->user_id;
            $new_notification->ref_account_id = $recipient_account->id;
            $new_notification->type = 6;
            $new_notification->message = 'L\'account '.$recipient_account->name.' ha confermato la vostra collaborazione';
            $new_notification->save();
            //stato 0
            //candidatura 1
            //bisogno account 2
            //bisogno account servizio 3
            //sezione 4
            //collaborazione 5
            //conferma collaborazione 6
        }

    }

}
