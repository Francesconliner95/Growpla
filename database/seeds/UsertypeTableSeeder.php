<?php

use Illuminate\Database\Seeder;
use App\Usertype;

class UsertypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $usertypes = [
          [
              'name'=>'aspiring co-founder',
              'name_it'=>'aspirante co-founder',
              'description'=>'/',
              'description_it'=>'/',
          ],
          [
              'name'=>'business angel',
              'name_it'=>'business angel',
              'description'=>'/',
              'description_it'=>'/',
          ],
          [
              'name'=>'freelancer',
              'name_it'=>'libero professionista',
              'description'=>'/',
              'description_it'=>'/',
          ],
          [
              'name'=>'employee',
              'name_it'=>'dipendente',
              'description'=>'/',
              'description_it'=>'/',
          ],
          [
              'name'=>'student',
              'name_it'=>'studente',
              'description'=>'/',
              'description_it'=>'/',
          ],
          [
              'name'=>'other',
              'name_it'=>'altro',
              'description'=>'/',
              'description_it'=>'/',
          ],
      ];

      foreach ($usertypes as $usertype){
          $new_usertype = new Usertype();
          $new_usertype->name = $usertype['name'];
          $new_usertype->name_it = $usertype['name_it'];
          $new_usertype->description = $usertype['description'];
          $new_usertype->description_it = $usertype['description_it'];
          $new_usertype->save();
      }
    }
}
