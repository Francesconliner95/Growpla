<?php

use Illuminate\Database\Seeder;
use App\Tag;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = ['Ambiente ed energia','Intelligenza Artificiale','Robot','Biotecnologia','Salute','Farmaceutica','Cibo ed acqua','Educazione','Internet','Pubblica Amministrazione','Miglioramento della vita umana','Realtà aumentata','Scienza','Trasporti','Un milione di nuovi lavori','Programmazione','Show Business','Tech per ogni età e popolo','Paesi emarginati','Software aziendali','Servizi finanziari','Telecomunicazioni','Aerospazio','Automazione industriale', 'Bioagroalimentare','Cloud computing','E-commerce','E-government','Infrastruttura e sicurezza','Internet of things','Life Sciences','Materiali Innovativi','Nanotech','Smart cities','Social network','Turismo e beni culturali'];

        foreach ($tags as $tag){
            $new_tag = new Tag();
            $new_tag->name = $tag;
            $new_tag->save();
        }
    }
}
