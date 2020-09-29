<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contactus extends Model
{
    //
    protected $fillable = [
        'email', 'phone', 'message','subject'
    ];
}
