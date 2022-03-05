<?php

use Illuminate\Database\Seeder;
use App\Currency;

class CurrenciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('currencies')->delete();
        $currencies = [
            [
                'name'=>'Euro',
                'code'=>'EUR',
                'symbol'=>'€',
            ],
            [
                'name'=>'Dollars',
                'code'=>'USD',
                'symbol'=>'$',
            ],
            [
                'name'=>'Pounds',
                'code'=>'GBP',
                'symbol'=>'£',
            ],
        ];

        foreach ($currencies as $currency){
            $new_currency = new Currency();
            $new_currency->name = $currency['name'];
            $new_currency->code = $currency['code'];
            $new_currency->symbol = $currency['symbol'];
            $new_currency->save();
        }
    }
}
