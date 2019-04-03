<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use \Venturecraft\Revisionable\RevisionableTrait;
    protected $revisionCreationsEnabled = true;
    protected $revisionCleanup = true;
    protected $historyLimit =50;
    protected $fillable = ['name', 'description'];

    public function stock(){
        return $this->hasMany(Stock::class);
    }
}
