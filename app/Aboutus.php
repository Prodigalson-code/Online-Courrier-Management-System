<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aboutus extends Model
{
    //
    protected $fillable = [
        'title', 'mission', 'vision','value','description'
    ];
}
