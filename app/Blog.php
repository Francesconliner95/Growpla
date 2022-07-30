<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = [
        'title','subtitle','description','main_image',
    ];

    public function images(){
        return $this->hasMany('App\BlogImage');
    }
}
