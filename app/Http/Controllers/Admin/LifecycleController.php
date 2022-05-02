<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Notification;
use App\Language;
use App\User;
use App\Page;
use App\Lifecycle;
use App\Pagetype;
use App\Usertype;
use App\Service;
use App\HavePageUsertype;
use App\Skill;

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
            'services' => Service::where('hidden',null)->get(),
            'skills' => $page->have_page_cofounders,
        ];

        return view('admin.lifecycles.edit', $data);

    }

    public function update(Request $request, $id)
    {
        $request->validate([
          'lifecycle'=> 'required|integer',
        ]);

        $data = $request->all();
        $page = Page::find($id);
        $user = Auth::user();

        if($page->users->contains($user) && $page->pagetype_id==1){

            if($page->lifecycle_id != $request->lifecycle){

                $page->lifecycle_id = $request->lifecycle;
                $page->update();

                //Notification
                $followers = $page->page_follower;
                foreach ($followers as $follower) {
                    $new_notf = new Notification();
                    $new_notf->user_id = $follower->id;
                    $new_notf->notification_type_id = 1;
                    $new_notf->ref_user_id = null;
                    $new_notf->ref_page_id = $page->id;
                    $new_notf->parameter = $page->id.'/#lifecycle';
                    $new_notf->save();
                }
            }

            app()->setLocale(Language::find(Auth::user()->language_id)->lang);

            if($page->tutorial>=1){
                return redirect()->route('admin.have-page-services.edit',$page->id);
            }else{
                return redirect()->route('admin.pages.show',$page->id);
            }

        }abort(404);

    }


}
