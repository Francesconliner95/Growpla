<?php

use Illuminate\Database\Seeder;
use App\Pagetype;
use Illuminate\Support\Facades\Schema;

class PagetypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('pagetypes')->truncate();
        Schema::enableForeignKeyConstraints();

      $pagetypes = [
          [
              'name'=>'startup',
              'name_it'=>'startup',
              'description'=>'',
              'description_it'=>'',
              'image'=>'pages_images/default-startup.svg',
              'hidden' => null,
          ],
          [
              'name'=>'company',
              'name_it'=>'azienda',
              'description'=>'',
              'description_it'=>'',
              'image'=>'pages_images/default-azienda.svg',
              'hidden' => null,
          ],
          [
              'name'=>'incubator - accelerator',
              'name_it'=>'incubatore - acceleratore',
              'description'=>'A business incubator is an organization that accelerates and systematizes the process of creating new businesses by providing them with a wide range of integrated support services that include physical incubator spaces, business development support services and opportunities for integration and networking.
              The accelerator is a program aimed at accelerating the development of startups and early stage companies, within which entrepreneurial support is offered through the provision of services, the organization of networking activities, the possibility of obtaining consultancy on the model of business, the provision of physical spaces in which to work.
              Generally, both incubation and acceleration services are offered within the same structure.',
              'description_it'=>'Un incubatore d’impresa è un’organizzazione che accelera e rende sistematico il processo di creazione di nuove imprese fornendo loro una vasta gamma di servizi di supporto integrati che includono gli spazi fisici dell’incubatore, i servizi di supporto allo sviluppo del business e le opportunità di integrazione e networking.
              L’acceleratore è un programma volto ad accelerare lo sviluppo di startup e di imprese early stage, all\'interno del quale si offre supporto imprenditoriale attraverso l’erogazione di servizi, l’organizzazione di attività di networking, la possibilità di ottenere consulenze sul modello di business, la fornitura di spazi fisici nei quali lavorare.
              Generalmente all\'interno di una stessa struttura sono offerti sia i servizi di incubazione che di accelerazione.',
              'image'=>'pages_images/default-incubatore.svg',
              'hidden' => null,
          ],
          [
              'name'=>'startup studio',
              'name_it'=>'startup studio',
              'description'=>'',
              'description_it'=>'',
              'image'=>'pages_images/default-azienda.svg',
              'hidden' => 1,
          ],
          [
              'name'=>'venture capital',
              'name_it'=>'venture capital',
              'description'=>'Venture capital are institutional investors who intervene in a phase in which startups have already registered significant growth rates in turnover, bringing capital and experience in strategy and governance.',
              'description_it'=>'I Venture capital sono investitori istituzionali che intervengono in una fase in cui le startup hanno già fatto registrare tassi di crescita del fatturato rilevanti, apportando capitali ed esperienza in strategia e governance.',
              'image'=>'pages_images/default-venture-capital.svg',
              'hidden' => null,
          ],
          [
              'name'=>'crowdfunding platform',
              'name_it'=>'piattaforma di crowdfunding',
              'description'=>'',
              'description_it'=>'',
              'image'=>'pages_images/default-azienda.svg',
              'hidden' => null,
          ],
          [
              'name'=>'organization - association',
              'name_it'=>'ente - associazione',
              'description'=>'Agencies set up for the purpose of attracting investments and promoting business development',
              'description_it'=>'Agenzie costituite allo scopo di attrarre investimenti e favorire lo sviluppo delle imprese',
              'image'=>'pages_images/default-associazione.svg',
              'hidden' => null,
          ],
          [
              'name'=>'private equity',
              'name_it'=>'private equity',
              'description'=>'Private equity funds intervene when the company appears mature and solid from a financial and organizational point of view, limiting itself to providing capital necessary for its expansion.',
              'description_it'=>'I fondi di private equity intervengono quando l’azienda appare matura e solida dal punto di vista finanziario ed organizzativo, limitandosi ad apportare capitali necessari all’espansione della stessa',
              'image'=>'pages_images/default-venture-capital.svg',
              'hidden' => null,
          ],
          [
              'name'=>'university',
              'name_it'=>'università',
              'description'=>'',
              'description_it'=>'',
              'image'=>'pages_images/default-azienda.svg',
              'hidden' => 1,
          ],
      ];

      foreach ($pagetypes as $pagetype){
          $new_pagetype = new Pagetype();
          $new_pagetype->name = $pagetype['name'];
          $new_pagetype->name_it = $pagetype['name_it'];
          $new_pagetype->description = $pagetype['description'];
          $new_pagetype->description_it = $pagetype['description_it'];
          $new_pagetype->image = $pagetype['image'];
          $new_pagetype->hidden = $pagetype['hidden'];
          $new_pagetype->save();
      }
    }
}
