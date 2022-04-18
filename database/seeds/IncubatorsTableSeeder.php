<?php

use Illuminate\Database\Seeder;
use App\Incubator;

class IncubatorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('incubators')->truncate();
        Schema::enableForeignKeyConstraints();

        $incubators = [

            [
                'name'=> 'IC406',
                'image'=> 'incubators/ic406.svg',
                'website'=> 'https://www.ic406.com/',
                'country_id'=> 1,
                'region_id'=> 13,
                'page_id'=> 1,
                'hidden'=>null,
            ],
            [
                'name'=> '',
                'image'=> 'incubators/',
                'website'=> '',
                'country_id'=> 1,
                'region_id'=> null,
                'page_id'=> null,
                'hidden'=>null,
            ],

        ];

        foreach ($incubators as $incubator){
            $new_incubator = new Incubator();
            $new_incubator->name = $incubator['name'];
            $new_incubator->image = $incubator['image'];
            $new_incubator->website = $incubator['website'];
            $new_incubator->country_id = $incubator['country_id'];
            $new_incubator->region_id = $incubator['region_id'];
            $new_incubator->page_id = $incubator['page_id'];
            $new_incubator->hidden = $incubator['hidden'];
            $new_incubator->save();
        }
    }
}
