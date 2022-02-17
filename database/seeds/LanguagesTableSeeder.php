<?php

use Illuminate\Database\Seeder;
use App\Language;

class LanguagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $languages = [
            [
                'lang' => 'en',
                'name' => 'english',
            ],
            [
                'lang' => 'it',
                'name' => 'italiano',
            ],
        ];

        foreach ($languages as $language){
            $new_language = new Language();
            $new_language->lang = $language['lang'];
            $new_language->name = $language['name'];
            $new_language->save();
        }
    }
}
