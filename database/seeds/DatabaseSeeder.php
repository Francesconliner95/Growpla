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
        $this->call(AccountTypesTableSeeder::class);
        $this->call(CofounderRolesTableSeeder::class);
        $this->call(RegionsTableSeeder::class);
        $this->call(StartupserviceTypesTableSeeder::class);
        $this->call(StartupStatesTableSeeder::class);
        $this->call(SupportTypesTableSeeder::class);
        $this->call(TagsTableSeeder::class);
        $this->call(CurrenciesTableSeeder::class);
    }
}
