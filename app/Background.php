<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Background extends Model
{
    public function users(){
    return $this->belongsToMany('App\User','user_backgrounds','background_id','user_id');
    }
}
