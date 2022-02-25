<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\User;
use DB;

class UserController extends Controller
{

  public function searchUser(Request $request) {

    $request->validate([
      'user_name' => 'required',
    ]);

    $user_name = $request->user_name;

    //concatenare due colonne nel database
    $users = User::select("id", "name", "surname")
            ->orWhere(DB::raw("concat(name, ' ', surname)"), 'LIKE', "%".$user_name."%")
            ->get();

    return response()->json([
        'success' => true,
        'results' => [
            'users' => $users,
        ]
    ]);

  }

}
