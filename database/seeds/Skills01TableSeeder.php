<?php

use Illuminate\Database\Seeder;
use App\Skill;

class SkillsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('skills')->delete();
        $skills = [
            [
                'name'=>'content creator',
            ],
        ];

      foreach ($skills as $skill){
          $new_skill = new Skill();
          $new_skill->name = $skill['skill'];
          $new_skill->save();
      }
    }
}
