<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    use \Venturecraft\Revisionable\RevisionableTrait;
    protected $revisionCreationsEnabled = true;
    protected $revisionCleanup = true;
    protected $historyLimit =50;
    protected $fillable = ['societe','ids', 'matriculation', 'chassis', 'first_circulation', 'assurance_id', 'visit_id', 'model_id', 'designation', 'site_id', 'user_id'];

    public function model(){
        return $this->belongsTo('App\Models','model_id');
    }

    public function state()
    {
        return $this->hasMany('App\State');
    }

    public function assurance(){
        return $this->hasMany(Assurance::class);
    }

    public function visit(){
        return $this->hasMany(Visit::class);
    }
}
