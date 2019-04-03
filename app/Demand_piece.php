<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Demand_piece extends Model
{
    use \Venturecraft\Revisionable\RevisionableTrait;
    protected $revisionCreationsEnabled = true;
    protected $revisionCleanup = true;
    protected $historyLimit =50;
    protected $fillable = ['ids', 'piece', 'quantity', 'demand_id','delivered','state'];

    public function demand()
    {
        return $this->belongsTo(demand::class);
    }
}
