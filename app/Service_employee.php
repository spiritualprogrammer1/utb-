<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service_employee extends Model
{
    use \Venturecraft\Revisionable\RevisionableTrait;
    protected $revisionCreationsEnabled = true;
    protected $revisionCleanup = true;
    protected $historyLimit =50;
    protected $fillable = ['ids', 'diagnostic_id', 'employee_id'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function diagnostic()
    {
        return $this->belongsTo(Diagnostic::class);
    }
}
