<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item_stock extends Model
{
    use \Venturecraft\Revisionable\RevisionableTrait;
    protected $revisionCreationsEnabled = true;
    protected $revisionCleanup = true;
    protected $historyLimit =50;
    protected $fillable = ['ids', 'stock_id', 'movement_stock_id', 'quantity', 'quantity_old', 'type','state_id','prix_unitaire'];

    public function supplier(){
        return $this->belongsTo('App\Supplier');
    }

    public function stock(){
        return $this->belongsTo(Stock::class);
    }

    public function movement_stock(){
        return $this->belongsTo(Movement_stock::class);
    }
}
