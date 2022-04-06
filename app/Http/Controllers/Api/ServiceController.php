<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\MainService;
use App\Service;

class ServiceController extends Controller
{

    public function searchService(Request $request) {

      $request->validate([
          'service_name' => 'required',
      ]);

      $service_name = $request->service_name;

        $services = Service::where('name','LIKE', '%'.$service_name.'%')
                    ->where('hidden',null)
                    ->select('services.id','services.name')
                    ->get();


      return response()->json([
          'success' => true,
          'results' => [
              'services' => $services,
          ]
      ]);
    }

    public function getAllServices(){

        $main_services = MainService::all();
        $sub_services = Service::where('hidden',null)->get();

      return response()->json([
          'success' => true,
          'results' => [
              'main_services' => $main_services,
              'sub_services' => $sub_services,
          ]
      ]);
    }

}
