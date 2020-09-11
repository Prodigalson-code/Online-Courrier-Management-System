<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    //
    protected $fillable = [
        'source','destination','distance','hrs','type','weight','price',
    ];
}
