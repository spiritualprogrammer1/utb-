<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diagnostic extends Model
{
    use \Venturecraft\Revisionable\RevisionableTrait;
    protected $revisionCreationsEnabled = true;
    protected $revisionCleanup = true;
    protected $historyLimit =50;
    protected $fillable = ['ids', 'reference', 'active', 'type', 'state_id', 'user_id'];

    public function statee()
    {
        return $this->belongsTo('App\State','state_id');
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

    public function revision()
    {
        return $this->hasMany(Revision::class);
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

}
