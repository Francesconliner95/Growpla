<?php

use Illuminate\Database\Seeder;
use App\Region;

class RegionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      DB::table('regions')->delete();

      $regions = [
          [
              'country_id'=>1,
              'name'=>'Abruzzo',
          ],
          [
              'country_id'=>1,
              'name'=>'Basilicata',
          ],
          [
              'country_id'=>1,
              'name'=>'Calabria',
          ],
          [
              'country_id'=>1,
              'name'=>'Campania',
          ],
          [
              'country_id'=>1,
              'name'=>'Emilia Romagna',
          ],
          [
              'country_id'=>1,
              'name'=>'Friuli-Venezia Giulia',
          ],
          [
              'country_id'=>1,
              'name'=>'Lazio',
          ],
          [
              'country_id'=>1,
              'name'=>'Liguria',
          ],
          [
              'country_id'=>1,
              'name'=>'Lombardia',
          ],
          [
              'country_id'=>1,
              'name'=>'Marche',
          ],
          [
              'country_id'=>1,
              'name'=>'Molise',
          ],
          [
              'country_id'=>1,
              'name'=>'Piemonte',
          ],
          [
              'country_id'=>1,
              'name'=>'Puglia',
          ],
          [
              'country_id'=>1,
              'name'=>'Sardegna',
          ],
          [
              'country_id'=>1,
              'name'=>'Sicilia',
          ],
          [
              'country_id'=>1,
              'name'=>'Toscana',
          ],
          [
              'country_id'=>1,
              'name'=>'Trentino-Alto Adige',
          ],
          [
              'country_id'=>1,
              'name'=>'Umbria',
          ],
          [
              'country_id'=>1,
              'name'=>'Valle d\'Aosta',
          ],
          [
              'country_id'=>1,
              'name'=>'Veneto',
          ],
      ];

      DB::table('regions')->insert($regions);

      // foreach ($regions as $region){
      //     $new_region = new Region();
      //     $new_region->country_id = $region['country_id'];
      //     $new_region->name = $region['name'];
      //     $new_region->save();
      // }
    }
}
