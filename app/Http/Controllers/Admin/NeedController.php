<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Account;
use App\AccountNeed;
use App\StartupState;
use App\AccountType;
use App\StartupserviceType;
use App\Follow;
use App\Notification;
use App\AccountStartupservice;
use App\FilterNotification;
use App\FilterMail;
use App\Mail\MailNotification;
use Illuminate\Support\Facades\Mail;
use App\Language;

class LifecycleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    public function edit($account_id)
    {

        $account = Account::find($account_id);

        if($account->user_id==Auth::user()->id){

            $accountNeeds = AccountNeed::where('account_id',$account->id)->get();
            $startupStates = StartupState::all();
            $account_types = AccountType::all();
            $startupservice_types = StartupserviceType::all();

            foreach ($account_types as $account_type) {
                $account_type['checked'] = false;
                foreach ($accountNeeds as $accountNeed) {
                    if($account_type->id==$accountNeed->account_type_id){
                        $account_type->checked = true;
                    }
                }
            }

            foreach ($startupservice_types as $startupservice_type) {
                $startupservice_type['checked'] = false;
                foreach ($accountNeeds as $accountNeed) {
                    if($startupservice_type->id==$accountNeed->startup_service_id){
                        $startupservice_type->checked = true;
                    }
                }
            }

            app()->setLocale(Language::find(Auth::user()->language_id)->lang);

            $data = [
                'account' => $account,
                'startupStates' => $startupStates,
                'accountNeeds' => $accountNeeds,
                'account_types' => $account_types,
                'startupservice_types' => $startupservice_types,
            ];

            return view('admin.needs.edit', $data);

        }abort(404);

    }

    public function updateNeed(Request $request)
    {
        $request->validate([
            'account_id' => 'required|integer',
            'startup_state' => 'required|integer',
            'accountTypesId' => 'nullable',
            'startupServiceTypesId' => 'nullable',

        ]);

        $account_id = $request->account_id;
        $startup_state_id = $request->startup_state;
        $accountTypesId = $request->accountTypesId;
        $startupServiceTypesId = $request->startupServiceTypesId;

        $account = Account::find($account_id);

        //CREO/INVIO LA NOTIFICA
        function createNotf($recipients,$account_id,$message,$notf_type){

            foreach ($recipients as $recipient) {

                $not_send = FilterNotification::where('account_id',$recipient->id)->where('filter_not_type_id',$notf_type)->first();

                if(!$not_send){
                    $new_notification = new Notification;
                    $new_notification->user_id = $recipient->user_id;
                    $new_notification->ref_account_id = $account_id;
                    $new_notification->type = $notf_type;
                    $new_notification->message = $message;
                    $new_notification->save();
                    //stato 0
                    //candidatura 1
                    //bisogno 2
                    //sezione 3
                    //collaborazione 4
                    //conferma collaborazione 5
                }

            }

        }

        //CREO/INVIO LA MAIL
        function createMail($recipients,$account_id,$message,$notf_type){

            foreach ($recipients as $recipient) {

                //MAIL
                $not_send =
                FilterMail::where('account_id',$recipient->id)
                ->where('filter_type_id',$notf_type)->first();

                if(!$not_send){
                    $recipient_mail = User::find($recipient->user_id)->email;

                    $data = [
                        'message' => $message,
                        'sender_name' => $recipient->name,
                        'account_id' => $account_id,
                    ];

                    Mail::to($recipient_mail)->queue(new MailNotification($data));
                }

            }

        }

        //CONTROLLO A CHI DEVO INVIARE LA NOTIFICA
        function recipientsList($message,$account,$notf_type,$accountTypeId,$startupServiceTypeId){
            //stato 0
            //candidatura 1
            //bisogno account 2
            //bisogno account servizio 3
            //sezione 4
            //collaborazione 5
            //conferma collaborazione 6
            switch ($notf_type) {
                case 1://NOTIFICA PER CAMBIO STATO

                    $recipients =
                    Follow::where('follow_account_id',$account->id)
                    ->select('follows.user_id')
                    ->get();

                    createNotf($recipients,$account->id,$message,0);
                break;

                case 2://NOTIFICA "IN CERCA DI" per account tranne startup e ss

                    $recipients = Account::where('account_type_id',$accountTypeId)
                    ->select('accounts.id', 'accounts.user_id')
                    ->get();

                    createNotf($recipients,$account->id,$message,2);
                    createMail($recipients,$account->id,$message,$notf_type);
                break;

                case 3://NOTIFICA "IN CERCA DI" per servizi alle startup
                    $recipients = AccountStartupservice::where('startup_service_id',$startupServiceTypeId)
                    ->join('accounts','accounts.id','=','account_startupservices.account_id')
                    ->select('accounts.id', 'accounts.user_id')
                    ->get();

                    createNotf($recipients,$account->id,$message,3);
                    createMail($recipients,$account->id,$message,$notf_type);
                break;

                default:

                break;
            }
        }

        if($account->user_id==Auth::user()->id){

            if($account->startup_status_id!=$startup_state_id){
                $account->startup_status_id = $startup_state_id;
                $account->update();

                $startupState = StartupState::find($startup_state_id);

                //NOTIFICA PER CAMBIO STATO
                $message = 'La startup '.$account->name.' ha cambiato il proprio stato in "'.$startupState->name.'".';

                $notf_type = 1; //cambio stato
                recipientsList($message,$account,$notf_type,null,null);

            }

            $accountNeeds = AccountNeed::where('account_id',$account->id)->get();


            //CONTROLLA SE NELLO STATO STARTUP SONO DISPONIBILI QUEI BISOGNI
            // $state_needs = Need::where('startup_state_id',$startup_state)->get();
            //
            // foreach ($needs_id as $key => $need_id) {
            //     $accountneed_compatible = false;
            //     foreach ($state_needs as $state_need) {
            //         if($state_need->id==$need_id){
            //             $accountneed_compatible = true;
            //         }
            //     }
            //     if(!$accountneed_compatible){
            //         unset($needs_id[$key]);
            //     }
            // }


            //CICLO ELIMINA
            foreach ($accountNeeds as $accountNeed) {
                $accountneed_already_exist = false;

                foreach ($accountTypesId as $accountTypeId) {
                    if($accountTypeId==$accountNeed->account_type_id){
                        $accountneed_already_exist = true;
                    }
                }

                foreach ($startupServiceTypesId as $startupServiceTypeId) {
                    if($startupServiceTypeId==$accountNeed->startup_service_id){
                        $accountneed_already_exist = true;
                    }
                }

                if(!$accountneed_already_exist){
                    $accountNeed->delete();
                }
            }

            $accountTypes = AccountType::all();

            //CICLO AGGIUNGI $accountTypesId
            foreach ($accountTypesId as $accountTypeId) {
                $need_already_exist = false;
                foreach ($accountNeeds as $accountNeed) {
                    if($accountTypeId==$accountNeed->account_type_id){
                        $need_already_exist = true;
                    }
                }
                if(!$need_already_exist){
                    $new_account_need = new AccountNeed();
                    $new_account_need->account_id = $account->id;
                    $new_account_need->account_type_id = $accountTypeId;
                    $new_account_need->startup_service_id = null;
                    $new_account_need->save();

                    //NOTIFICA "IN CERCA DI" per account tranne startup e serv all start

                    $message = 'La startup '.$account->name.' è alla ricerca di '.$accountTypes[$accountTypeId-1]->name.'".';

                    $notf_type = 2; //in cerca di accounts

                    recipientsList($message,$account,$notf_type,$accountTypeId,null);

                }

            }

            $startupserviceType = StartupserviceType::all();

            //CICLO AGGIUNGI $startupServiceTypesId
            foreach ($startupServiceTypesId as $startupServiceTypeId) {
                $need_already_exist = false;
                foreach ($accountNeeds as $accountNeed) {
                    if($startupServiceTypeId==$accountNeed->startup_service_id){
                        $need_already_exist = true;
                    }
                }
                if(!$need_already_exist){
                    $new_account_need = new AccountNeed();
                    $new_account_need->account_id = $account->id;
                    $new_account_need->account_type_id = 7;
                    $new_account_need->startup_service_id = $startupServiceTypeId;
                    $new_account_need->save();

                    //NOTIFICA "IN CERCA DI" per servizi alle startup
                    $message = 'La startup '.$account->name.' è alla ricerca del servizio di '.$startupserviceType[$startupServiceTypeId-1]->name.'".';

                    $notf_type = 3; //in cerca di servizi

                    recipientsList($message,$account,$notf_type,null,$startupServiceTypeId);
                }

            }
        }
    }



    public function update(Request $request)
    {

    }

    public function destroy(Team $team)
    {

    }

}
