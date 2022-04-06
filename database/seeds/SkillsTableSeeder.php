<?php

use Illuminate\Database\Seeder;
use App\Skill;
use Illuminate\Support\Facades\Schema;

class SkillsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('skills')->truncate();
        Schema::enableForeignKeyConstraints();

        $skills = [

            // [
            //     'name'=>'Compliance',
            // ],
        ];

        foreach ($skills as $skill){
            $new_skill = new Skill();
            $new_skill->name = $skill['name'];
            $new_skill->save();
        }

    }
}
