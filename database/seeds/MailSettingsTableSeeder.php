<?php

use Illuminate\Database\Seeder;
use App\MailSetting;
use Illuminate\Support\Facades\Schema;

class MailSettingsTableSeeder extends Seeder
{

    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('mail_settings')->truncate();
        Schema::enableForeignKeyConstraints();

        $mail_settings = [
            [
                'name'=>'per messaggi ricevuti',
                'name_it'=>'per messaggi ricevuti',
            ],
        ];

        foreach ($mail_settings as $mail_setting){
            $new_mail_setting = new MailSetting();
            $new_mail_setting->name = $mail_setting['name'];
            $new_mail_setting->name_it = $mail_setting['name_it'];
            $new_mail_setting->save();
        }
    }
}
