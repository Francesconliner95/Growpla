<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Page;

class PageController extends Controller
{

  public function searchPage(Request $request) {

      $request->validate([
          'page_name' => 'required',
      ]);

      $page_name = $request->page_name;

      $pages = Page::where('name','LIKE', '%'.$page_name.'%')
              ->select('pages.id','pages.name','pages.image')
              ->get();


      return response()->json([
          'success' => true,
          'results' => [
              'pages' => $pages,
          ]
      ]);
  }

}
