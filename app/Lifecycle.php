<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lifecycle extends Model
{
  public function page(){
      return $this->hasOne('App\Page');
  }
}
