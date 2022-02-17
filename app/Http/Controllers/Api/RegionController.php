<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Region;

class RegionController extends Controller
{
    public function getRegions(){

        $regions = Region::all();

        return response()->json([
            'success' => true,
            'results' => [
                'regions' => $regions,
            ]
        ]);
    }

}
