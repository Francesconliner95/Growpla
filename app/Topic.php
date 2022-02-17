<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $fillable = [
        'account_id','image','title','description','anonymous',
    ];

    public function account() {
        return $this->belongsTo('App\Account');
    }
}
