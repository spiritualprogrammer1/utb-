<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Models extends Model
{
    use \Venturecraft\Revisionable\RevisionableTrait;
    protected $revisionCreationsEnabled = true;
    protected $revisionCleanup = true;
    protected $historyLimit =50;
    protected $fillable = ['name', 'brand_id'];

    public function brand(){
        return $this->belongsTo('App\Brand');
    }

    public function vehicle(){
        return $this->belongsTo('App\Vehicle');
    }

    public function bus(){
        return $this->belongsTo(Bus::class);
    }
}
