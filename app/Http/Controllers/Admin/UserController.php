<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ViewErrorBag;
use App\Usertype;
use App\Pagetype;

class UserController extends Controller
{
    public function __construct()
    {
      $this->middleware(['auth','verified']);
    }

    public function user_usertype_update(Request $request){

      $request->validate([
          'usertype_id'=> 'required|integer',
      ]);

      $usertype_id = $request->usertype_id;

      $user_id = Auth::user()->id;

      $alreadyExist = UserUsertype::where('user_id',$user_id)->first();

      // if($alreadyExist){
      //   $alreadyExist->delete();
      // }else{
      //   $new_user_usertype = new UserUsertype;
      //   $new_user_usertype->user_id = $user_id;
      //   $new_user_usertype->usertype_id = $usertype_id;
      //   $new_user_usertype->save();
      // }
    }

    public function create(){

      $user = Auth::user();
      $userTypes = Usertype::all();
      $pageTypes = Pagetype::all();

      $data = [
        'user' => $user,
        'userTypes' => $userTypes,
        'pageTypes' => $pageTypes,
      ];

      return view('admin.users.create', $data);

    }

    public function store(Request $request){
      // dd('qui');
      $request->validate([
          'usertypes'=> 'exists:usertypes,id',
          'pagetypes'=> 'exists:pagetypes,id',
      ]);

      $data = $request->all();

      $user = Auth::user();

      if(array_key_exists('usertypes', $data)){
        $user->usertypes()->sync($data['usertypes']);
      }

      if(array_key_exists('pagetypes', $data)){
        $user->pagetypes()->sync($data['pagetypes']);
      }

      return redirect()->route('admin.users.create');

    }

    public function getUser(Request $request){

      if(Auth::check()){
          $result = Auth::user()->id;
      }else{
          $result = false;
      }

      return response()->json([
          'success' => true,

          'results' => [
              'user_id' => $result,
          ]
      ]);

    }
}
