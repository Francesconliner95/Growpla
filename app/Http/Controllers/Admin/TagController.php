<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Account;
use App\Tag;
use App\AccountTag;

class TagController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    public function createTag(Request $request)
    {
        $request->validate([
            'tag_name' => 'required|max:50',
        ]);

        $tag_name = $request->tag_name;

        $already_exist = Tag::where('name',$tag_name)->first();

        if(!$already_exist){
            $new_tag = new Tag();
            $new_tag->name = Str::lower($tag_name);
            $new_tag->save();
        }

        return response()->json([
            'success' => true,
            'results' => [
                'tag_id' => $new_tag->id,
            ]
        ]);

    }

    public function addTag(Request $request)
    {
        $request->validate([
            'tag_id' => 'required|integer',
            'account_id' => 'required|integer',
        ]);

        $tag_id = $request->tag_id;
        $account_id = $request->account_id;

        $already_exist = AccountTag::where('account_id', $account_id)
                        ->where('tag_id', $tag_id)
                        ->first();

        $tag_qty = AccountTag::where('account_id', $account_id)->count();

        $account = Account::find($account_id);

        if(!$already_exist && $account->user_id==Auth::user()->id
        && $tag_qty<5){
            $new_account_tag = new AccountTag();
            $new_account_tag->account_id = $account_id;
            $new_account_tag->tag_id = $tag_id;
            $new_account_tag->save();
        }

    }

    public function deleteTag(Request $request)
    {
        $request->validate([
            'tag_id' => 'required|integer',
            'account_id' => 'required|integer',
        ]);

        $tag_id = $request->tag_id;
        $account_id = $request->account_id;

        $already_exist = AccountTag::where('account_id', $account_id)
                        ->where('tag_id', $tag_id)
                        ->first();

        $account = Account::find($account_id);

        if($already_exist && $account->user_id==Auth::user()->id){
            $already_exist->delete();
        }

    }
}
