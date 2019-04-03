<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Enginebus extends Model
{
    protected $fillable=['item_stock_id','state_id','kilometer','bus_id','state','level'];
}
