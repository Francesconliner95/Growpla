<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\CofounderRole;
use Illuminate\Support\Str;

class CofounderRoleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    public function createRole(Request $request)
    {
        $request->validate([
            'role_name' => 'required',
        ]);

        $role_name = $request->role_name;

        $already_exist = CofounderRole::where('name','LIKE', '%'.$role_name.'%')
                        ->first();

        if(!$already_exist){
            $new_role = new CofounderRole();
            $new_role->name = Str::lower($role_name);
            $new_role->save();
        }

        return response()->json([
            'success' => true,
            'results' => [
                'role_id' => $new_role->id,
            ]
        ]);

    }

}
