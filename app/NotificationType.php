<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotificationType extends Model
{
    public function notification(){
        return $this->hasOne('App\Notification');
    }
}
