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
            'page_id' => $page->id,
            'lifecycle_id'=>$page->lifecycle_id,
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
        $data = $request->all();
        $page = Page::find($id);
        $user = Auth::user();

        if($page->users->contains($user)){

          $page->lifecycle_id = $request->lifecycle;

          //Necessità tipo di utente
          if(array_key_exists('usertypes', $data)){
            $page->usertypes()->sync($data['usertypes']);
          }
          // $old_usertypes = HavePageUsertype::where('page_id',$page->id)
          //                 ->get();
          //
          // if($old_usertypes){
          //     foreach ($old_usertypes as $old_usertype) {
          //         $old_usertype->delete();
          //     }
          // }
          // if($request->usertypes){
          //     $usertypes = $request->usertypes;
          //     foreach ($usertypes as $usertype_id) {
          //         $exist = HavePageUsertype::where('page_id',$page->id)
          //                   ->where('usertype_id',$usertype_id)
          //                   ->first();
          //         if(!$exist){
          //             $new_hpu = new HavePageUsertype;
          //             $new_hpu->page_id = $page->id;
          //             $new_hpu->usertype_id = $usertype_id;
          //             $new_hpu->save();
          //         }
          //     }
          // }

          //dd($request->usertypes);

          app()->setLocale(Language::find(Auth::user()->language_id)->lang);

          return redirect()->route('admin.pages.show',$page->id);

        }abort(404);

    }


}
