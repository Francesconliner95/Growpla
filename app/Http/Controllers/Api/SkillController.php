<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Skill;

class SkillController extends Controller
{

  public function searchSkill(Request $request) {

      $request->validate([
          'skill_name' => 'required',
      ]);

      $skill_name = $request->skill_name;

      $skills = Skill::where('name','LIKE', '%'.$skill_name.'%')
              ->select('skills.id','skills.name')
              ->get();


      return response()->json([
          'success' => true,
          'results' => [
              'skills' => $skills,
          ]
      ]);
  }

}
