<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Join extends Model
{
  protected $fillable=[
    'new_passengers', 'ride_id', 'list_passengers','idj',
  ];  //

//public function Book(){
//  return $this->belongsTo('App\Book', 'ride_id', 'id');
//}

}
