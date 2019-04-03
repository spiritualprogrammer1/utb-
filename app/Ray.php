<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ray extends Model
{
    use \Venturecraft\Revisionable\RevisionableTrait;
    protected $revisionCreationsEnabled = true;
    protected $revisionCleanup = true;
    protected $historyLimit =50;
    protected $fillable = ['name'];

    public function shelf(){
        return $this->hasMany('App\Shelve');
    }
}
