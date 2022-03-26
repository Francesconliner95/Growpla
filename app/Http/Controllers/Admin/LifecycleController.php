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
            'services' => Service::where('pagetype_id',$page->pagetype_id)
                          ->where('hidden',null)->get(),
            'skills' => $page->have_page_cofounders,
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

          $skills = $request->skills;
          //se è stata slezionata la voce aspirante-cofounder
          if($page->have_page_usertypes->contains(1) && $skills){

              $skills_id = [];
              foreach ($skills as $skill_name) {
                  $exist = Skill::where('name',$skill_name)->first();
                  if($exist){
                      array_push($skills_id, $exist->id);
                  }else{
                      if($skill_name){
                        $new_skill = new Skill();
                        $new_skill->name = Str::lower($skill_name);
                        $new_skill->save();
                        array_push($skills_id, $new_skill->id);
                      }
                  }
              }

              if(array_key_exists('skills', $data)){
                $page->have_page_cofounders()->sync($skills_id);
              }else{
                $page->have_page_cofounders()->sync([]);
              }

          }else{
              $page->have_page_cofounders()->sync([]);
          }

          app()->setLocale(Language::find(Auth::user()->language_id)->lang);

          return redirect()->route('admin.pages.show',$page->id);

        }abort(404);

    }


}
