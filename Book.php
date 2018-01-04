<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    //
    protected $fillable=[
      'staff_name', 'destination', 'time_of_trip', 'no_of_persons_taking_trip','passengers','reason_for_trip',
      'date_of_trip', 'assigned_driver', 'status', 'message', 'assigned_vehicle', 'free_seat', 'booking_type'

    ];
    protected $table= 'books';

    //public function Join(){
      //return $this->hasMany('App\Join', 'ride_id', 'id');
    //}
}
