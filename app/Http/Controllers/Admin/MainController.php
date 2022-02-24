<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use File;
use App\Usertype;
use App\Pagetype;

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
      ];

      return view('admin.search', $data);
    }

}
