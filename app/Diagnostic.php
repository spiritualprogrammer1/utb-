<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diagnostic extends Model
{
    protected $fillable = ['ids', 'reference', 'state', 'type', 'state_id', 'user_id'];

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function diagnostic_employee()
    {
        return $this->hasMany(Diagnostic_employee::class);
    }

    public function demand()
    {
        return $this->hasMany(Demand::class);
    }

    public function repair()
    {
        return $this->hasMany(Repair::class);
    }

    public function visit_technique()
    {
        return $this->hasMany('App\Visit_technique');
    }

    function after_test()
    {
        return $this->hasMany('App\After_test');
    }

    public function revision()
    {
        return $this->hasMany('App\Revision');
    }
}
