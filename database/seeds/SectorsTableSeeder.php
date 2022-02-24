<?php

use Illuminate\Database\Seeder;
use App\Sector;

class SectorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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
              'name'=>'Electronics',
              'name_it'=>'Elettronica',
          ],
          [
              'name'=>'Power',
              'name_it'=>'Energia',
          ],
          [
              'name'=>'Gaming',
              'name_it'=>'Gaming',
          ],
          [
              'name'=>'Hardware',
              'name_it'=>'Hardware',
          ],
          [
              'name'=>'Real estate',
              'name_it'=>'Immobiliare',
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
              'name'=>'Internet services',
              'name_it'=>'Servizi internet',
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
