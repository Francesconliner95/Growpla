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

            [
                'name'=>'Compliance',
            ],
            [
                'name'=>'GDPR',
            ],
            [
                'name'=>'Brevetti',
            ],
            [
                'name'=>'Redazione Contratti',
            ],
            [
                'name'=>'Privacy Policy',
            ],
            [
                'name'=>'Cookie Policy',
            ],
            [
                'name'=>'Grafica',
            ],
            [
                'name'=>'Organizzazione',
            ],
            [
                'name'=>'Business Development',
            ],
            [
                'name'=>'Negoziazione',
            ],
            [
                'name'=>'Team Working',
            ],
            [
                'name'=>'Problem Solving',
            ],
            [
                'name'=>'UI Design',
            ],
            [
                'name'=>'Product Design',
            ],
            [
                'name'=>'UX Design',
            ],
            [
                'name'=>'Web Design',
            ],
            [
                'name'=>'CRO - Conversion Rate Optimization',
            ],
            [
                'name'=>'SEM - Search Engine Marketing',
            ],
            [
                'name'=>'Editorial Expert',
            ],
            [
                'name'=>'Avvocato',
            ],
            [
                'name'=>'Notaio',
            ],
            [
                'name'=>'Database',
            ],
            [
                'name'=>'Hacking',
            ],
            [
                'name'=>'Software Development',
            ],
            [
                'name'=>'Software Testing',
            ],
            [
                'name'=>'Web Development',
            ],
            [
                'name'=>'Ingegneria',
            ],
            [
                'name'=>'Brand',
            ],
            [
                'name'=>'Community',
            ],
            [
                'name'=>'Content',
            ],
            [
                'name'=>'Data Analyst',
            ],
            [
                'name'=>'Pubbliche Relazioni',
            ],
            [
                'name'=>'Marketing',
            ],
            [
                'name'=>'Media Planning',
            ],
            [
                'name'=>'Product',
            ],
            [
                'name'=>'Comunicazione',
            ],
            [
                'name'=>'SEO - Search Engine Optimization',
            ],
            [
                'name'=>'Social Media',
            ],
            [
                'name'=>'Web Marketing',
            ],
            [
                'name'=>'Blogging',
            ],
            [
                'name'=>'Copywriting',
            ],
            [
                'name'=>'Web Editing',
            ],
            [
                'name'=>'HR',
            ],
            [
                'name'=>'Data Science',
            ],
            [
                'name'=>'IT Security',
            ],
            [
                'name'=>'IT',
            ],
            [
                'name'=>'Management',
            ],
        ];

        foreach ($skills as $skill){
            $new_skill = new Skill();
            $new_skill->name = $skill['skill'];
            $new_skill->save();
        }

    }
}
