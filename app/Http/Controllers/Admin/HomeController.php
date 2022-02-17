<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Account;

class HomeController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['auth','verified']);
    // }
    //
    // public function index()
    // {
    //     $data = [
    //         'my_accounts' => Account::where('user_id', Auth::user()->id)->get(),
    //     ];
    //     return view('admin.choiseAccount', $data);
    // }
}
