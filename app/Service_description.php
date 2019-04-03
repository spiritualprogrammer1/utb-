<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service_description extends Model
{
    use \Venturecraft\Revisionable\RevisionableTrait;
    protected $revisionCreationsEnabled = true;
    protected $revisionCleanup = true;
    protected $historyLimit =50;
    protected $fillable = ['ids', 'title', 'description', 'diagnostic_id'];

    public function diagnostic()
    {
        return $this->belongsTo(Diagnostic::class);
    }
}
