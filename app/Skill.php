<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = [
      'name',
    ];

    public function give_user_skills(){
    return $this->belongsToMany('App\User','give_user_skills','skill_id','user_id');
    }

    public function have_page_cofounders(){
    return $this->belongsToMany('App\Page','have_page_cofounders','skill_id','page_id');
    }

}
