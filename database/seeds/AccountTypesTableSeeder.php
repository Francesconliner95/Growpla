<?php

use Illuminate\Database\Seeder;
use App\AccountType;

class AccountTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $accout_types = [
            [
                'name'=>'Startup',
                'description'=>'',
                'name_en'=>'Startup',
                'description_en'=>'',
            ],
            [
                'name'=>'Aspirante Cofounder',
                'description'=>'Il co-founder è quel soggetto che possiede risorse e/o competenze (lavorative o di altro tipo) che possono aiutare il founder nella realizzazione/esecuzione della sua idea imprenditoriale.',
                'name_en'=>'Cofounder',
                'description_en'=>'The Co-founder is the person who has resources and / or skills (work or other) that can help the founder in the realization / execution of his business idea.',
            ],
            [
                'name'=>'Incubatore/Acceleratore',
                'description'=>'Un incubatore d’impresa è un’organizzazione che accelera e rende sistematico il processo di creazione di nuove imprese fornendo loro una vasta gamma di servizi di supporto integrati che includono gli spazi fisici dell’incubatore, i servizi di supporto allo sviluppo del business e le opportunità di integrazione e networking.
                L’acceleratore è un programma volto ad accelerare lo sviluppo di startup e di imprese early stage, all\'interno del quale si offre supporto imprenditoriale attraverso l’erogazione di servizi, l’organizzazione di attività di networking, la possibilità di ottenere consulenze sul modello di business, la fornitura di spazi fisici nei quali lavorare.
                Generalmente all\'interno di una stessa struttura sono offerti sia i servizi di incubazione che di accelerazione.',
                'name_en'=>'Incubator/Accelerator',
                'description_en'=>'A business incubator is an organization that accelerates and systematizes the process of creating new businesses by providing them with a wide range of integrated support services that include physical incubator spaces, business development support services and opportunities for integration and networking.
                The accelerator is a program aimed at accelerating the development of startups and early stage companies, within which entrepreneurial support is offered through the provision of services, the organization of networking activities, the possibility of obtaining consultancy on the model of business, the provision of physical spaces in which to work.
                Generally, both incubation and acceleration services are offered within the same structure.',
            ],
            [
                'name'=>'Business Angel',
                'description'=>'Il business angel è un soggetto privato che conferisce fondi ad una startup (oltreché know-how e la sua rete di relazioni) al fine di ottenere in cambio capitale di rischio della stessa e diventarne socio. ',
                'name_en'=>'Business Angel',
                'description_en'=>'The business angel is a private entity that grants funds to a startup (as well as know-how and its network of relationships) in order to obtain its capital risk in exchange for becoming a partner.',
            ],
            [
                'name'=>'Private Equity',
                'description'=>'I fondi di private equity intervengono quando l’azienda appare matura e solida dal punto di vista finanziario ed organizzativo, limitandosi ad apportare capitali necessari all’espansione della stessa',
                'name_en'=>'Private Equity',
                'description_en'=>'Private equity funds intervene when the company appears mature and solid from a financial and organizational point of view, limiting itself to providing capital necessary for its expansion.',
            ],
            [
                'name'=>'Venture Capital',
                'description'=>'I Venture capital sono investitori istituzionali che intervengono in una fase in cui le startup hanno già fatto registrare tassi di crescita del fatturato rilevanti, apportando capitali ed esperienza in strategia e governance.',
                'name_en'=>'Venture Capital',
                'description_en'=>'Venture capital are institutional investors who intervene in a phase in which startups have already registered significant growth rates in turnover, bringing capital and experience in strategy and governance.',
            ],
            [
                'name'=>'Servizi alle aziende',
                'description'=>'Aziende e liberi professionisti che offrono alle startup e alle aziende i servizi di cui hanno bisogno',
                'name_en'=>'Startup Services',
                'description_en'=>'Companies and freelancers who offer startups and companies the services they need',
            ],
            [
                'name'=>'Agenzia Nazionale/Regionale',
                'description'=>'Agenzie costituite allo scopo di attrarre investimenti e favorire lo sviluppo delle imprese',
                'name_en'=>'Regional/National Agency',
                'description_en'=>'Agencies set up for the purpose of attracting investments and promoting business development',
            ],
        ];
        foreach ($accout_types as $accout_type){
            $new_accout_type = new AccountType();
            $new_accout_type->name = $accout_type['name'];
            $new_accout_type->description = $accout_type['description'];
            $new_accout_type->name_en = $accout_type['name_en'];
            $new_accout_type->description_en = $accout_type['description_en'];
            $new_accout_type->save();
        }
    }
}
