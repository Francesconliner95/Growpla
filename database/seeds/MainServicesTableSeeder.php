<?php

use Illuminate\Database\Seeder;
use App\MainService;

class MainServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('main_services')->truncate();
        Schema::enableForeignKeyConstraints();
        $main_services = [

            [
                'name'=>'Legal',//1
            ],
            [
                'name'=>'Marketing, Comunicazione, Media ed Editoria',//2
            ],
            [
                'name'=>'Informatica',//3
            ],
            [
                'name'=>'Grafica',//4
            ],
            [
                'name'=>'Servizi alle Startup',//5
            ],
            [
                'name'=>'Prodotto',//6
            ],
            [
                'name'=>'Contabilità, Finanza, Controllo e Gestione',//7
            ],
            [
                'name'=>'Business',//8
            ],
            [
                'name'=>'Industria 4.0',//9
            ],
        ];

        foreach ($main_services as $main_service){
            $new_main_service = new MainService();
            $new_main_service->name = $main_service['name'];
            $new_main_service->save();
        }
    }
}
