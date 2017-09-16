<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visit_technique extends Model
{
    protected $fillable = ['ids', 'diagnostic_id', 'site_id', 'state', 'user_id'];

    public function diagnostic()
    {
        return $this->belongsTo(Diagnostic::class);
    }
}
