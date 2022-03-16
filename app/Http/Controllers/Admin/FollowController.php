<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Follow;
use App\User;
use App\Page;
use App\Notification;

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

        function Notification($users,$type_id,$ref_user_id,$ref_page_id){
            foreach ($users as $user) {
                $new_notf = new Notification();
                $new_notf->user_id = $user->id;
                $new_notf->notification_type_id = $type_id;
                $new_notf->ref_user_id = $ref_user_id;
                $new_notf->ref_page_id = $ref_page_id;
                $new_notf->save();
            }
        }

        switch ($request->follow_type) {
          case 1:
              $following = User::find($request->follow_id);

              $exist = Auth::user()->user_following->contains($following);

              if($exist){
                Auth::user()->user_following()->detach($following);
                $following_toggle = false;
              }else{
                Auth::user()->user_following()->attach($following);
                $following_toggle = true;
                Notification([$following],2,$following->id,null);
              }
          break;
          case 2:
              $following = Page::find($request->follow_id);

              $exist = Auth::user()->page_following->contains($following);

              if($exist){
                Auth::user()->page_following()->detach($following);
                $following_toggle = false;
              }else{
                Auth::user()->page_following()->attach($following);
                $following_toggle = true;
                Notification($following->users,2,null,$following->id);
              }
          break;

          default:
            // code...
          break;
        }

        return response()->json([
            'success' => true,
            'results' => [
                'following' => $following_toggle,
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
