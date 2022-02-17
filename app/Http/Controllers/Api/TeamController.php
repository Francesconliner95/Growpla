<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Team;
use App\Account;

class TeamController extends Controller
{
    public function getTeamMembers(Request $request) {

        $request->validate([
            'account_id' => 'required|integer',
            // 'get_all' => 'required',
        ]);

        $account_id = $request->account_id;
        // $get_all = $request->get_all;

        // if($get_all=='yes'){
            $team_members = Team::where('account_id',$account_id)
                            ->orderBy('position', 'ASC')
                            ->get();
        // }else{
        //     $team_members = Team::where('account_id',$account_id)
        //                     ->limit(3)
        //                     ->get();
        // }

        return response()->json([
            'success' => true,
            'results' => [
                'team_members' => $team_members,
            ]
        ]);
    }

}
