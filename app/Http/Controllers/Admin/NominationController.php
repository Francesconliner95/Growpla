<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\MailNotification;
use Illuminate\Support\Facades\Mail;
use App\User;
use App\Account;
use App\Cofounder;
use App\Notification;
use App\Nomination;
use App\AccountNeed;
use App\CofounderRole;
use App\FilterMail;
use App\Language;

class NominationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    //account show
    public function getNeedsAndNomination(Request $request){

        $request->validate([
            'account_id' => 'required|integer',
        ]);

        $account_id = $request->account_id;

        $account_needs = AccountNeed::where('account_id', $account_id)
        ->leftjoin('account_types','account_types.id','=','account_type_id')
        ->leftjoin('startupservice_types','startupservice_types.id','=','startup_service_id')
        ->select('startupservice_types.name as startupservice_type_name',
        'startupservice_types.name_en as startupservice_type_name_en', 'account_types.id as account_type_id', 'account_types.name as account_type_name','account_types.name_en as account_type_name_en')
        ->get();

        foreach ($account_needs as $account_need) {

            if($account_need->account_type_id==2){
                $cofounders = Cofounder::where('account_id', $account_id)
                ->join('cofounder_roles','cofounder_roles.id','=','role_id')
                ->select('cofounders.id','cofounder_roles.name')
                ->get();
                if($cofounders){
                    $account_need['cofounders'] = $cofounders;
                    foreach ($cofounders as $cofounder){
                        //controllo se sono cofounder e posso candidarmi
                        $my_account = Account::find(Auth::user()->account_id);
                        if($my_account->account_type_id==2){
                            //controllo se sono gi candidato o meno
                            $already_exist = Nomination::where('cofounder_id',$cofounder->id)
                            ->where('cofounder_account_id',$my_account->id)
                            ->first();
                            if($already_exist){
                                $cofounder['nomination'] = 1;
                            }else{
                                $cofounder['nomination'] = 2;
                            }
                        }else{
                            $cofounder['nomination'] = false;
                        }
                    }
                }
            }
        }

        return response()->json([
            'success' => true,
            'results' => [
                'needs' => $account_needs,
            ]
        ]);

    }

    //LATO COFOUNDER
    public function cofounder(){

        $my_nominations =
        Nomination::where('cofounder_account_id', Auth::user()->account_id)
        ->join('cofounders','cofounders.id','=','nominations.cofounder_id')
        ->select('cofounders.id as cofounder_id',
        'cofounders.account_id','cofounders.role_id','nominations.status')
        ->get();

        $accounts = [];

        foreach ($my_nominations as $my_nomination) {
            $account = Account::find($my_nomination->account_id)
                        ->select('id','name')
                        ->first();
            $role = CofounderRole::find($my_nomination->role_id);
            $account['role'] = $role->name;
            $account['status'] = $my_nomination->status;
            array_push($accounts, $account);
        }

        $data = [
            'accounts' => $accounts,
        ];

        app()->setLocale(Language::find(Auth::user()->language_id)->lang);

        return view('admin.nominations.cofounder', $data);

    }

    public function addNomination(Request $request){

        $request->validate([
            'cofounder_id' => 'required|integer',
        ]);

        $cofounder_id = $request->cofounder_id;

        $account = Account::find(Auth::user()->account_id);

        $already_exist = Nomination::where('cofounder_id',$cofounder_id)
                        ->where('cofounder_account_id',$account->id)
                        ->first();

        if($account->account_type_id==2){
            if(!$already_exist){
                $new_nomination = new Nomination;
                $new_nomination->cofounder_id = $cofounder_id;
                $new_nomination->cofounder_account_id = $account->id;
                $new_nomination->save();

                //NOTIFICA ALLA STARTUP PER LA NOMINATION
                $cofounder = Cofounder::find($cofounder_id);
                $cofounder_role = CofounderRole::find($cofounder->role_id);
                $startup_account = Account::find($cofounder->account_id);

                $new_notification = new Notification;
                $new_notification->user_id = $startup_account->user_id;
                $new_notification->ref_account_id = $startup_account->id;
                $new_notification->type = 1; //tipo 1 ti rinderizza alla sezione candidature
                $new_notification->message = $account->name.' si è candidato come cofounder per il ruolo di '.$cofounder_role->name.'. ('.$startup_account->name.')';
                $new_notification->save();
                //stato 0
                //candidatura 1
                //bisogno account 2
                //bisogno account servizio 3
                //sezione 4
                //collaborazione 5
                //conferma collaborazione 6

                //MAIL
                $not_send =
                FilterMail::where('account_id',$startup_account->id)
                ->where('filter_type_id',3)->first();
                // 3 per le 'nuove candidature'
                if(!$not_send){
                    $startup_email = User::find($startup_account->user_id)->email;
                    $data = [
                        'name' => $startup_account->name,
                        'message' => $new_notification->message,
                    ];
                    Mail::to($startup_email)
                        ->queue(new MailNotification($data));
                }
            }else{
                $already_exist->delete();
            }
        }
    }

    //LATO STARTUP

    public function startup($account_id){

        $account = Account::find($account_id);

        if(Auth::user()->id==$account->user_id){

            $data = [
                'account_id' => $account_id,
            ];

            app()->setLocale(Language::find(Auth::user()->language_id)->lang);

            return view('admin.nominations.startup', $data);

        }abort(404);

    }

    //Nomination show
    public function getNominations(Request $request){

        $request->validate([
            'account_id' => 'required|integer',
        ]);

        $account_id = $request->account_id;

        $account = Account::find($account_id);

        if(Auth::user()->id==$account->user_id){

            $my_nominations = [];

            $my_cofounders = Cofounder::where('account_id',$account->id)->get();

            if($my_cofounders){

                $cofounders_id = [];

                foreach ($my_cofounders as $my_cofounder) {
                    array_push($cofounders_id,$my_cofounder->id);
                }

                $my_nominations = Nomination::whereIn('cofounder_id',$cofounders_id)
                ->join('cofounders', 'cofounders.id', '=', 'cofounder_id')
                ->select('nominations.id','nominations.cofounder_account_id','cofounders.role_id','nominations.status')
                ->get();

                foreach ($my_nominations as $my_nomination) {
                    $account = Account::find($my_nomination->cofounder_account_id);
                    $my_nomination['account_id'] = $account->id;
                    $my_nomination['name'] = $account->name;
                    $role = CofounderRole::find($my_nomination->role_id);
                    $my_nomination['role_name'] = $role->name;
                }
            }

            return response()->json([
                'success' => true,
                'results' => [
                    'nominations' => $my_nominations,
                ]
            ]);

        }

    }

    public function deleteNomination(Request $request){

        $request->validate([
            'nomination_id' => 'required|integer',
            'reject_or_delete' => 'required|integer',
        ]);

        $nomination_id = $request->nomination_id;
        $reject_or_delete = $request->reject_or_delete;

        $nomination = Nomination::find($nomination_id);
        $cofounder = Cofounder::find($nomination->cofounder_id);
        $cofounder_role = CofounderRole::find($cofounder->role_id);
        $startup_account = Account::find($cofounder->account_id);
        $cofounder_account = Account::find($nomination->cofounder_account_id);

        if($cofounder->account_id == Auth::user()->account_id){

            $nomination->delete();

            if ($reject_or_delete==1) {
                //NOTIFICA AL COFOUNDER PER LA SUA CANDIDATURA
                $new_notification = new Notification;
                $new_notification->user_id = $cofounder_account->user_id;
                $new_notification->ref_account_id = $startup_account->id;
                $new_notification->type = 7;
                $new_notification->message = 'La startup '.$startup_account->name.' ha rifiutato la tua candidatura per il ruolo di '.$cofounder_role->name;
                $new_notification->save();
                //stato 0
                //candidatura 1
                //bisogno account 2
                //bisogno account servizio 3
                //sezione 4
                //collaborazione 5
                //conferma collaborazione 6
                //rifiuta candidatura 7

                //MAIL
                $user = User::find($cofounder_account->user_id);

                $data = [
                    'name' => $startup_account->name,
                    'message' => $new_notification->message,
                ];

                Mail::to($user->email)
                    ->queue(new MailNotification($data));
            }

        }

    }

    // public function updateNomination(Request $request){
    //
    //     $request->validate([
    //         'account_id' => 'required|integer',
    //         'nomination_id' => 'required|integer',
    //         'status' => 'required|integer|min:1|max:2',
    //     ]);
    //
    //     $account_id = $request->account_id;
    //     $nomination_id = $request->nomination_id;
    //     $status = $request->status;
    //
    //     $account = Account::find($account_id);
    //
    //     if(Auth::user()->id==$account->user_id){
    //
    //         $nomination = Nomination::find($nomination_id);
    //         $nomination->status = $status;
    //         $nomination->update();
    //
    //     }
    //
    // }

}
