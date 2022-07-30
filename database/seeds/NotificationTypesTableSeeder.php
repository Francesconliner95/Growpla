<?php

use Illuminate\Database\Seeder;
use App\NotificationType;
use Illuminate\Support\Facades\Schema;

class NotificationTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('notification_types')->truncate();
        Schema::enableForeignKeyConstraints();
        $notification_types = [
            [
                'message'=> '/',
                'message_it'=> 'ha cambiato fase del ciclo di vita',
                'url' => '/admin/pages/',
            ],
            [
                'message'=> '/',
                'message_it'=> 'ha iniziato a seguirti',
                'url' => '/admin/users/',
            ],
            [
                'message'=> '/',
                'message_it'=> 'ha aggiornato la sezione dei servizi offerti',
                'url' => '/admin/users/',
            ],
            [
                'message'=> '/',
                'message_it'=> 'ha aggiornato la sezione dei servizi richiesti',
                'url' => '/admin/users/',
            ],
            [
                'message'=> '/',
                'message_it'=> 'ha aggiornato la sezione dei servizi offerti',
                'url' => '/admin/pages/',
            ],
            [
                'message'=> '/',
                'message_it'=> 'ha aggiornato la sezione dei servizi richiesti',
                'url' => '/admin/pages/',
            ],
            [
                'message'=> '/',
                'message_it'=> 'ha bisogno di',
                'url' => '/admin/pages/',
            ],
            [ //collaborazione ai followers
                'message'=> '/',
                'message_it'=> 'ha avviato una collaborazione con',
                'url' => '/admin/users/',
            ],
            [ //collaborazione ai followers
                'message'=> '/',
                'message_it'=> 'ha avviato una collaborazione con',
                'url' => '/admin/pages/',
            ],
            [ //collaborazione ad utente
                'message'=> '/',
                'message_it'=> 'ti ha aggiunto alle sue collaborazioni',
                'url' => '/admin/collaborations/my/',
            ],
            [ //collaborazione ad una mia pagina
                'message'=> '/',
                'message_it'=> 'ha aggiunto alle sue collaborazioni',
                'url' => '/admin/collaborations/my/',
            ],
            [//conferma collaborazione ad utente
                'message'=> '/',
                'message_it'=> 'ha confermato la tua collaborazione',
                'url' => '/admin/users/',
            ],
            [//conferma collaborazione ad una mia pagina
                'message'=> '/',
                'message_it'=> 'ha confermato la collaborazione con la tua pagina',
                'url' => '/admin/pages/',
            ],
            [
                'message'=> '/',
                'message_it'=> 'Un investitore ha guardato il tuo profilo',
                'url' => '/admin/pages/',
            ],
            [
                'message'=> '/',
                'message_it'=> 'ha iniziato a seguire',
                'url' => '/admin/users/',
            ],
            [
                'message'=> '/',
                'message_it'=> 'ti ha nominato admin di',
                'url' => '/admin/pages/',
            ],
            [
                'message'=> '/',
                'message_it'=> 'ti ha rimosso come admin di',
                'url' => '/admin/pages/',
            ],
            [
                'message'=> '/',
                'message_it'=> 'ti ha aggiunto come membro del team di',
                'url' => '/admin/pages/',
            ],
            [
                'message'=> '/',
                'message_it'=> 'ha creato una nuova pagina',
                'url' => '/admin/pages/',
            ],
        ];

        foreach ($notification_types as $notification_type){
            $new_notification_type = new NotificationType();
            $new_notification_type->message = $notification_type['message'];
            $new_notification_type->message_it = $notification_type['message_it'];
            $new_notification_type->url = $notification_type['url'];
            $new_notification_type->save();
        }
    }
}
