<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Service;

class ServiceController extends Controller
{

  public function searchService(Request $request) {

      $request->validate([
          'service_name' => 'required',
      ]);

      $service_name = $request->service_name;

      $services = Service::where('name','LIKE', '%'.$service_name.'%')
              ->select('services.id','services.name')
              ->get();


      return response()->json([
          'success' => true,
          'results' => [
              'services' => $services,
          ]
      ]);
  }

}
