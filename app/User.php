<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use Notifiable;
    use EntrustUserTrait;

    protected $fillable = [
        'last_name', 'first_name', 'username', 'image', 'email', 'password','status','connected','employee_id'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function Roles(){
        return $this->belongsToMany('App\Role');
    }

    public function employee(){
        return $this->belongsTo('App\Employee');
    }
}
