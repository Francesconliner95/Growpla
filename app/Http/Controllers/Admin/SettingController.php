<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Mail\MailNotification;
use Illuminate\Support\Facades\Mail;
use App\User;
use App\Account;
use App\AccountType;
use App\StartupState;
use App\FilterMessage;
use App\FilterMail;
use App\FilterNotification;
use App\Language;

class SettingController extends Controller
{


    public function index()
    {
        if(Auth::user()->account_id){

            $account = Account::find(Auth::user()->account_id);

            $accountTypes = AccountType::all();

            $startupStates = StartupState::all();

            foreach ($accountTypes as $accountType) {
                $accountType['checked'] = true;
            }

            $filter_messages = FilterMessage::where('account_id',$account->id)
            ->get();

            $filter_mails = FilterMail::where('account_id',$account->id)
            ->get();

            $filter_notfs = FilterNotification::where('account_id',$account->id)
            ->get();

            $languages = Language::all();
            app()->setLocale(Language::find(Auth::user()->language_id)->lang);

            $data = [
                'user' => $account,
                'accountTypes' => $accountTypes,
                'startupStates' => $startupStates,
                'filter_messages' => $filter_messages,
                'filter_mails' => $filter_mails,
                'filter_notfs' => $filter_notfs,
                'languages' => $languages,
            ];

            return view('admin.settings.index', $data);

        }abort(404);

    }

    public function changeLang(Request $request){

        $request->validate([
            'lang_id' => 'required|integer',
        ]);

        $lang_id = $request->lang_id;
        Auth::user()->language_id = $lang_id;
        Auth::user()->save();

    }

}
