<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    public function user(){
        return $this->belongsTo('App\User');
    }

    public function page(){
        return $this->belongsTo('App\Page');
    }

    public function messages(){
        return $this->hasMany('App\Message');
    }

}
