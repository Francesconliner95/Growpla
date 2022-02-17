<?php

use Illuminate\Database\Seeder;
use App\SupportType;

class SupportTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $supportTypes = [
            [
                'name'=>'Collaborazioni',
                'description'=>'',
                'name_en'=>'Collaborations',
                'description_en'=>'',
            ],
            [
                'name'=>'Lavora con noi',
                'description'=>'',
                'name_en'=>'Work with us',
                'description_en'=>'',
            ],
            [
                'name'=>'Segnala un problema',
                'description'=>'',
                'name_en'=>'Report a problem',
                'description_en'=>'',
            ],
            [
                'name'=>'Suggerisci miglioramenti o funzioni',
                'description'=>'',
                'name_en'=>'Suggest improvements or features',
                'description_en'=>'',
            ],
            [
                'name'=>'Altro',
                'description'=>'',
                'name_en'=>'Other',
                'description_en'=>'',
            ],
        ];

        foreach ($supportTypes as $supportType){
            $new_supportType = new SupportType();
            $new_supportType->name = $supportType['name'];
            $new_supportType->description = $supportType['description'];
            $new_supportType->name_en = $supportType['name_en'];
            $new_supportType->description_en = $supportType['description_en'];
            $new_supportType->save();
        }
    }
}
