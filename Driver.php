<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    //
    protected $fillable=[
      'driver_name','driver_phone_number', 'driver_address', 'dlicence','status',
      'licence_expiry',
    ];
    protected $table= 'drivers';
}
