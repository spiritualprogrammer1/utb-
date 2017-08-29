<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = ['quantity', 'old_quantity', 'stock_id'];

    public function stock(){
        return $this->belongsTo('App\Stock');
    }
}

