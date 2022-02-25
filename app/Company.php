<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
      'user_id','page_id','name','iamge','linkedin',
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function page(){
        return $this->belongsTo('App\Page');
    }
}
