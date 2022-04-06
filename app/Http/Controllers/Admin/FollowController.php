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
        'users.surname as user_surname','pages.id as page_id','pages.name as page_name')
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
        $user = Auth::user();
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
                    $new_notf = new Notification();
                    $new_notf->user_id = $following->id;
                    $new_notf->notification_type_id = 2;
                    $new_notf->ref_user_id = $user->id;
                    $new_notf->parameter = $user->id;
                    $new_notf->save();
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
                    $page_admins = $following->users;
                    foreach ($page_admins as $admin) {
                        $new_notf = new Notification();
                        $new_notf->user_id = $admin->id;
                        $new_notf->notification_type_id = 15;
                        $new_notf->ref_user_id = $user->id;
                        $new_notf->ref_to_page_id = $following->id;
                        $new_notf->parameter = $user->id;
                        $new_notf->save();
                    }
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
