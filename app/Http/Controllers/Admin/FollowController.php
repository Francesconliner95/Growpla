<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Follow;
use App\User;
use App\Page;

class FollowController extends Controller
{

    public function index()
    {

        $followed = Follow::where('user_id',Auth::user()->id)
        ->leftjoin('users','users.id','=','follows.user_following_id')
        ->leftjoin('pages','pages.id','=','follows.page_following_id')
        ->select('users.id as user_id', 'users.name as user_name',
        'pages.id as page_id','pages.name as page_name')
        ->get();

        // dd($following);

        $data = [
            'followed' => $followed,
        ];

        return view('admin.follows.index', $data);
    }

    public function toggleFollowing(Request $request){

        $request->validate([
            'follow_type' => 'required|integer',
            'follow_id' => 'required|integer',
        ]);

        switch ($request->follow_type) {
          case 1:
              $following = User::find($request->follow_id);

              $exist = Auth::user()->user_following->contains($following);

              if($exist){
                Auth::user()->user_following()->detach($following);
                $following = false;
              }else{
                Auth::user()->user_following()->attach($following);
                $following = true;
              }
          break;
          case 2:
              $following = Page::find($request->follow_id);

              $exist = Auth::user()->page_following->contains($following);

              if($exist){
                Auth::user()->page_following()->detach($following);
                $following = false;
              }else{
                Auth::user()->page_following()->attach($following);
                $following = true;
              }
          break;

          default:
            // code...
          break;
        }

        return response()->json([
            'success' => true,
            'results' => [
                'following' => $following,
            ]
        ]);

    }

    public function getFollowed(){

        $followed = Follow::where('user_id',Auth::user()->id)
        ->leftjoin('users','users.id','=','follows.user_following_id')
        ->leftjoin('pages','pages.id','=','follows.page_following_id')
        ->select('users.id as user_id', 'users.name as user_name',
        'pages.id as page_id','pages.name as page_name')
        ->get();

        return response()->json([
            'success' => true,
            'results' => [
                'followed' => $followed,
            ]
        ]);
    }

}
