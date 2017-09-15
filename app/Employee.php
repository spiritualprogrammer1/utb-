<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = ['last_name', 'first_name', 'username', 'image', 'email', 'mobile', 'post_id', 'service_id'];

    public function repair_employee()
    {
        return $this->hasMany(Repair_employee::class);
    }

    public function work()
    {
        return $this->hasMany(Work::class);
    }


    public function post()
    {
        return $this->belongsTo('App\Post');
    }

    public function service()
    {
        return $this->belongsTo('App\Service');
    }

    public function user()
    {
        return $this->hasMany('App\User');
    }
}
