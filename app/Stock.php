<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use \Venturecraft\Revisionable\RevisionableTrait;
    protected $revisionCreationsEnabled = true;
    protected $revisionCleanup = true;
    protected $historyLimit =50;
    protected $fillable = ['sens_tire','ids','width','weight','hauteur','diametre','charge','dot','libelle','image_engine','stock_type','price','price_old','type_moteur','vitesse','horse','displacement','power','mileage','reference','tva','total','annex','delivery_id', 'model_id', 'sub_category_id', 'type_id', 'quantity', 'block_id','site_id','typtire_id'];

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
