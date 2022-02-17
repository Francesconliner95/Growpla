<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\CofounderRole;

class CofounderRoleController extends Controller
{

    public function searchRole(Request $request) {

        $request->validate([
            'role_name' => 'required',
        ]);

        $role_name = $request->role_name;

        $roles = CofounderRole::where('name','LIKE', '%'.$role_name.'%')
                ->get();


        return response()->json([
            'success' => true,
            'results' => [
                'roles' => $roles,
            ]
        ]);
    }

}
