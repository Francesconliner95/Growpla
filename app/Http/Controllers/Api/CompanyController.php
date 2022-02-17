<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Company;

class CompanyController extends Controller
{

    public function searchCompany(Request $request) {

        $request->validate([
            'company_name' => 'required',
        ]);

        $company_name = $request->company_name;

        $companies = Company::where('company_name','LIKE', '%'.$company_name.'%')
        ->get();


        return response()->json([
            'success' => true,
            'results' => [
                'companies' => $companies,
            ]
        ]);
    }

}
