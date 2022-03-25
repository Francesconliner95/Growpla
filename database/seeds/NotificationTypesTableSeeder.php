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
                // 'url' => 'admin/pages/',
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
            [ //collaborazione ai followers
                'message'=> '/',
                'message_it'=> 'ha avviato una collaborazione con',
            ],
            [ //collaborazione ad utente
                'message'=> '/',
                'message_it'=> 'ti ha aggiunto alle sue collaborazioni',
            ],
            [ //collaborazione ad una mia pagina
                'message'=> '/',
                'message_it'=> 'ha aggiunto alle sue collaborazioni la tua pagina',
            ],
            [//conferma collaborazione ad utente
                'message'=> '/',
                'message_it'=> 'ha confermato la tua collaborazione',
            ],
            [//conferma collaborazione ad una mia pagina
                'message'=> '/',
                'message_it'=> 'ha confermato la collaborazione con la tua pagina',
            ],
            [
                'message'=> '/',
                'message_it'=> 'Un investitore ha guardato il tuo profilo',
            ],
        ];

        foreach ($notification_types as $notification_type){
            $new_notification_type = new NotificationType();
            $new_notification_type->message = $notification_type['message'];
            $new_notification_type->message_it = $notification_type['message_it'];
            $new_notification_type->save();
        }
    }
}
