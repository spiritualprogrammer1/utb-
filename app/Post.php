<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use \Venturecraft\Revisionable\RevisionableTrait;
    protected $revisionCreationsEnabled = true;
    protected $revisionCleanup = true;
    protected $historyLimit =50;
    protected $fillable=['name','service_id'];
    public function service(){
        return $this->belongsTo('App\Service');
    }

    public function employee(){
        return $this->belongsTo('App\Employee');
    }
}
