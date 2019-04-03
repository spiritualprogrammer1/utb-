<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assurance extends Model
{
    use \Venturecraft\Revisionable\RevisionableTrait;
    protected $revisionCreationsEnabled = true;
    protected $revisionCleanup = true;
    protected $historyLimit =50;
    protected $fillable = ['ids', 'date', 'site_id', 'user_id','bus_id'];

    public function bus(){
        return $this->belongsTo(Bus::class);
    }
}
