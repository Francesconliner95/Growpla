<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use File;
use App\Usertype;
use App\Pagetype;
use App\Lifecycle;
use App\Sector;
use App\Country;

class MainController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    public function search()
    {
      $data = [
          'usertypes' => Usertype::all(),
          'pagetypes' => Pagetype::all(),
          'sectors' => Sector::all(),
          'lifecycles' => Lifecycle::all(),
          'countries' => Country::all(),
      ];

      return view('admin.search', $data);
    }

    public function find(Request $request)
    {
        dd($request);

        $request->validate([
        //'skills'=> 'exists:usertypes,id',
        ]);

        $data = [

        ];

        return redirect()->route('admin.found',$data);

  }

}
