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
        $this->call(SectorsTableSeeder::class);
        $this->call(MainServicesTableSeeder::class);
        $this->call(ServicesTableSeeder::class);
        $this->call(HavePagetypeServiceTableSeeder::class);
        $this->call(GivePagetypeServiceTableSeeder::class);
        $this->call(SkillsTableSeeder::class);
        $this->call(LifecyclesTableSeeder::class);
        $this->call(CountriesTableSeeder::class);
        $this->call(RegionsTableSeeder::class);
        $this->call(SupportTypesTableSeeder::class);
        $this->call(NotificationTypesTableSeeder::class);
        $this->call(IncubatorsTableSeeder::class);
        $this->call(MailSettingsTableSeeder::class);
    }
}
