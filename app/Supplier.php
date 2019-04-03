<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use \Venturecraft\Revisionable\RevisionableTrait;
    protected $revisionCreationsEnabled = true;
    protected $revisionCleanup = true;
    protected $historyLimit =50;
    protected $fillable = ['name', 'rccm', 'phone', 'mobile', 'email', 'type', 'address', 'country_id'];

    public function country(){
        return $this->belongsTo('App\Country');
    }

    public function stock(){
        return $this->hasMany('App\Stock');
    }

    public function delivery(){
        return $this->hasMany('App\Delivery');
    }
}
