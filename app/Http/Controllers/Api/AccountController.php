<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use DB;
use App\User;
use App\Page;


class AccountController extends Controller
{

    public function searchAccount(Request $request) {

        $request->validate([
            'account_name' => 'required',
        ]);

        $account_name = $request->account_name;

        $accounts = [];

        $users = User::where(DB::raw("concat(name, ' ', surname)"), 'LIKE', "%".$account_name."%")
        ->select('id','name','surname','image')
        ->get();

        foreach ($users as $user) {
            $user['user_or_page'] = 'user';
        }

        array_push($accounts,...$users);

        $pages = Page::where('name','LIKE', "%".$account_name."%")
        ->select('id','name','image')
        ->get();

        foreach ($pages as $page) {
            $page['user_or_page'] = 'page';
        }

        array_push($accounts,...$pages);

        return response()->json([
            'success' => true,
            'results' => [
                'accounts' => $accounts,
            ]
        ]);
    }

}
