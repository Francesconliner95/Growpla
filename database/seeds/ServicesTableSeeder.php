<?php

use Illuminate\Database\Seeder;
use App\Service;

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
              'name'=>'Brevetti e Marchi',
              'description'=> null,
              'main_service_id'=> 1,
              'hidden'=>null,
            ],
            [
                'name'=>'Compliance',
                'description'=> null,
                'main_service_id'=> 1,
                'hidden'=>null,
            ],
            [
                'name'=>'Consulenza Legale',
                'description'=> null,
                'main_service_id'=> 1,
                'hidden'=>null,
            ],
            [
                'name'=>'Cookie Policy',
                'description'=> null,
                'main_service_id'=> 1,
                'hidden'=>null,
            ],
            [
                'name'=>'Costituzione Socetaria',
                'description'=> null,
                'main_service_id'=> 1,
                'hidden'=>null,
            ],
            [
                'name'=>'GDPR',
                'description'=> null,
                'main_service_id'=> 1,
                'hidden'=>null,
            ],
            [
                'name'=>'Privacy Policy',
                'description'=> null,
                'main_service_id'=> 1,
                'hidden'=>null,
            ],
            [
                'name'=>'Redazione Contratti',
                'description'=> null,
                'main_service_id'=> 1,
                'hidden'=>null,
            ],
            [
                'name'=>'Patti Parasociali',
                'description'=> null,
                'main_service_id'=> 1,
                'hidden'=>null,
            ],
            [
                'name'=>'Term Sheet ed Accordi di Investimento',
                'description'=> null,
                'main_service_id'=> 1,
                'hidden'=>null,
            ],
            [
                'name'=>'Tutela della Proprietà Intellettuale',
                'description'=> null,
                'main_service_id'=> 1,
                'hidden'=>null,
            ],
            [
                'name'=>'Contrattualistica',
                'description'=> null,
                'main_service_id'=> 1,
                'hidden'=>null,
            ],
            [
                'name'=>'Due Diligence',
                'description'=> null,
                'main_service_id'=> 1,
                'hidden'=>null,
            ],
            [
                'name'=>'Internazionalizzazione',
                'description'=> null,
                'main_service_id'=> 1,
                'hidden'=>null,
            ],
            [
                'name'=>'Blogging',
                'description'=> null,
                'main_service_id'=> 2,
                'hidden'=>null,
            ],
            [
                'name'=>'Branding',
                'description'=> null,
                'main_service_id'=> 2,
                'hidden'=>null,
            ],
            [
                'name'=>'Community Management',
                'description'=> null,
                'main_service_id'=> 2,
                'hidden'=>null,
            ],
            [
                'name'=>'Content Creation',
                'description'=> null,
                'main_service_id'=> 2,
                'hidden'=>null,
            ],
            [
                'name'=>'Copywriting',
                'description'=> null,
                'main_service_id'=> 2,
                'hidden'=>null,
            ],
            [
                'name'=>'CRO - Conversion Rate Optimization',
                'description'=> null,
                'main_service_id'=> 2,
                'hidden'=>null,
            ],
            [
                'name'=>'Marketing e Digital Marketing',
                'description'=> null,
                'main_service_id'=> 2,
                'hidden'=>null,
            ],
            [
                'name'=>'Media Planning',
                'description'=> null,
                'main_service_id'=> 2,
                'hidden'=>null,
            ],
            [
                'name'=>'SEM - Search Engine Marketing',
                'description'=> null,
                'main_service_id'=> 2,
                'hidden'=>null,
            ],
            [
                'name'=>'SEO - Search Engine Optimization',
                'description'=> null,
                'main_service_id'=> 2,
                'hidden'=>null,
            ],
            [
                'name'=>'Social Media',
                'description'=> null,
                'main_service_id'=> 2,
                'hidden'=>null,
            ],
            [
                'name'=>'Web Editing',
                'description'=> null,
                'main_service_id'=> 2,
                'hidden'=>null,
            ],
            [
                'name'=>'Web Marketing',
                'description'=> null,
                'main_service_id'=> 2,
                'hidden'=>null,
            ],
            [
                'name'=>'Video Making',
                'description'=> null,
                'main_service_id'=> 2,
                'hidden'=>null,
            ],
            [
                'name'=>'Video Editing',
                'description'=> null,
                'main_service_id'=> 2,
                'hidden'=>null,
            ],
            [
                'name'=>'Database',
                'description'=> null,
                'main_service_id'=> 3,
                'hidden'=>null,
            ],
            [
                'name'=>'Hacking',
                'description'=> null,
                'main_service_id'=> 3,
                'hidden'=>null,
            ],
            [
                'name'=>'IT Security',
                'description'=> null,
                'main_service_id'=> 3,
                'hidden'=>null,
            ],
            [
                'name'=>'Software Testing',
                'description'=> null,
                'main_service_id'=> 3,
                'hidden'=>null,
            ],
            [
                'name'=>'Web/App Development',
                'description'=> null,
                'main_service_id'=> 3,
                'hidden'=>null,
            ],
            [
                'name'=>'Graphic Design',
                'description'=> null,
                'main_service_id'=> 4,
                'hidden'=>null,
            ],
            [
                'name'=>'UI Design',
                'description'=> null,
                'main_service_id'=> 4,
                'hidden'=>null,
            ],
            [
                'name'=>'UX Design',
                'description'=> null,
                'main_service_id'=> 4,
                'hidden'=>null,
            ],
            [
                'name'=>'Advisor',
                'description'=>'L\'advisor è un consulente che supporta le startup in fusioni, acquisizioni, joint-venture ed in generale nella fase di exit.',
                'main_service_id'=> 5,
                'hidden'=>null,
            ],
            [
                'name'=>'Analisi di Mercato e Business Plan',
                'description'=> null,
                'main_service_id'=> 5,
                'hidden'=>null,
            ],
            [
                'name'=>'Coaching',
                'description'=>'Il coach è un soggetto che aiuta il team a migliorarsi rendendolo in grado di risolvere problemi di business.',
                'main_service_id'=> 5,
                'hidden'=>null,
            ],
            [
                'name'=>'Compilazione Bandi e Finanza Agevolata',
                'description'=> null,
                'main_service_id'=> 5,
                'hidden'=>null,
            ],
            [
                'name'=>'Creazione Pitch',
                'description'=> null,
                'main_service_id'=> 5,
                'hidden'=>null,
            ],
            [
                'name'=>'Crowdfunding',
                'description'=>'Il crowdfunding è un modo di raccogliere denaro per finanziare progetti e imprese. Esso consente ai fundraiser di raccogliere denaro da un gran numero di persone attraverso piattaforme online.',
                'main_service_id'=> 5,
                'hidden'=>null,
            ],
            [
                'name'=>'Mentoring',
                'description'=>'Il mentor offre servizi di consulenza volti a guidare le startup dalla fase di concepimento dell\'idea, al fine di individuare la strategia di sviluppo più opportuna.',
                'main_service_id'=> 5,
                'hidden'=>null,
            ],
            [
                'name'=>'Product Design',
                'description'=> null,
                'main_service_id'=> 6,
                'hidden'=>null,
            ],
            [
                'name'=>'Product Development',
                'description'=> null,
                'main_service_id'=> 6,
                'hidden'=>null,
            ],
            [
                'name'=>'Business Development',
                'description'=> null,
                'main_service_id'=> 7,
                'hidden'=>null,
            ],
            [
                'name'=>'Contabilità e Consulenza ad Imprese e Privati',
                'description'=> null,
                'main_service_id'=> 7,
                'hidden'=>null,
            ],
            [
                'name'=>'Data Analysis',
                'description'=> null,
                'main_service_id'=> 7,
                'hidden'=>null,
            ],
            [
                'name'=>'Data Science',
                'description'=> null,
                'main_service_id'=> 7,
                'hidden'=>null,
            ],
            [
                'name'=>'Project Management',
                'description'=> null,
                'main_service_id'=> 7,
                'hidden'=>null,
            ],
            [
                'name'=>'Fundraising',
                'description'=> null,
                'main_service_id'=> 7,
                'hidden'=>null,
            ],
            [
                'name'=>'Valutazione pre-money',
                'description'=> null,
                'main_service_id'=> 7,
                'hidden'=>null,
            ],
            [
                'name'=>'Pianificazione Strategica e Piani Industriali',
                'description'=> null,
                'main_service_id'=> 7,
                'hidden'=>null,
            ],
            [
                'name'=>'Analisi di Fattibilità Economica/Finanziaria',
                'description'=> null,
                'main_service_id'=> 7,
                'hidden'=>null,
            ],
            [
                'name'=>'Gestione contabilità e dichiarazioni fiscali',
                'description'=> null,
                'main_service_id'=> 7,
                'hidden'=>null,
            ],
            [
                'name'=>'Controllo di Gestione',
                'description'=> null,
                'main_service_id'=> 7,
                'hidden'=>null,
            ],
            [
                'name'=>'Internazionalizzazione del business',
                'description'=> null,
                'main_service_id'=> 7,
                'hidden'=>null,
            ],
            [
                'name'=>'Networking',
                'description'=> null,
                'main_service_id'=> 7,
                'hidden'=>null,
            ],
            [
              'name'=>'NDA',
              'description'=> null,
              'main_service_id'=> 1,
              'hidden'=>null,
            ],
            [
                'name'=>'Corporate Sustainability Strategies',
                'description'=> null,
                'main_service_id'=> 7,
                'hidden'=>null,
            ],

        ];

      foreach ($services as $service){
            $new_service = new Service();
            $new_service->name = $service['name'];
            $new_service->description = $service['description'];
            $new_service->main_service_id = $service['main_service_id'];
            $new_service->hidden = $service['hidden'];
            $new_service->save();
      }
    }
}
