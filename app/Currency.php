<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
  public function user(){
      return $this->hasOne('App\User');
  }
}
