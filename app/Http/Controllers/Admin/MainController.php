<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use File;
use App\Account;

class MainController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    public function index()
    {
      $data = [
          // 'my_accounts' => $my_accounts,
          // 'needs' => $needs,
      ];

      return view('admin.index', $data);
    }

    public function create()
    {

    }

    public function store(Request $request, Account $account)
    {

    }

    public function show($id)
    {

    }

    public function edit($id)
    {

    }

    public function update(Request $request, Team $team)
    {

    }

    public function destroy(Team $team)
    {

    }

}
