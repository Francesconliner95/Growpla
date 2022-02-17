<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Follow;
use App\Account;

class FollowController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::user()->id;

        $my_follows = Follow::where('user_id',$user_id)
                    // ->join('accounts','accounts.id','=','follow_account_id')
                    // ->select('follows.id as follows_id', 'accounts.id as account_id', 'accounts.name')
                    ->get();

        foreach ($my_follows as  $my_follow) {
            $account = Account::find($my_follow->follow_account_id);
            $my_follow['account_id'] = $account->id;
            $my_follow['name'] = $account->name;
        }

        $data = [
            'my_follows' => $my_follows,
        ];

        return view('admin.follows.index', $data);
    }

    public function addFollow(Request $request){

        $request->validate([
            'follow_id' => 'required|integer',
        ]);

        $user_id = Auth::user()->id;
        $follow_id = $request->follow_id;
        $already_exist = Follow::where('user_id', $user_id)
                        ->where('follow_account_id', $follow_id)->first();

        if($already_exist){
            $already_exist->delete();
        }else{
            $new_follow = new Follow();
            $new_follow->user_id = $user_id;
            $new_follow->follow_account_id = $follow_id;
            $new_follow->save();
        }

    }

    public function getFollows(){

        $user_id = Auth::user()->id;

        $my_follows = Follow::where('user_id', $user_id)->get();

        foreach ($my_follows as  $my_follow) {
            $account = Account::find($my_follow->follow_account_id);
            $my_follow['account_id'] = $account->id;
            $my_follow['name'] = $account->name;
        }

        return response()->json([
            'success' => true,
            'results' => [
                'my_follows' => $my_follows,
            ]
        ]);
    }

    public function getFollow(Request $request) {

        $request->validate([
            'follow_id' => 'required|integer',
        ]);

        $user_id = Auth::user()->id;
        $follow_id = $request->follow_id;
        $already_exist = Follow::where('user_id', $user_id)
                        ->where('follow_account_id', $follow_id)->first();

        if($already_exist){
            $already_follow = true;
        }else{
            $already_follow = false;
        }
        return response()->json([
            'success' => true,
            'results' => [
                'already_follow' => $already_follow,
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
