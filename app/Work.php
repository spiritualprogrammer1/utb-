<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    use \Venturecraft\Revisionable\RevisionableTrait;
    protected $revisionCreationsEnabled = true;
    protected $revisionCleanup = true;
    protected $historyLimit =50;
    protected $fillable = ['ids', 'state_id','arrive','type','arrive','state','distance', 'place', 'description', 'employee_id', 'diagnostic_id', 'user_id', 'site_id'];

    public function diagnostic()
    {
        return $this->belongsTo(Diagnostic::class);
    }

    public function statee()
    {
        return $this->belongsTo(State::class,'state_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
