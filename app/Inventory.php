<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use \Venturecraft\Revisionable\RevisionableTrait;
    protected $revisionCreationsEnabled = true;
    protected $revisionCleanup = true;
    protected $historyLimit =50;
    protected $fillable = ['quantity', 'old_quantity', 'stock_id'];

    public function stock(){
        return $this->belongsTo('App\Stock');
    }
}

