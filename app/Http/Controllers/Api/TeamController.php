<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Team;
use App\User;

class TeamController extends Controller
{
    public function getTeamMembers(Request $request) {

        $request->validate([
            'page_id' => 'required|integer',
            // 'get_all' => 'required',
        ]);

        $page_id = $request->page_id;
        // $get_all = $request->get_all;

        // if($get_all=='yes'){
        //TEAM
            $team_members = Team::where('page_id', $page_id)
                            ->orderBy('position', 'ASC')
                            //->limit(3)
                            ->get();
            foreach ($team_members as $team_member) {
              if($team_member->user_id){
                $user = User::find($team_member->user_id);
                $team_member['name'] = $user->name;
                $team_member['surname'] = $user->surname;
                $team_member['image'] = $user->image;
                $team_member['linkedin'] = $user->linkedin;
              }
            }

            $team_num = Team::where('page_id', $page_id)->count();
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
