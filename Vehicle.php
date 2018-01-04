<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    //
    protected $fillable=[
      'vehicle_name','vehicle_type','vehicle_id','seats','vehicle_no','vehicle_model','alert',
      'message','status','vehicle_expire','paper_expire',
    ];
}
