<?php

use Illuminate\Database\Seeder;
use App\SupportType;
use Illuminate\Support\Facades\Schema;

class SupportTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('support_types')->truncate();
        Schema::enableForeignKeyConstraints();

        $supportTypes = [
            [
                'name_it'=>'Suggerisci ulteriori servizi',
                'description_it'=>'',
                'name'=>'Suggest services',
                'description'=>'',
            ],
            [
                'name_it'=>'Suggerisci ulteriori settori',
                'description_it'=>'',
                'name'=>'Suggest sectors',
                'description'=>'',
            ],
            [
                'name_it'=>'Suggerisci altre aree di formazione',
                'description_it'=>'',
                'name'=>'Suggest background',
                'description'=>'',
            ],
            [
                'name_it'=>'Collaborazioni',
                'description_it'=>'',
                'name'=>'Collaborations',
                'description'=>'',
            ],
            [
                'name_it'=>'Lavora con noi',
                'description_it'=>'',
                'name'=>'Work with us',
                'description'=>'',
            ],
            [
                'name_it'=>'Segnala un problema',
                'description_it'=>'',
                'name'=>'Report a problem',
                'description'=>'',
            ],
            [
                'name_it'=>'Suggerisci miglioramenti o funzioni',
                'description_it'=>'',
                'name'=>'Suggest improvements or features',
                'description'=>'',
            ],
            [
                'name_it'=>'Altro',
                'description_it'=>'',
                'name'=>'Other',
                'description'=>'',
            ],
        ];

        foreach ($supportTypes as $supportType){
            $new_supportType = new SupportType();
            $new_supportType->name_it = $supportType['name_it'];
            $new_supportType->description = $supportType['description_it'];
            $new_supportType->name = $supportType['name'];
            $new_supportType->description = $supportType['description'];
            $new_supportType->save();
        }
    }
}
