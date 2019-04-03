<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use \Venturecraft\Revisionable\RevisionableTrait;
    protected $revisionCreationsEnabled = true;
    protected $revisionCleanup = true;
    protected $historyLimit =50;
    protected $fillable = ['name'];

    public function sub_category(){
        return $this->hasMany('App\Sub_category');
    }

    public function stock(){
        return $this->hasMany(Stock::class, 'ids');
    }
}
