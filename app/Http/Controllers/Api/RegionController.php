<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Region;

class RegionController extends Controller
{
    public function regionsByCountry(Request $request){

        $request->validate([
            'country_id' => 'required|integer',
        ]);

        return response()->json([
            'success' => true,
            'results' => [
                'regions' => Region::where('country_id',$request->country_id)->get(),
            ]
        ]);
    }

}
