<?php

use Illuminate\Database\Seeder;
use App\Background;

class BackgroundsTableSeeder extends Seeder
{
    public function run(){
        Schema::disableForeignKeyConstraints();
        DB::table('backgrounds')->truncate();
        Schema::enableForeignKeyConstraints();

        $backgrounds = [

            [
              'name'=>'Scienze agrarie',
              'hidden'=>null,
            ],
            [
                'name'=>'Scienze ambientali',
                'hidden'=>null,
            ],
            [
                'name'=>'Scienze atmosferiche',
                'hidden'=>null,
            ],
            [
                'name'=>'Scienze biologiche',
                'hidden'=>null,
            ],
            [
                'name'=>'Scienze chimiche',
                'hidden'=>null,
            ],
            [
                'name'=>'Scienze cognitive',
                'hidden'=>null,
            ],
            [
                'name'=>'Scienze dei beni culturali',
                'hidden'=>null,
            ],
            [
                'name'=>'Scienze dei materiali',
                'hidden'=>null,
            ],
            [
                'name'=>'Scienze del comportamento',
                'hidden'=>null,
            ],
            [
                'name'=>'Scienze del servizio sociale',
                'hidden'=>null,
            ],
            [
              'name'=>'Scienze del suolo',
              'hidden'=>null,
            ],
            [
                'name'=>'Scienze della comunicazione',
                'hidden'=>null,
            ],
            [
                'name'=>'Scienze della formazione',
                'hidden'=>null,
            ],
            [
                'name'=>'Scienze della vita e della terra',
                'hidden'=>null,
            ],
            [
                'name'=>'Scienze dell\'ambiente',
                'hidden'=>null,
            ],
            [
                'name'=>'Scienze dell\'educazione',
                'hidden'=>null,
            ],
            [
                'name'=>'Scienze dell\'educazione motoria',
                'hidden'=>null,
            ],
            [
                'name'=>'Scienze dell\'informazione',
                'hidden'=>null,
            ],
            [
                'name'=>'Scienze dello spazio',
                'hidden'=>null,
            ],
            [
                'name'=>'Scienze di base',
                'hidden'=>null,
            ],
            [
              'name'=>'Scienze documentarie della storia',
              'hidden'=>null,
            ],
            [
                'name'=>'Scienze economiche',
                'hidden'=>null,
            ],
            [
                'name'=>'Scienze etno-sntropologiche',
                'hidden'=>null,
            ],
            [
                'name'=>'Scienze fisiche e matematiche',
                'hidden'=>null,
            ],
            [
                'name'=>'Scienze forensi',
                'hidden'=>null,
            ],
            [
                'name'=>'Scienze forestali',
                'hidden'=>null,
            ],
            [
                'name'=>'Scienze gastronomiche',
                'hidden'=>null,
            ],
            [
                'name'=>'Scienze geologiche',
                'hidden'=>null,
            ],
            [
                'name'=>'Scienze medico-sanitarie',
                'hidden'=>null,
            ],
            [
                'name'=>'Scienze informatiche',
                'hidden'=>null,
            ],
            [
              'name'=>'Scienze ingegneristiche',
              'hidden'=>null,
            ],
            [
                'name'=>'Scienze motorie e sportive',
                'hidden'=>null,
            ],
            [
                'name'=>'Scienze naturali',
                'hidden'=>null,
            ],
            [
                'name'=>'Scienze neurologiche',
                'hidden'=>null,
            ],
            [
                'name'=>'Scienze organizzative e gestionali',
                'hidden'=>null,
            ],
            [
                'name'=>'Scienze pedagogiche',
                'hidden'=>null,
            ],
            [
                'name'=>'Scienze politiche',
                'hidden'=>null,
            ],
            [
                'name'=>'Scienze sociali',
                'hidden'=>null,
            ],
            [
                'name'=>'Scienze statistiche',
                'hidden'=>null,
            ],
            [
                'name'=>'Scienze strategiche',
                'hidden'=>null,
            ],
            [
                'name'=>'Scienze umane',
                'hidden'=>null,
            ],
        ];

        foreach ($backgrounds as $background){
            $new_background = new Background();
            $new_background->name = $background['name'];
            $new_background->hidden = $background['hidden'];
            $new_background->save();
        }
    }
}
