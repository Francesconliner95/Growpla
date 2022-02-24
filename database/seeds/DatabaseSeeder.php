<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
      $this->call(CurrenciesTableSeeder::class);
      $this->call(LanguagesTableSeeder::class);
      $this->call(MoneyrangesTableSeeder::class);
      $this->call(PagetypeTableSeeder::class);
      $this->call(UsertypeTableSeeder::class);
      //$this->call(SupportTypesTableSeeder::class);
    }
}
