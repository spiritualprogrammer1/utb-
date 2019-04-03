<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Field_state extends Model
{
    protected $fillable = ['ids', 'state_id', 'field_id'];

    public function state(){
        return $this->belongsTo('App\State');
    }

    public function field(){
        return $this->belongsTo(Field::class);
    }


}
