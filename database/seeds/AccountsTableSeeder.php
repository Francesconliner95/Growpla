<?php

use Illuminate\Database\Seeder;
use App\Account;
use Illuminate\Support\Str;

class AccountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 100 ; $i++) {
            $new_accout = new Account();
            $new_accout->user_id = 1;
            $new_accout->name = 'account generato'.$i;
            $new_accout->account_type_id = rand(1,8);
            $new_accout->slug = Str::slug($new_accout->name);
            $new_accout->save();
        }
    }
}
