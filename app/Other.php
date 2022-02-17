<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Other extends Model
{
    protected $fillable = [
        'account_id','image','title','sub_title','description','link'
    ];

    public function account() {
        return $this->belongsTo('App\Account');
    }
}
