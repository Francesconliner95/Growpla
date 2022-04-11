<?php

use Illuminate\Database\Seeder;
use App\Usertype;
use Illuminate\Support\Facades\Schema;

class UsertypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('usertypes')->truncate();
        Schema::enableForeignKeyConstraints();

      $usertypes = [
          [
              'name'=>'aspiring co-founder',
              'name_it'=>'aspirante co-founder',
              'description'=>'The Co-founder is the person who has resources and / or skills (work or other) that can help the founder in the realization / execution of his business idea.',
              'description_it'=>'Il co-founder è quel soggetto che possiede risorse e/o competenze (lavorative o di altro tipo) che possono aiutare il founder nella realizzazione/esecuzione della sua idea imprenditoriale.',
              'image'=>'users_images/default-utente.svg',
          ],
          [
              'name'=>'business angel',
              'name_it'=>'business angel',
              'description'=>'The business angel is a private entity that grants funds to a startup (as well as know-how and its network of relationships) in order to obtain its capital risk in exchange for becoming a partner.',
              'description_it'=>'Il business angel è un soggetto privato che conferisce fondi ad una startup (oltreché know-how e la sua rete di relazioni) al fine di ottenere in cambio capitale di rischio della stessa e diventarne socio.',
              'image'=>'users_images/default-business-angel.svg',
          ],
          [
              'name'=>'freelancer',
              'name_it'=>'libero professionista',
              'description'=>'',
              'description_it'=>'',
              'image'=>null,
          ],
          [
              'name'=>'employee',
              'name_it'=>'dipendente',
              'description'=>'',
              'description_it'=>'',
              'image'=>null,
          ],
          [
              'name'=>'student',
              'name_it'=>'studente',
              'description'=>'',
              'description_it'=>'',
              'image'=>null,
          ],
          [
              'name'=>'other',
              'name_it'=>'altro',
              'description'=>'',
              'description_it'=>'',
              'image'=>null,
          ],
      ];

      foreach ($usertypes as $usertype){
          $new_usertype = new Usertype();
          $new_usertype->name = $usertype['name'];
          $new_usertype->name_it = $usertype['name_it'];
          $new_usertype->description = $usertype['description'];
          $new_usertype->description_it = $usertype['description_it'];
          $new_usertype->image = $usertype['image'];
          $new_usertype->save();
      }
    }
}
