<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use \Venturecraft\Revisionable\RevisionableTrait;
    protected $revisionCreationsEnabled = true;
    protected $revisionCleanup = true;
    protected $historyLimit =50;
    protected $fillable = ['name', 'display_name'];
    public function post(){
        return $this->hasMany('App\Post');
    }

    public function employee(){
        return $this->hasMany('App\Employee');
    }
}
