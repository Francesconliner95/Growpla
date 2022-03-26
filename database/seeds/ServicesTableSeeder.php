<?php

use Illuminate\Database\Seeder;
use App\Service;
use Illuminate\Support\Facades\Schema;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('services')->truncate();
        Schema::enableForeignKeyConstraints();

        $services = [
            [
              'name_it'=>'Advisor',
              'description_it'=>'L\'advisor è un consulente che supporta le startup in fusioni, acquisizioni, joint-venture ed in generale nella fase di exit.',
              'name'=>'Advisor',
              'description'=>'The advisor is a consultant who supports startups in mergers, acquisitions, joint ventures and in general in the exit phase.',
              'pagetype_id' => 1,
            ],
            [
              'name_it'=>'Coaching',
              'description_it'=>'Il coach è un soggetto che aiuta il team a migliorarsi rendendolo in grado di risolvere problemi di business.',
              'name'=>'Coaching',
              'description'=>'The coach is a person who helps the team to improve by making it able to solve business problems.',
              'pagetype_id' => 1,
            ],
            [
              'name_it'=>'Creazione pitch',
              'description_it'=>'',
              'name'=>'Pitch',
              'description'=>'',
              'pagetype_id' => 1,
            ],
            [
              'name_it'=>'Business plan',
              'description_it'=>'',
              'name'=>'Business plan',
              'description'=>'',
              'pagetype_id' => 1,
            ],
            [
              'name_it'=>'Compilazione bandi',
              'description_it'=>'',
              'name'=>'Compilation of notices',
              'description'=>'',
              'pagetype_id' => 1,
            ],
            [
              'name_it'=>'Crowdfunding',
              'description_it'=>'Il crowdfunding è un modo di raccogliere denaro per finanziare progetti e imprese. Esso consente ai fundraiser di raccogliere denaro da un gran numero di persone attraverso piattaforme online.',
              'name'=>'Crowdfunding',
              'description'=>'Crowdfunding is a way of raising money to finance projects and businesses. It allows fundraisers to raise money from large numbers of people through online platforms.',
              'pagetype_id' => 1,
            ],
            [
              'name_it'=>'Finanza agevolata',
              'description_it'=>'',
              'name'=>'Subsidized finance',
              'description'=>'',
              'pagetype_id' => 1,
            ],
            [
              'name_it'=>'Mentoring',
              'description_it'=>'Il mentor offre servizi di consulenza volti a guidare le startup dalla fase di concepimento dell\'idea, al fine di individuare la strategia di sviluppo più opportuna.',
              'name'=>'Mentoring',
              'description'=>'The mentor offers consulting services aimed at guiding startups from the conception phase of the idea, in order to identify the most appropriate development strategy.',
              'pagetype_id' => 1,
            ],
            [
              'name_it'=>'Costituzione societaria',
              'description_it'=>'',
              'name'=>'Company constitution',
              'description'=>'',
              'pagetype_id' => null,
            ],
            [
              'name_it'=>'Marketing e Digital Marketing',
              'description_it'=>'',
              'name'=>'Marketing e Digital Marketing',
              'description'=>'',
              'pagetype_id' => null,
            ],

            [
              'name_it'=>'Sviluppo nocode',
              'description_it'=>'',
              'name'=>'Nocode development',
              'description'=>'',
              'pagetype_id' => null,
            ],
            [
              'name_it'=>'Sviluppo Software',
              'description_it'=>'',
              'name'=>'Software development',
              'description'=>'',
              'pagetype_id' => null,
            ],
            [
              'name_it'=>'Graphic designer',
              'description_it'=>'',
              'name'=>'Graphic designer',
              'description'=>'',
              'pagetype_id' => null,
            ],
            [
              'name_it'=>'UI/UX',
              'description_it'=>'',
              'name'=>'UI/UX',
              'description'=>'',
              'pagetype_id' => null,
            ],
            [
              'name_it'=>'Commercialista',
              'description_it'=>'',
              'name'=>'Financial advisor',
              'description'=>'',
              'pagetype_id' => null,
            ],
            [
              'name_it'=>'Consulenza legale',
              'description_it'=>'',
              'name'=>'Legal advice',
              'description'=>'',
              'pagetype_id' => null,
            ],
        ];

        foreach ($services as $service){
          $new_service = new Service();
          $new_service->name = $service['name_it'];
          //$new_service->name_it = $service['name_it'];
          $new_service->description = $service['description_it'];
          //$new_service->description_it = $service['description_it'];
          $new_service->pagetype_id = $service['pagetype_id'];
          //dd($new_service);
          $new_service->save();
        }
    }
}
