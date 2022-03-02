<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usertype extends Model
{
  public function users(){
    return $this->belongsToMany('App\User');
  }

  public function have_page_usertypes(){
  return $this->belongsToMany('App\Page','have_page_usertypes','usertype_id','page_id');
  }
}
