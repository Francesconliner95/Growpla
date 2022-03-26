<?php

use Illuminate\Database\Seeder;
use App\Lifecycle;
use Illuminate\Support\Facades\Schema;

class LifecyclesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('lifecycles')->truncate();
        Schema::enableForeignKeyConstraints();
      $lifecycles = [
          [
              'name'=> 'Pre-seed',
              'name_it'=> 'Pre-seed',
              'description'=>'The pre-seed phase is the first in the life cycle of a startup and it coincides with the moment in which the business idea is conceived. During this phase it is necessary to assess whether the idea works, if there is a potential market and if people are willing to pay for the product or service offered',
              'description_it'=> 'La fase di pre-seed è la prima del ciclo di vita di una startup e coincide con il momento in cui viene concepita l’idea di business. Durante la stessa è necessario valutare se l’idea funziona, c’è un mercato potenziale e se persone sono disposte a pagare per il prodotto o servizio offerto',
          ],
          [
              'name'=>'Seed',
              'name_it'=>'Seed',
              'description'=>'Phase in which the business model, business plan and MVP are created, that is the initial version of the product that you want to place on the market',
              'description_it'=>'Fase in cui si procede alla creazione del modello di business, del business plan e dell’MVP, ossia la versione iniziale del prodotto che si intende immettere sul mercato',
          ],
          [
              'name'=>'Early-stage',
              'name_it'=>'Early-stage',
              'description'=>'In this phase, the MVP is launched on the market in order to obtain feedback from it and identify the product/market fit',
              'description_it'=>'In questa fase l’MVP viene lanciato sul mercato al fine di ottenere un feedback dallo stesso ed individuare il product/market fit',
          ],
          [
              'name'=>'Early-growth Round A',
              'name_it'=>'Early-growth Round A',
              'description'=>'Growth phase of the startup in which you work on the business model, the marketing plan and the commercial strategy with the aim of a national and international expansion. The Series A investment round is used to cope with the increase in customers',
              'description_it'=>'Fase di crescita della startup in cui si lavora sul modello di business, sul piano di marketing e sulla strategia commerciale con l’obiettivo di espandersi a livello nazionale ed internazionale. Per far fronte all’aumento dei clienti si ricorre al Round di investimento di Serie A',
          ],
          [
              'name'=>'Early-growth Round B',
              'name_it'=>'Early-growth Round B',
              'description'=>'Growth phase of the startup in which you work on the business model, the marketing plan and the commercial strategy with the aim of a national and international expansion. The Series B investment round is used to cope with the increase in customers',
              'description_it'=>'Fase di crescita della startup in cui si lavora sul modello di business, sul piano di marketing e sulla strategia commerciale con l’obiettivo di espandersi a livello nazionale ed internazionale. Per far fronte all’aumento dei clienti si ricorre al Round di investimento di Serie B',
          ],
          [
              'name'=>'Growth',
              'name_it'=>'Growth',
              'description'=>'Phase marked by sustained growth in customers and turnover',
              'description_it'=>'Fase contraddistinta dalla crescita sostenuta dei clienti e del fatturato',
          ],
          [
              'name'=>'Exit',
              'name_it'=>'Exit',
              'description'=>'Investors leave the startup\'s ownership, marking the transition from the startup phase to the next',
              'description_it'=>'Gli investitori escono dalla proprietà della startup segnando il passaggio dalla fase di startup a quella successiva',
          ],
      ];

      foreach ($lifecycles as $lifecycle){
          $new_lifecycle = new Lifecycle();
          $new_lifecycle->name = $lifecycle['name'];
          $new_lifecycle->name_it = $lifecycle['name_it'];
          $new_lifecycle->description = $lifecycle['description'];
          $new_lifecycle->description_it = $lifecycle['description_it'];
          $new_lifecycle->save();
      }
    }
}
