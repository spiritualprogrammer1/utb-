<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use \Venturecraft\Revisionable\RevisionableTrait;
    protected $revisionCreationsEnabled = true;
    protected $revisionCleanup = true;
    protected $historyLimit =50;
    protected $fillable = ['matriculation', 'step', 'pmc', 'chassis', 'model_id', 'site_id', 'insurance_expiration', 'visit_expiration'];

    public function state(){
        return $this->hasMany('App\State');
    }

    public function model(){
        return $this->belongsTo('App\Models');
    }
}
