<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = [
      'name',
    ];

    public function users(){
        return $this->belongsToMany('App\User');
    }

    public function have_page_cofounders(){
    return $this->belongsToMany('App\Page','have_page_cofounders','skill_id','page_id');
    }

}
