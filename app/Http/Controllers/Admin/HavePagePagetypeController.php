<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Pagetype;
use App\User;
use App\Page;
use App\Language;

class HavePagePagetypeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    public function edit($page_id)
    {

        $data = [
            'page' => Page::find($page_id),
            'pagetypes' => Pagetype::where('hidden',null)->get(),
        ];

        app()->setLocale(Language::find(Auth::user()->language_id)->lang);

        return view('admin.have-page-pagetypes.edit', $data);
    }

    public function update(Request $request, $page_id)
    {

        $request->validate([
          'pagetypes'=> 'exists:pagetypes,id',
        ]);

        $data = $request->all();

        $user = Auth::user();
        $page = Page::find($page_id);

        if($user->pages->contains($page)){

            if(array_key_exists('pagetypes', $data)){
              $page->have_page_pagetypes()->sync($data['pagetypes']);
            }else{
              $page->have_page_pagetypes()->sync([]);
            }

            return redirect()->route('admin.pages.show',$page->id);

        }abort(404);
    }

}
