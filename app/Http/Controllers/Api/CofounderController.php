<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Cofounder;
use App\CofounderRole;

class CofounderController extends Controller
{
    public function getCofounder(Request $request) {

        $request->validate([
            'account_id' => 'required|integer',
        ]);

        $account_id = $request->account_id;

        $cofounders = Cofounder::where('account_id',$account_id)->get();

        foreach ($cofounders as $cofounder) {
            $cofounder['name'] = CofounderRole::find($cofounder->role_id)->name;
        }

        return response()->json([
            'success' => true,
            'results' => [
                'cofounders' => $cofounders,
            ]
        ]);
    }


}
