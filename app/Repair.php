<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Repair extends Model
{
    use \Venturecraft\Revisionable\RevisionableTrait;
    protected $revisionCreationsEnabled = true;
    protected $revisionCleanup = true;
    protected $historyLimit =50;
    protected $fillable = ['ids', 'diagnostic_id', 'site_id', 'state', 'user_id'];

    public function diagnostic()
    {
        return $this->belongsTo(Diagnostic::class);
    }

}
