<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movement_stock extends Model
{
    use \Venturecraft\Revisionable\RevisionableTrait;
    protected $revisionCreationsEnabled = true;
    protected $revisionCleanup = true;
    protected $historyLimit =50;
    protected $fillable = ['ids', 'reference', 'demand_id', 'delivery_id', 'type'];

    public function item_stock(){
        return $this->hasMany(Item_stock::class);
    }

    public function delivery(){
        return $this->belongsTo(Delivery::class);
    }

    public function demand()
    {
        return $this->belongsTo('App\Demand','demand_id');
    }
}
