<?php

use Illuminate\Database\Seeder;
use App\Moneyrange;

class MoneyrangesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('moneyranges')->delete();
      $moneyranges = [
          [
              'range'=>'<50k',
              'value'=> null,
          ],
          [
              'range'=>'50K-250K',
              'value'=> null,
          ],
          [
              'range'=>'50K-500K',
              'value'=> null,
          ],
          [
              'range'=>'500K-1M',
              'value'=> null,
          ],
          [
              'range'=>'>1M',
              'value'=> null,
          ],
      ];

      foreach ($moneyranges as $moneyrange){
          $new_moneyrange = new Moneyrange();
          $new_moneyrange->range = $moneyrange['range'];
          $new_moneyrange->value = $moneyrange['value'];
          $new_moneyrange->save();
      }
    }
}
