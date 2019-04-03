<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use \Venturecraft\Revisionable\RevisionableTrait;
    protected $revisionCreationsEnabled = true;
    protected $revisionCleanup = true;
    protected $historyLimit =50;
    protected $fillable = ['ids','number','amount','supplier_id', 'image', 'delivered_at', 'order', 'user_id'];

    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }

    public function movement_stock(){
        return $this->belongsTo(Movement_stock::class);
    }
}
