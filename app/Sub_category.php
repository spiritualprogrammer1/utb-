<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sub_category extends Model
{
    use \Venturecraft\Revisionable\RevisionableTrait;
    protected $revisionCreationsEnabled = true;
    protected $revisionCleanup = true;
    protected $historyLimit =50;
    protected $fillable = ['name', 'category_id'];

    public function category(){
        return $this->belongsTo('App\Category');
    }

    public function stock(){
        return $this->hasMany(Stock::class, 'ids');
    }
}
