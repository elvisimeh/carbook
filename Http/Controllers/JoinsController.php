<?php

namespace App\Http\Controllers;
use App\Join;
use App\Book;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class JoinsController extends Controller
{
public function insert(Request $request, Join $id){

  $now= $request->input('join_a_ride');
  $joint = DB::table('books')->
  where('id', $now)->pluck('free_seat')->first();


  if ($request->input('number')>$joint){
    return redirect('/')->withMessage('Request error! Passengers exceeds available seats');
  }
else{
$join=Join:: create([
  //'list_passengers'=>$request->input(),
  'new_passengers'=>$request->input('number'),
  'ride_id'=>$request->input('join_a_ride'),
  'list_passengers'=>$request->input('list_passengers'),
]);


$joins= $join->id;
$join->where('id',$joins)->update([
  'idj'=> $joins,
]);

return redirect('/')->withMessage('Request sent!');
}
}    //

public function list(Request $request, Join $id){
  $join = DB::table('joins')->join('books', 'joins.ride_id', '=', 'books.id')
  ->where('join_status', '=', 'await')->get();






  return view('join_ride', compact('join'))
  ->with('i', (request()->input('page', 1) - 1) * 6);
}

public function approvej(Request $request, $idj)
{
//$join = DB::table('joins')->join('books', 'joins.ride_id', '=', 'books.id')->
//where('ride_id', $id)->pluck('no_of_persons_taking_trip')->first();//-> get();

//$join2 = DB::table('joins')->join('books', 'joins.ride_id', '=', 'books.id')->
//where('ride_id', $id)->pluck('new_passengers')->first();

  //->get();//->

//$p = $join[1] ;

$join3 = DB::table('joins')->//join('books', 'joins.ride_id', '=', 'books.id')->
where('idj', $idj)->value('new_passengers');//select(DB::raw('CONCAT(list_passengers, " ", passengers) AS passengers')->

$join4=DB::table('joins')->where('idj',$idj)->pluck('ride_id')->first();

$join5=DB::table('books')->where('id',$join4)->value('no_of_persons_taking_trip');

$join6=DB::table('books')->where('id',$join4)->update([
  'no_of_persons_taking_trip'=> $join3 + $join5
]);

DB::table('joins')->where('idj',$idj)->update([
  'join_status'=> 'YES'
]);

$con1=DB::table('joins')->where('idj',$idj)->value('list_passengers');

$con2=DB::table('books')->where('id',$join4)->value('passengers');

$con=DB::table('books')->where('id',$join4)->update([
  'passengers'=> $con2. ".". "Joined:". $con1
]);
$add = DB::table('joins')->where('idj',$idj)->value('new_passengers');

$freej = DB::table('books')->where('id',$join4)->value('free_seat');

DB::table('books')->where('id',$join4)->
update([
  'free_seat' => $freej - $add,
]);

//$free=DB::table('vehicles')->

//  'no_of_persons_taking_trip'=>

return redirect()->back();

}
}
