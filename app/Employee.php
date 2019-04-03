<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use \Venturecraft\Revisionable\RevisionableTrait;
    protected $revisionCreationsEnabled = true;
    protected $revisionCleanup = true;
    protected $historyLimit =50;
    protected $fillable = ['action_site','last_name', 'first_name','username', 'image', 'email', 'mobile', 'post_id', 'service_id','site_id'];

    public function repair_employee()
    {
        return $this->hasMany(service_employee::class);
    }

    public function work()
    {
        return $this->hasMany(Work::class);
    }
public function site()
{
    return $this->belongsTo('App\Site');
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
