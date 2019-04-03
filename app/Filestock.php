<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Filestock extends Model
{


    protected $fillable = ['reference','libelle','quantite','prix'];

}
