<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    public function users(){
      return $this->belongsToMany('App\User');
    }
}
