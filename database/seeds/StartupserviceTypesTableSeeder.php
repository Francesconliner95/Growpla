<?php

use Illuminate\Database\Seeder;
use App\StartupserviceType;

class StartupserviceTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $startupserviceTypes = [
            // [
            //     'name'=>'Altro',
            //     'description'=>'Inserisci altri servizi che offri ma che non sono ricompresi tra i presenti',
            // ],
            [
                'name'=>'Advisor',
                'description'=>'L\'advisor è un consulente che supporta le startup in fusioni, acquisizioni, joint-venture ed in generale nella fase di exit.',
                'name_en'=>'Advisor',
                'description_en'=>'The advisor is a consultant who supports startups in mergers, acquisitions, joint ventures and in general in the exit phase.',
            ],
            [
                'name'=>'Coaching',
                'description'=>'Il coach è un soggetto che aiuta il team a migliorarsi rendendolo in grado di risolvere problemi di business.',
                'name_en'=>'Coaching',
                'description_en'=>'The coach is a person who helps the team to improve by making it able to solve business problems.',
            ],
            [
                'name'=>'Costituzione ed aspetti legali',
                'description'=>'',
                'name_en'=>'Constitution and legal aspects',
                'description_en'=>'',
            ],
            [
                'name'=>'Creazione pitch',
                'description'=>'',
                'name_en'=>'Pitch',
                'description_en'=>'',
            ],
            [
                'name'=>'Creazione business plan',
                'description'=>'',
                'name_en'=>'Business plan',
                'description_en'=>'',
            ],
            [
                'name'=>'Compilazione bandi',
                'description'=>'',
                'name_en'=>'Compilation of notices',
                'description_en'=>'',
            ],
            [
                'name'=>'Crowdfunding',
                'description'=>'Il crowdfunding è un modo di raccogliere denaro per finanziare progetti e imprese. Esso consente ai fundraiser di raccogliere denaro da un gran numero di persone attraverso piattaforme online.',
                'name_en'=>'Crowdfunding',
                'description_en'=>'Crowdfunding is a way of raising money to finance projects and businesses. It allows fundraisers to raise money from large numbers of people through online platforms.',
            ],
            [
                'name'=>'Finanza agevolata',
                'description'=>'',
                'name_en'=>'Subsidized finance',
                'description_en'=>'',
            ],
            [
                'name'=>'Marketing',
                'description'=>'',
                'name_en'=>'Marketing',
                'description_en'=>'',
            ],
            [
                'name'=>'Mentoring',
                'description'=>'Il mentor offre servizi di consulenza volti a guidare le startup dalla fase di concepimento dell\'idea, al fine di individuare la strategia di sviluppo più opportuna.',
                'name_en'=>'Mentoring',
                'description_en'=>'The mentor offers consulting services aimed at guiding startups from the conception phase of the idea, in order to identify the most appropriate development strategy.',
            ],
            [
                'name'=>'Sviluppo nocode',
                'description'=>'',
                'name_en'=>'Nocode development',
                'description_en'=>'',
            ],
            [
                'name'=>'Sviluppo Software',
                'description'=>'',
                'name_en'=>'Software development',
                'description_en'=>'',
            ],
        ];

        foreach ($startupserviceTypes as $startupserviceType){
            $new_startupserviceType = new StartupserviceType();
            $new_startupserviceType->name = $startupserviceType['name'];
            $new_startupserviceType->description = $startupserviceType['description'];
            $new_startupserviceType->name_en = $startupserviceType['name_en'];
            $new_startupserviceType->description_en = $startupserviceType['description_en'];
            $new_startupserviceType->save();
        }
    }
}
