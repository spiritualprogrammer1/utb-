<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type_operation extends Model
{
    use \Venturecraft\Revisionable\RevisionableTrait;
    protected $revisionCreationsEnabled = true;
    protected $revisionCleanup = true;
    protected $historyLimit =50;
}
