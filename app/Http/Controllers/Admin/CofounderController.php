<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Account;
use App\Cofounder;

class CofounderController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    public function addCofounder(Request $request)
    {
        $request->validate([
            'role_id' => 'required|integer',
            'account_id' => 'required|integer',
        ]);

        $role_id = $request->role_id;
        $account_id = $request->account_id;

        $already_exist = Cofounder::where('account_id', $account_id)
                        ->where('role_id', $role_id)
                        ->first();

        $account = Account::find($account_id);

        if(!$already_exist && $account->user_id==Auth::user()->id){
            $new_cofounder = new Cofounder();
            $new_cofounder->account_id = $account_id;
            $new_cofounder->role_id = $role_id;
            $new_cofounder->save();
        }

    }

    public function updateCofounder(Request $request)
    {
        // $request->validate([
        //     'tag_id' => 'required|integer',
        //     'account_id' => 'required|integer',
        // ]);

    }

    public function deleteCofounder(Request $request)
    {
        $request->validate([
            'cofounder_id' => 'required|integer',
            'account_id' => 'required|integer',
        ]);

        $cofounder_id = $request->cofounder_id;
        $account_id = $request->account_id;

        $already_exist = Cofounder::find($cofounder_id);

        $account = Account::find($account_id);

        if($already_exist && $account->user_id==Auth::user()->id){
            $already_exist->delete();
        }

    }
}
