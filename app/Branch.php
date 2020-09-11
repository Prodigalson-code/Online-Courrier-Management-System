<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Branch extends Model
{

    use Notifiable,HasApiTokens;


    protected $fillable = [
        'branchname', 'branchemail', 'branchphone','branchaddress','branchcity','branchmanager'
    ];

    protected $hidden = [
        'remember_token',
    ];
}
