<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use \Venturecraft\Revisionable\RevisionableTrait;
    protected $revisionCreationsEnabled = true;
    protected $revisionCleanup = true;
    protected $historyLimit =50;
    protected $fillable = ['ids','state_kilometer','driver_name','panne_gar','description_accident','lieu','date_accident','accident','bus_id', 'reference', 'remark', 'incident', 'kilometer', 'site_id', 'user_id', 'state','kilometer_engine'];

    public function diagnostic()
    {
//        return $this->hasOne('App\Diagnostic','state_id');

        return $this->hasMany('App\Diagnostic','state_id');
    }
    public function field_state(){
        return $this->hasMany('App\Field_state');
    }
    public function bus()
    {
        return $this->belongsTo('App\Bus','bus_id');
    }


    public function work()
    {
        return $this->hasOne(Work::class,'state_id');
    }
    /*public function site()
    {
        return $this->belongsTo(Site::class);
    }*/
}
