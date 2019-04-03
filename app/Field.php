<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{

    public function field_state(){
        return $this->belongsToMany('App\Field_state');
    }



}
