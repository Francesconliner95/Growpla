<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pagetype extends Model
{
  public function users(){
    return $this->belongsToMany('App\User');
  }

  public function page(){
      return $this->hasOne('App\Page');
  }
}
