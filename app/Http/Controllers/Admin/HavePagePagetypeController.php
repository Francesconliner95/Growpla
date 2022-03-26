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
use App\Notification;

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
              $syncResult = $page->have_page_pagetypes()->sync($data['pagetypes']);
            }else{
              $syncResult = $page->have_page_pagetypes()->sync([]);
            }

            if(collect($syncResult)->flatten()->isNotEmpty()){

                $followers = $page->page_follower;
                foreach ($followers as $follower) {
                    foreach ($data['pagetypes'] as $pagetype) {
                        $new_notf = new Notification();
                        $new_notf->user_id = $follower->id;
                        $new_notf->notification_type_id = 7;
                        $new_notf->ref_page_id = $page->id;
                        $new_notf->pagetype_id = $pagetype;
                        $new_notf->usertype_id = null;
                        $new_notf->parameter = $page->id.'/#services';
                        $new_notf->save();
                    }
                }
            }

            return redirect()->route('admin.pages.show',$page->id);

        }abort(404);
    }

}
