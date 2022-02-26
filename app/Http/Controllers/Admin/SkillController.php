<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Skill;
use App\User;
use App\Language;

class SkillController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    public function create()
    {

        app()->setLocale(Language::find(Auth::user()->language_id)->lang);

        return view('admin.skills.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'name'=> 'required|string',
        ]);

        $data = $request->all();

        $name = Str::lower($request->name);

        $exist = Skill::where('name',$name)->first();

        if(!$exist){
            $new_skill = new Skill();
            $new_skill->name = $name;
            $new_skill->save();
            $skill = $new_skill;
        }else{
            $skill = $exist;
        }

        $user = Auth::user();
        if(!$user->skills->contains($skill)){
            $user->skills()->attach($skill);
        }

        return redirect()->route('admin.users.show',$user->id);
    }

    public function edit(Skill $skill)
    {

        $data = [
            'skill' => $skill,
        ];

        app()->setLocale(Language::find(Auth::user()->language_id)->lang);

        return view('admin.skills.edit', $data);
    }

    public function update(Request $request, Skill $skill)
    {

        $request->validate([
            'name'=> 'required|string',
        ]);

        $data = $request->all();

        $name = Str::lower($request->name);

        $exist = Skill::where('name',$name)->first();

        $old_skill = $skill;

        if(!$exist){
            $new_skill = new Skill();
            $new_skill->name = $name;
            $new_skill->save();
        }else{
            $new_skill = $exist;
        }

        $user = Auth::user();
        $user->skills()->detach($old_skill);

        if(!$user->skills->contains($new_skill)){
            $user->skills()->attach($new_skill);
        }

        return redirect()->route('admin.users.show',$user->id);
    }

    public function destroy(Skill $skill)
    {
        $user = Auth::user();
        $user->skills()->detach($skill);

        return redirect()->route('admin.users.show', ['user' => $user->id]);        

    }

}
