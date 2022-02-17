<?php

use Illuminate\Database\Seeder;
use App\CofounderRole;

class CofounderRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['web developer', 'CEO', 'CTO', 'CMO', 'marketing e comunicazione', 'project manager', 'gestione finanziaria e controllo di gestione', 'legale'];

        foreach ($roles as $role){
            $new_role = new CofounderRole();
            $new_role->name = $role;
            $new_role->save();
        }
    }
}
