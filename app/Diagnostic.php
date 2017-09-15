<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diagnostic extends Model
{
    protected $fillable = ['ids', 'reference', 'active', 'type', 'state_id', 'user_id'];

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function diagnostic_employee()
    {
        return $this->hasMany(Diagnostic_employee::class);
    }

    public function service_description()
    {
        return $this->hasMany(Service_description::class);
    }

    public function service_employee()
    {
        return $this->hasMany(Service_employee::class);
    }

    public function demand()
    {
        return $this->hasMany(Demand::class);
    }

    public function repair()
    {
        return $this->hasMany(Repair::class);
    }

    function work()
    {
        return $this->hasMany(Work::class);
    }

    function approval()
    {
        return $this->hasMany(Approval::class);
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
