<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    protected $fillable = ['ids', 'type', 'state','distance', 'place', 'description', 'employee_id', 'diagnostic_id', 'user_id', 'site_id'];

    public function diagnostic()
    {
        return $this->belongsTo(Diagnostic::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
