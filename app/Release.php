<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Release extends Model
{
    use \Venturecraft\Revisionable\RevisionableTrait;
    protected $revisionCreationsEnabled = true;
    protected $revisionCleanup = true;
    protected $historyLimit =50;
    protected $fillable = ['after_test_id', 'observation', 'date', 'type'];
    public function after_test()
    {
        return $this->belongsTo('App\After_test');
    }
}
