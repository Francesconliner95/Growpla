<?php

use Illuminate\Database\Seeder;
use App\Pagetype;

class PagetypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $pagetypes = [
          [
              'name'=>'startup',
              'name_it'=>'startup',
              'description'=>'/',
              'description_it'=>'/',
          ],
          [
              'name'=>'company',
              'name_it'=>'azienda',
              'description'=>'/',
              'description_it'=>'/',
          ],
          [
              'name'=>'incubator - accelerator',
              'name_it'=>'incubatore - acceleratore',
              'description'=>'/',
              'description_it'=>'/',
          ],
          [
              'name'=>'startup studio',
              'name_it'=>'startup studio',
              'description'=>'/',
              'description_it'=>'/',
          ],
          [
              'name'=>'venture capital',
              'name_it'=>'venture capital',
              'description'=>'/',
              'description_it'=>'/',
          ],
          [
              'name'=>'crowdfunding platform',
              'name_it'=>'piattaforma di crowdfunding',
              'description'=>'/',
              'description_it'=>'/',
          ],
          [
              'name'=>'agency',
              'name_it'=>'agenzia',
              'description'=>'/',
              'description_it'=>'/',
          ],
          [
              'name'=>'private equity',
              'name_it'=>'private equity',
              'description'=>'/',
              'description_it'=>'/',
          ],
          [
              'name'=>'university',
              'name_it'=>'università',
              'description'=>'/',
              'description_it'=>'/',
          ],
      ];

      foreach ($pagetypes as $pagetype){
          $new_pagetype = new Pagetype();
          $new_pagetype->name = $pagetype['name'];
          $new_pagetype->name_it = $pagetype['name_it'];
          $new_pagetype->description = $pagetype['description'];
          $new_pagetype->description_it = $pagetype['description_it'];
          $new_pagetype->save();
      }
    }
}
