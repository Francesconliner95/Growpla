<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Moneyrange extends Model
{
  public function user(){
      return $this->hasOne('App\User');
  }
}
