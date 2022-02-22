<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\User;

class UserController extends Controller
{

  public function searchUser(Request $request) {

      $request->validate([
          'user_name' => 'required',
      ]);

      $user_name = $request->user_name;

      $users = User::where('name','LIKE', '%'.$user_name.'%')
              ->orWhere('surname','LIKE', '%'.$user_name.'%')
              ->select('users.id','users.name','users.surname','users.image',)
              ->get();


      return response()->json([
          'success' => true,
          'results' => [
              'users' => $users,
          ]
      ]);
  }

}
