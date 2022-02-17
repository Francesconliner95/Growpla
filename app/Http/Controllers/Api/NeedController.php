<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Account;
use App\Cofounder;
use App\AccountNeed;
use App\AccountType;
use App\StartupserviceType;

class NeedController extends Controller
{

    public function getNeeds(){

        $needs = StartupserviceType::all();

        return response()->json([
            'success' => true,
            'results' => [
                'needs' => $needs,
            ]
        ]);
    }

    public function getAccountNeeds(Request $request){

        $request->validate([
            'account_id' => 'required|integer',
        ]);

        $account_id = $request->account_id;

        $account_needs = AccountNeed::where('account_id', $account_id)
        ->leftjoin('account_types','account_types.id','=','account_type_id')
        ->leftjoin('startupservice_types','startupservice_types.id','=','startup_service_id')
        ->select('startupservice_types.name as startupservice_type_name', 'account_types.id as account_type_id', 'account_types.name as account_type_name','account_types.name_en as account_type_name_en')
        ->get();

        foreach ($account_needs as $account_need) {

            if($account_need->account_type_id==2){
                $cofounders = Cofounder::where('account_id', $account_id)
                ->join('cofounder_roles','cofounder_roles.id','=','role_id')
                ->select('cofounders.id','cofounders.quantity','cofounder_roles.name')
                ->get();
                if($cofounders){
                    $account_need['cofounders'] = $cofounders;
                    foreach ($cofounders as $cofounder){
                        $cofounder['nomination'] = false;
                    }
                }
            }
        }

        return response()->json([
            'success' => true,
            'results' => [
                'needs' => $account_needs,
            ]
        ]);

    }

}
