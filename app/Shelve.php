<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shelve extends Model
{
    use \Venturecraft\Revisionable\RevisionableTrait;
    protected $revisionCreationsEnabled = true;
    protected $revisionCleanup = true;
    protected $historyLimit =50;
    protected $fillable = ['name', 'ray_id'];

    public function ray(){
        return $this->belongsTo('App\Ray');
    }

    public function block(){
        return $this->hasMany('App\Block');
    }
}
