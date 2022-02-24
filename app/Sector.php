<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
  public function users(){
    return $this->belongsToMany('App\User');
  }

  public function pages(){
    return $this->belongsToMany('App\Page');
  }
}
