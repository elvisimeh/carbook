<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Duty extends Model
{
  protected $fillable=[
    'driver_name','date','shift','start_time','stop_time', 'status',
  ];

  protected $table= 'duties';
    //
}
