<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Revision extends Model
{
    use \Venturecraft\Revisionable\RevisionableTrait;
    protected $revisionCreationsEnabled = true;
    protected $revisionCleanup = true;
    protected $historyLimit =50;
    protected $table="revisionns";
    protected $fillable = ['ids', 'diagnostic_id', 'site_id', 'state', 'user_id'];

    public function diagnostic()
    {
        return $this->belongsTo(Diagnostic::class);
    }

}
