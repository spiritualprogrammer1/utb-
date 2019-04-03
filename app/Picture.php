<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
   protected $fillable=['name','state_id'];

    public function state()
    {
        return $this->belongsTo('App\state');
    }
}
