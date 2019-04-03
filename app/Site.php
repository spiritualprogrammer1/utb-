<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use \Venturecraft\Revisionable\RevisionableTrait;
    protected $revisionCreationsEnabled = true;
    protected $revisionCleanup = true;
    protected $historyLimit =50;
    protected $fillable=['ville','name','active'];
    public function employes()
    {
        return $this->hasMany('App\Employee');
    }
}
