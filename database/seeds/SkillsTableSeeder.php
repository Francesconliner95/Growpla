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
                'name'=>'Visual Merchandiser',
            ],
            [
                'name'=>'Operations Manager',
            ],
            [
                'name'=>'Project Manager',
            ],
            [
                'name'=>'Buyer',
            ],
            [
                'name'=>'Business Analyst',
            ],
            [
                'name'=>'Assistente Amministrativo',
            ],
            [
                'name'=>'Art Director',
            ],
            [
                'name'=>'Grafico',
            ],
            [
                'name'=>'Tecnico del Suono',
            ],
            [
                'name'=>'Risk manager',
            ],
            [
                'name'=>'Commercialista',
            ],
            [
                'name'=>'Contabile',
            ],
            [
                'name'=>'Controller',
            ],
            [
                'name'=>'Revisore Contabile',
            ],
            [
                'name'=>'Internal Auditor',
            ],
            [
                'name'=>'Product Designer',
            ],
            [
                'name'=>'UX Designer',
            ],
            [
                'name'=>'Web Designer',
            ],
            [
                'name'=>'Analista di Mercato',
            ],
            [
                'name'=>'Analista Finanziario',
            ],
            [
                'name'=>'Asset Manager',
            ],
            [
                'name'=>'Avvocato',
            ],
            [
                'name'=>'Notaio',
            ],
            [
                'name'=>'Consulente Legale',
            ],
            [
                'name'=>'Facility Manager',
            ],
            [
                'name'=>'Lean Manager',
            ],
            [
                'name'=>'Programmatore CNC',
            ],
            [
                'name'=>'Programmatore PLC',
            ],
            [
                'name'=>'Analista Funzionale',
            ],
            [
                'name'=>'Analista Programmatore',
            ],
            [
                'name'=>'Consulente Informatico',
            ],
            [
                'name'=>'Consulente SAP',
            ],
            [
                'name'=>'Database Administrator',
            ],
            [
                'name'=>'Ethical Hacker',
            ],
            [
                'name'=>'Programmatore Informatico',
            ],
            [
                'name'=>'Sistemista',
            ],
            [
                'name'=>'Software Developer',
            ],
            [
                'name'=>'Software Tester',
            ],
            [
                'name'=>'Tecnico Elettronico',
            ],
            [
                'name'=>'Tecnico Informatico',
            ],
            [
                'name'=>'Web Developer',
            ],
            [
                'name'=>'Webmaster',
            ],
            [
                'name'=>'Ingegnere Aerospaziale',
            ],
            [
                'name'=>'Ingegnere Ambientale',
            ],
            [
                'name'=>'Ingegnere Biomedico',
            ],
            [
                'name'=>'Ingegnere Chimico',
            ],
            [
                'name'=>'Ingegnere Elettrico',
            ],
            [
                'name'=>'Ingegnere dei Materiali',
            ],
            [
                'name'=>'Ingegnere dell\'Automazione',
            ],
            [
                'name'=>'Ingegnere delle Telecomunicazioni',
            ],
            [
                'name'=>'Ingegnere di Processo',
            ],
            [
                'name'=>'Ingegnere Gestionale',
            ],
            [
                'name'=>'Ingegnere Informatico',
            ],
            [
                'name'=>'Ingegnere Meccanico',
            ],
            [
                'name'=>'Supply Chain Manager',
            ],
            [
                'name'=>'Brand Manager',
            ],
            [
                'name'=>'Community Manager',
            ],
            [
                'name'=>'Content Manager',
            ],
            [
                'name'=>'Data Analyst',
            ],
            [
                'name'=>'Influencer',
            ],
            [
                'name'=>'Manager delle Pubbliche Relazioni',
            ],
            [
                'name'=>'Marketing Manager',
            ],
            [
                'name'=>'Media Buyer',
            ],
            [
                'name'=>'Media Planner',
            ],
            [
                'name'=>'Product Manager',
            ],
            [
                'name'=>'Responsabile della Comunicazione',
            ],
            [
                'name'=>'SEO Specialist',
            ],
            [
                'name'=>'Social Media Manager',
            ],
            [
                'name'=>'Web Marketing Manager',
            ],
            [
                'name'=>'Blogger',
            ],
            [
                'name'=>'Copywriter',
            ],
            [
                'name'=>'Instagrammer',
            ],
            [
                'name'=>'Youtuber',
            ],
            [
                'name'=>'Web Editor',
            ],
            [
                'name'=>'Streamer',
            ],
            [
                'name'=>'HR Manager',
            ],
            [
                'name'=>'Data Scientist',
            ],
            [
                'name'=>'Customer Service Manager',
            ],
            [
                'name'=>'Tecnico Help Desk',
            ],
            [
                'name'=>'IT Security Manager',
            ],
            [
                'name'=>'Account Manager',
            ],
            [
                'name'=>'Area Manager',
            ],
            [
                'name'=>'e-Commerce Manager',
            ],
            [
                'name'=>'Sales Manager',
            ],
            [
                'name'=>'Sales Analyst',
            ],
            [
                'name'=>'Export Manager',
            ],
            [
                'name'=>'Ket Account Manager',
            ],
        ];

      foreach ($skills as $skill){
          $new_skill = new Skill();
          $new_skill->name = $skill['skill'];
          $new_skill->save();
      }
    }
}
