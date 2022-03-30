<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Page;
use App\User;
use App\Language;
use App\View;
use DB;
class ViewController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    public function myLatestViews()
    {
        $user = Auth::user();

        $views = View::where('user_id',$user->id)
                ->take(4)
                ->orderBy('updated_at','desc')
                ->get();
        $accounts = [];
        foreach ($views as $view) {
            if($view->viewed_user_id){
                $account = User::where('id',$view->viewed_user_id)->select('id','image','name','surname')
                ->first();
                $account['user_or_page'] = true;
            }
            if($view->viewed_page_id){
                $account = Page::where('id',$view->viewed_page_id)->select('id','image','name')
                ->first();
                $account['user_or_page'] = false;
            }
            array_push($accounts,$account);
        }
        //dd($accounts);
        return response()->json([
            'success' => true,
            'results' => [
                'accounts' => $accounts,
            ]
        ]);
    }

    public function mostViewedAccounts()
    {
        function orderByCount($accounts){
            //conta quante volte si ripete lo stesso id
            $items = array_count_values($accounts);
            //ordina in modo descrescente e mantiene la key
            arsort($items);
            //taglia l'array e mantiene la key (true)
            return array_slice($items, 0, 4, true);

        }

        $users = View::where('viewed_user_id','!=',null)
                        ->pluck('viewed_user_id')
                        ->toArray();

        $usersCount = orderByCount($users);

        $pages = View::where('viewed_page_id','!=',null)
                        ->pluck('viewed_page_id')
                        ->toArray();

        $pagesCount = orderByCount($pages);
        $accounts = [];

        foreach ($usersCount as $key => $userCount) {
            $account = User::where('id',$key)
                    ->select('id','image','name','surname')
                    ->first();
            $account['views'] = $userCount;
            $account['user_or_page'] = true;
            array_push($accounts,$account);
        }
        foreach ($pagesCount as $key => $pageCount) {
            $account = Page::where('id',$key)
                    ->select('id','image','name')
                    ->first();
            $account['views'] = $pageCount;
            $account['user_or_page'] = false;
            array_push($accounts,$account);
        }

        return response()->json([
            'success' => true,
            'results' => [
                'accounts' => $accounts,
            ]
        ]);
    }


}
