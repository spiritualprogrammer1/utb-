<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Engine extends Model
{
    use \Venturecraft\Revisionable\RevisionableTrait;
    protected $revisionCreationsEnabled = true;
    protected $revisionCleanup = true;
    protected $historyLimit =50;
    protected $fillable = ['ids', 'reference','tva','total','annex','delivery_id', 'model_id', 'sub_category_id', 'type_id','block_id','site_id','libelle','vitesse','kilometrage','puissance','quantity'];

    public function type(){
        return $this->belongsTo(Type::class);
    }

    public function sub_category(){
        return $this->belongsTo(Sub_category::class);
    }

    public function delivery()
    {
        return $this->belongsTo('App\Delivery');
    }
    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function block(){
        return $this->belongsTo(Block::class);
    }

    public function model(){
        return $this->belongsTo(Models::class);
    }

    public function inventory(){
        return $this->hasMany(Inventory::class);
    }
}
