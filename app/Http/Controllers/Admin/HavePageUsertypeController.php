<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Usertype;
use App\User;
use App\Page;
use App\Language;
use App\Skill;
use App\Notification;

class HavePageUsertypeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    public function edit($page_id)
    {
        $page = Page::find($page_id);
        $user = Auth::user();
        if (in_array ($page->pagetype_id, array(1))
        && $user->pages->contains($page)) {
            $data = [
                'page' => $page,
                'usertypes' => Usertype::where('hidden',null)->get(),
                'skills' => $page->have_page_cofounders,
            ];

            app()->setLocale(Language::find(Auth::user()->language_id)->lang);

            return view('admin.have-page-usertypes.edit', $data);
        }abort(404);
    }

    public function update(Request $request, $page_id)
    {

        $request->validate([
          'usertypes'=> 'exists:usertypes,id',
        ]);

        // dd($request->skills);

        $data = $request->all();

        $user = Auth::user();
        $page = Page::find($page_id);

        if($user->pages->contains($page)){

            if(array_key_exists('usertypes', $data)){
              $syncResult = $page->have_page_usertypes()->sync($data['usertypes']);
            }else{
              $syncResult = $page->have_page_usertypes()->sync([]);
            }

            if(collect($syncResult)->flatten()->isNotEmpty()){

                $followers = $page->page_follower;
                foreach ($followers as $follower) {
                    foreach ($data['usertypes'] as $usertype) {
                        $new_notf = new Notification();
                        $new_notf->user_id = $follower->id;
                        $new_notf->notification_type_id = 7;
                        $new_notf->ref_page_id = $page->id;
                        $new_notf->usertype_id = $usertype;
                        $new_notf->parameter = $page->id.'/#services';
                        $new_notf->save();
                    }
                }
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

            return redirect()->route('admin.pages.show',$page->id);

        }abort(404);
    }

}
