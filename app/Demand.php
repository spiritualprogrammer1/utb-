<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Demand extends Model
{
    use \Venturecraft\Revisionable\RevisionableTrait;
    protected $revisionCreationsEnabled = true;
    protected $revisionCleanup = true;
    protected $historyLimit =50;
    protected $fillable = ['ids', 'reference', 'diagnostic_id', 'state'];

    public function diagnostic()
    {
        return $this->belongsTo(Diagnostic::class);
    }

    public function demand_piece()
    {
        return $this->hasMany(Demand_piece::class);
    }
}
