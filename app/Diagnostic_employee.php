<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diagnostic_employee extends Model
{
    use \Venturecraft\Revisionable\RevisionableTrait;
    protected $revisionCreationsEnabled = true;
    protected $revisionCleanup = true;
    protected $historyLimit =50;
    protected $fillable = ['diagnostic_id', 'employee_id', 'title', 'description'];

    public function diagnostic(){
        return $this->belongsTo(Diagnostic::class);
    }

    public function diagnostic_piece(){
        return $this->hasMany(Demand_piece::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
