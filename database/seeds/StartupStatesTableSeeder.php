<?php

use Illuminate\Database\Seeder;
use App\StartupState;
use App\StartupserviceType;

class StartupStatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $startup_states = [
            [
                'name'=> 'Pre-seed',
                'description'=> 'La fase di pre-seed è la prima del ciclo di vita di una startup e coincide con il momento in cui viene concepita l’idea di business. Durante la stessa è necessario valutare se l’idea funziona, c’è un mercato potenziale e se persone sono disposte a pagare per il prodotto o servizio offerto',
                'description_en'=>'The pre-seed phase is the first in the life cycle of a startup and it coincides with the moment in which the business idea is conceived. During this phase it is necessary to assess whether the idea works, if there is a potential market and if people are willing to pay for the product or service offered',
            ],
            [
                'name'=>'Seed',
                'description'=>'Fase in cui si procede alla creazione del modello di business, del business plan e dell’MVP, ossia la versione iniziale del prodotto che si intende immettere sul mercato',
                'description_en'=>'Phase in which the business model, business plan and MVP are created, that is the initial version of the product that you want to place on the market',
            ],
            [
                'name'=>'Early-stage',
                'description'=>'In questa fase l’MVP viene lanciato sul mercato al fine di ottenere un feedback dallo stesso ed individuare il product/market fit',
                'description_en'=>'In this phase, the MVP is launched on the market in order to obtain feedback from it and identify the product/market fit',
            ],
            [
                'name'=>'Early-growth Round A',
                'description'=>'Fase di crescita della startup in cui si lavora sul modello di business, sul piano di marketing e sulla strategia commerciale con l’obiettivo di espandersi a livello nazionale ed internazionale. Per far fronte all’aumento dei clienti si ricorre al Round di investimento di Serie A',
                'description_en'=>'Growth phase of the startup in which you work on the business model, the marketing plan and the commercial strategy with the aim of a national and international expansion. The Series A investment round is used to cope with the increase in customers',
            ],
            [
                'name'=>'Early-growth Round B',
                'description'=>'Fase di crescita della startup in cui si lavora sul modello di business, sul piano di marketing e sulla strategia commerciale con l’obiettivo di espandersi a livello nazionale ed internazionale. Per far fronte all’aumento dei clienti si ricorre al Round di investimento di Serie B',
                'description_en'=>'Growth phase of the startup in which you work on the business model, the marketing plan and the commercial strategy with the aim of a national and international expansion. The Series B investment round is used to cope with the increase in customers',
            ],
            [
                'name'=>'Growth',
                'description'=>'Fase contraddistinta dalla crescita sostenuta dei clienti e del fatturato',
                'description_en'=>'Phase marked by sustained growth in customers and turnover',
            ],
            [
                'name'=>'Exit',
                'description'=>'Gli investitori escono dalla proprietà della startup segnando il passaggio dalla fase di startup a quella successiva',
                'description_en'=>'Investors leave the startup\'s ownership, marking the transition from the startup phase to the next',
            ],
        ];

        foreach ($startup_states as $state){
            $new_state = new StartupState();
            $new_state->name = $state->name;
            $new_state->description = $state->description;
            $new_state->description_en = $state->description_en;
            $new_state->save();
        }
    }
}
