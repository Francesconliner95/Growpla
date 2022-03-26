<?php

use Illuminate\Database\Seeder;
use App\Moneyrange;
use Illuminate\Support\Facades\Schema;

class MoneyrangesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('moneyranges')->truncate();
        Schema::enableForeignKeyConstraints();
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
