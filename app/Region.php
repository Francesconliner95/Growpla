<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    public function user(){
        return $this->hasOne('App\User');
    }

    public function page(){
        return $this->hasOne('App\Page');
    }

    public function country(){
        return $this->belongsTo('App\Country');
    }
}
