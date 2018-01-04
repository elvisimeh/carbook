<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Book;
use App\Driver;
use App\Vehicle;
use App\Duty;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class BooksController extends Controller
{




    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

      // COMBAK: return view('admin');  //
    }
protected function admin(){

$books = Book::where('status', '=', 'await')->
orderBy('booking_type','asc')->paginate(6);
  //$books = Book::latest()->paginate(6);
//  $vehexp= Vehicle::all()->get('vehexp');
//  if($vehexp<date('d-m-Y')){
//    $vehexp->update([
  //    'status'=> 'expired',
//      'message'=> 'vehicle paper expire on'. value('vehexp')
//    ]);
//  }
//  else{
//    $vehexp->update([
//      'status'=> 'valid',
//      'message'=>''
//    ]);
//  }
  $drexp= DB::table('drivers')->where('licence_expiry','<',date('Y-m-d'))->get();
$today= strtotime(date('Y-m-d'));
$expire= strtotime(value('licence_expiry'));
if ($expire<$today) {

$drexp= DB::table('drivers')->where('licence_expiry','<',date('Y-m-d'))->update([
  'status' => 'expired',
  'message' => 'vehicle paper expire on'. ' '  //value('licence_expiry')
]);
  }
  else{
$drexp= DB::table('drivers')->where('licence_expiry','<',date('Y-m-d'))->update([
      'status'=> 'valid',
      'message'=>''
]);
}

$vhexp= DB::table('vehicles')->where('vehicle_expire','<',date('Y-m-d',strtotime("-72hours")))->get();
$vtoday= strtotime(date('Y-m-d',strtotime("-72hours")));
$vexpire= strtotime(value('vehicle_expire'));
if($vexpire<$vtoday){
  $vhexp=DB::table('vehicles')->where('vehicle_expire','<',date('Y-m-d',strtotime("-72hours")))->update([
    'alert'=> 'expired'
  ]);
}
else{
  $vhexp=DB::table('vehicles')->where('vehicle_expire','<',date('Y-m-d',strtotime("-72hours")))->update([
    'alert'=> 'valid'
  ]);
}

return view('admin',compact('books'))

->with('i', (request()->input('page', 1) - 1) * 6);

}
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response


     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $validatedata = $request->validate([
        'date' => 'required|after_or_equal:today'
      ]);


      $book= Book::create([
      'staff_name'=>$request->input('name'),
      'destination'=>$request->input('destination'),
      'date_of_trip'=>$request->input('date'),
      'time_of_trip'=>$request->input('time'),
      'passengers'=>$request->input('passengers'),
      //'status'=>$request->status,
      'reason_for_trip'=>$request->input('reason'),
      'no_of_persons_taking_trip'=>$request->input('number'),
      'baggage'=>$request->input('baggage'),
      'booking_type'=>$request->input('booking_type'),

]);
return redirect('/')->with('message', 'Ride booked successfully.');
//
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
$drivers= DB::table('books')->
join('duties','date','=','date_of_trip')->
where('books.id',$id)->
where('shift','morning')->
pluck('driver_name');
$ndrivers= DB::table('books')->
join('duties','date','=','date_of_trip')->
where('books.id',$id)->
where('shift','night')->
pluck('driver_name');



  $books = Book::all()->where('id',$id)->first();
  return view('show',compact('drivers','ndrivers','books'));
 //return view('show',['books' => Book::findOrFail($id)]);  //
    }
// COMBAK: ['books' => Book::findOrFail($id)]);
// COMBAK: compact('books')




    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
//$book=Book::all();
  // COMBAK:   $book=staff_name::all();
$book = Book::all()->where('id',$id);

return view('edit',['book' => Book::findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function change(Request $request, Book $id)
    {
    // COMBAK:   $book = Book::update('update books set status=YES where id =?',$id);
// COMBAK: $updatebook= Book::find($id)->update($request->all());
$rideupdate=Book::all()->get('id',$id)

->update([
'date_of_trip'=>$request->input('newdate'),
'time_of_trip'=>$request->input('newtime'),
'passengers'=>$request->input('newpass'),
'destination'=>$request->input('newdes'),
'message'=>$request->input('message'),
]);
// COMBAK: DB::table('books')->where('id',$request->id)->update($book);
return redirect()->route('show',[$id]);


//$book = Book::all('staff_name')->where('id',$id)->first();
}  //
public function approve(Request $request,Book $id){
  // COMBAK:   dd($request->input('id',$id));
  //$book=Book::where('id',$id)-> get();
  $veh1 = $request->input('vehicle');
  $driver1 = $request-> input('driver');

  //$veh = array();
  $veh= implode(',', $veh1);
  $i=0;
foreach ($veh1 as $ride){
$Q=DB::table('vehicles')->where('vehicle_name',$ride)->value('seats');
$i+=$Q;
}
$q=$id->id;
$taken = DB::table('books')->where('id',$q)
->value('no_of_persons_taking_trip');
$fs= $i - $taken;

if (count($veh1)== count($driver1)) {
if ($fs>=0) {
  $book = Book::all()->get('id',$id)
   -> update([
    'status' => 'YES',
    'assigned_driver' => $request-> input('driver'),
    'by'=>  Auth::user()->name,

    'assigned_vehicle' =>$veh,

  ]);


  //$seats = DB::table('books')->join('vehicles', 'vehicle_name','=','assigned_vehicle')
  //->value('seats');


$freeseats = DB::table('books')->where('books.id',$q)
->update([
  'free_seat'=> $i - $taken ,
]);
  return redirect('/admin')->with('message', 'Ride Approved!');
}
  return redirect()->route('show',[$id])->with('message', 'Passengers more than available space');
}
return redirect()->route('show',[$id])->with('message', 'drivers not equal to selected vehicles');
}


  // COMBAK:   $books = Book::all()->get('id',$id);

  // COMBAK:    $books -> status = 'YES';
  // COMBAK:     $books->save();




// COMBAK:    $books->save();
// COMBAK:  $books = Book::all('status')->where('id',$id)->update($books);
  // return view('approved')->with('book',['book' => Book::findOrFail($id)]);
  // ,['books' => Book::findOrFail($id)]);

      // COMBAK: if ($sql)->return view(/);


public function verified(){

$rides = Book::where('status', '=', 'YES')->simplePaginate(5);
 //return $rides;

  return view('approved_rides',compact('rides'))
 ->with('i', (request()->input('page', 1) - 1) * 6);



}



public function decline(Request $request,Book $id){

  $ridedecline = Book::all()->get('id',$id);


  $ridedecline->update([
    'status' => 'NO',

  ]);

  return redirect('/admin');
//return view('declined',['ridedecline' => Book::findOrFail($id)]);
}



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
