<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Skill;
use App\User;
use App\Language;

class GiveUserSkillController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    public function edit($user_id)
    {
        $user = User::find($user_id);
        if($user->id == Auth::user()->id){

          $data = [
              'user' => $user,
              'skills' => $user->give_user_skills,
          ];

          app()->setLocale(Language::find(Auth::user()->language_id)->lang);

          return view('admin.give-user-skills.edit', $data);

        }abort(404);

    }

    public function update(Request $request, $user_id)
    {

      $request->validate([
        //'skills'=> 'exists:usertypes,id',
      ]);

      $data = $request->all();

      $user = Auth::user();

      $user = User::find($user_id);
      if($user->id == Auth::user()->id){

          $skills = $request->skills;
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
            $user->give_user_skills()->sync($skills_id);
          }else{
            $user->give_user_skills()->sync([]);
          }

          return redirect()->route('admin.users.show',$user->id);

      }abort(404);
  }
}
