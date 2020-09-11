<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parselinfo extends Model
{
    //

    protected $fillable = [
        'name', 'email', 'phone','address','recever_phone','recever_name','recever_email',
        'recever_address','package_name','package_quantity','type','weight','price','paymentmethod','senderPayment_name','senderPayment_phone','source','destination','distance','packagestatus','paymentstatus','user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
