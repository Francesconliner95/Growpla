<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\StartupserviceType;
use App\AccountStartupservice;


class StartupserviceTypeController extends Controller
{
    public function getStartupserviceType() {

        $startupserviceType = StartupserviceType::all();

        return response()->json([
            'success' => true,
            'results' => [
                'startupserviceType' => $startupserviceType,
            ]
        ]);
    }

    public function getAccountServices(Request $request) {

        $request->validate([
            'account_id' => 'required|integer',
        ]);

        $account_id = $request->account_id;

        $accountServices = AccountStartupservice::where('account_id',$account_id)
        ->join('startupservice_types','startupservice_types.id','=','startup_service_id')
        ->select('startupservice_types.id','startupservice_types.name','startupservice_types.name_en')
        ->get();

        return response()->json([
            'success' => true,
            'results' => [
                'services' => $accountServices,
            ]
        ]);
    }

}
