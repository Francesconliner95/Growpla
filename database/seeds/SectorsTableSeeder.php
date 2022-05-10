<?php

use Illuminate\Database\Seeder;
use App\Sector;
use Illuminate\Support\Facades\Schema;

class SectorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('sectors')->truncate();
        Schema::enableForeignKeyConstraints();

      $sectors = [
          [
              'name'=>'Clothing',
              'name_it'=>'Abbigliamento',
          ],
          [
              'name'=>'Agriculture and farming',
              'name_it'=>'Agricoltura e allevamento',
          ],
          [
              'name'=>'Consumer goods',
              'name_it'=>'Beni di consumo',
          ],
          [
              'name'=>'Biotechnology',
              'name_it'=>'Biotecnologie',
          ],
          [
              'name'=>'Food and beverages',
              'name_it'=>'Cibo e Bevande',
          ],
          [
              'name'=>'Circular Economy',
              'name_it'=>'Circular Economy',
          ],
          [
              'name'=>'Business',
              'name_it'=>'Commercio',
          ],
          [
              'name'=>'Data and analysis',
              'name_it'=>'Dati e analisi',
          ],
          [
              'name'=>'Design',
              'name_it'=>'Design',
          ],
          [
              'name'=>'Publishing',
              'name_it'=>'Editoria',
          ],
          [
              'name'=>'Education',
              'name_it'=>'Educazione',
          ],
          [
              'name'=>'Electronics',
              'name_it'=>'Elettronica',
          ],
          [
              'name'=>'Power',
              'name_it'=>'Energia',
          ],
          [
              'name'=>'Fintech e Insuretech',
              'name_it'=>'Fintech e Insuretech',
          ],
          [
              'name'=>'Gaming',
              'name_it'=>'Gaming',
          ],
          [
              'name'=>'Green Economy',
              'name_it'=>'Green Economy',
          ],
          [
              'name'=>'Hardware',
              'name_it'=>'Hardware',
          ],
          [
              'name'=>'ICT',
              'name_it'=>'ICT',
          ],
          [
              'name'=>'Real estate',
              'name_it'=>'Immobiliare',
          ],
          [
              'name'=>'Industry 4.0',
              'name_it'=>'Industria 4.0',
          ],
          [
              'name'=>'Informatics',
              'name_it'=>'Informatica',
          ],
          [
              'name'=>'Engineering',
              'name_it'=>'Ingegneria ',
          ],
          [
              'name'=>'AI and Machine Learning',
              'name_it'=>'IA e machine learning',
          ],
          [
              'name'=>'Instruction',
              'name_it'=>'Istruzione',
          ],
          [
              'name'=>'Legal',
              'name_it'=>'Legal',
          ],
          [
              'name'=>'Marketing',
              'name_it'=>'Marketing',
          ],
          [
              'name'=>'Media and entertainment',
              'name_it'=>'Media e intrattenimento',
          ],
          [
              'name'=>'Medicine',
              'name_it'=>'Medicina',
          ],
          [
              'name'=>'Music and audio',
              'name_it'=>'Musica e audio',
          ],
          [
              'name'=>'Payments',
              'name_it'=>'Pagamenti',
          ],
          [
              'name'=>'Loans and investments',
              'name_it'=>'Prestiti e investimenti',
          ],
          [
              'name'=>'Privacy and security',
              'name_it'=>'Privacy e sicurezza',
          ],
          [
              'name'=>'Production',
              'name_it'=>'Produzione',
          ],
          [
              'name'=>'Advertising',
              'name_it'=>'Pubblicità',
          ],
          [
              'name'=>'Natural resources',
              'name_it'=>'Risorse naturali',
          ],
          [
              'name'=>'Health',
              'name_it'=>'Sanità',
          ],
          [
              'name'=>'Financial services',
              'name_it'=>'Servizi finanziari',
          ],
          [
              'name'=>'Digital services',
              'name_it'=>'Servizi digitali',
          ],
          [
              'name'=>'Web services e social network',
              'name_it'=>'Servizi web e reti sociali',
          ],
          [
              'name'=>'Marketplace',
              'name_it'=>'Marketplace',
          ],
          [
              'name'=>'Platform economy',
              'name_it'=>'Platform economy',
          ],
          [
              'name'=>'Professional services',
              'name_it'=>'Servizi professionali',
          ],
          [
              'name'=>'Sustainability',
              'name_it'=>'Sostenibilità',
          ],
          [
              'name'=>'Sport',
              'name_it'=>'Sport',
          ],
          [
              'name'=>'Lifestyle',
              'name_it'=>'Stile di vita',
          ],
          [
              'name'=>'Web/mobile development',
              'name_it'=>'Sviluppo web/mobile',
          ],
          [
              'name'=>'Telecommunications',
              'name_it'=>'Telecomunicazioni',
          ],
          [
              'name'=>'Transportation',
              'name_it'=>'Trasporti',
          ],
          [
              'name'=>'Tourism',
              'name_it'=>'Turismo',
          ],
          [
              'name'=>'Video',
              'name_it'=>'Video',
          ],
          [
              'name'=>'VR/AR',
              'name_it'=>'VR/AR',
          ],
          [
              'name'=>'Digital',
              'name_it'=>'Digitale',
          ],
          [
              'name'=>'Cultural',
              'name_it'=>'Culturale',
          ],
          [
              'name'=>'Creative',
              'name_it'=>'Creativo',
          ],
          [
              'name'=>'Other',
              'name_it'=>'Altro',
          ],
      ];

      foreach ($sectors as $sector){
          $new_sector = new Sector();
          $new_sector->name = $sector['name'];
          $new_sector->name_it = $sector['name_it'];
          $new_sector->save();
      }
    }
}
