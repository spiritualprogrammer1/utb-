<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    use \Venturecraft\Revisionable\RevisionableTrait;
    protected $revisionCreationsEnabled = true;
    protected $revisionCleanup = true;
    protected $historyLimit =50;
    protected $fillable = ['name', 'shelf_id'];

    public function shelf(){
        return $this->belongsTo('App\Shelve');
    }

    public function stock(){
        return $this->hasMany('App\Stock');
    }
}
