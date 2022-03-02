<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Language;
use App\User;
use App\Page;
use App\Lifecycle;
use App\Pagetype;
use App\Usertype;
use App\Service;
use App\HavePageUsertype;

class LifecycleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    public function edit($id)
    {

        $page = Page::find($id);

        app()->setLocale(Language::find(Auth::user()->language_id)->lang);

        $data = [
            'page' => $page,
            'lifecycles' => Lifecycle::all(),
            'pagetypes' => Pagetype::where('hidden',null)->get(),
            'usertypes' => Usertype::where('hidden',null)->get(),
            'services' => Service::where('page_id',$page->pagetype_id)
                          ->where('hidden',null)->get(),
        ];

        return view('admin.lifecycles.edit', $data);

    }

    public function update(Request $request, $id)
    {
        $request->validate([
          'usertypes'=> 'exists:usertypes,id',
          'pagetypes'=> 'exists:pagetypes,id',
        ]);
        
        $data = $request->all();
        $page = Page::find($id);
        $user = Auth::user();

        if($page->users->contains($user)){

          $page->lifecycle_id = $request->lifecycle;

          $page->update();

          //Necessità tipo di utente
          if(array_key_exists('usertypes', $data)){
            $page->have_page_usertypes()->sync($data['usertypes']);
          }else{
            $page->have_page_usertypes()->sync([]);
          }

          if(array_key_exists('pagetypes', $data)){
            $page->have_page_pagetypes()->sync($data['pagetypes']);
          }else{
            $page->have_page_pagetypes()->sync([]);
          }

          if(array_key_exists('services', $data)){
            $page->have_page_services()->sync($data['services']);
          }else{
            $page->have_page_services()->sync([]);
          }

          app()->setLocale(Language::find(Auth::user()->language_id)->lang);

          return redirect()->route('admin.pages.show',$page->id);

        }abort(404);

    }


}
