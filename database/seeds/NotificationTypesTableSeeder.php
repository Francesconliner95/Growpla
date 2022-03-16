<?php

use Illuminate\Database\Seeder;
use App\NotificationType;

class NotificationTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('notification_types')->delete();
        $notification_types = [
            [
                'message'=> '/',
                'message_it'=> 'ha cambiato fase del ciclo di vita',
            ],
            [
                'message'=> '/',
                'message_it'=> 'ha iniziato a seguirti',
            ],
            [
                'message'=> '/',
                'message_it'=> 'ha aggiornato la sezione dei servizi offerti',
            ],
            [
                'message'=> '/',
                'message_it'=> 'ha aggiornato la sezione dei servizi richiesti',
            ],
            [
                'message'=> '/',
                'message_it'=> 'ha bisogno di',
            ],
            // [
            //     'message'=> '/',
            //     'message_it'=> 'Un investitore ha guardato il tuo profilo',
            // ],
        ];

        foreach ($notification_types as $notification_type){
            $new_notification_type = new NotificationType();
            $new_notification_type->message = $notification_type['message'];
            $new_notification_type->message_it = $notification_type['message_it'];
            $new_notification_type->save();
        }
    }
}
