<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    use \Venturecraft\Revisionable\RevisionableTrait;
    protected $revisionCreationsEnabled = true;
    protected $revisionCleanup = true;
    protected $historyLimit =50;
    protected $fillable = ['ids','remark', 'diagnostic_id', 'site_id', 'user_id'];

    function diagnostic()
    {
        return $this->belongsTo(Diagnostic::class);
    }
}
