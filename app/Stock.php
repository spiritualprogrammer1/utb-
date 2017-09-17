<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = ['ids', 'reference', 'delivery_id', 'model_id', 'sub_category_id', 'type_id', 'quantity', 'block_id'];

    public function type(){
        return $this->belongsTo(Type::class);
    }

    public function sub_category(){
        return $this->belongsTo(Sub_category::class);
    }

    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function action_stock(){
        return $this->hasMany(Item_stock::class);
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
