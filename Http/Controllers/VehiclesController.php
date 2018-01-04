<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vehicle;
use App\Book;
use Illuminate\Support\Facades\DB;

class VehiclesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('add_vehicle');  //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $vehicle= Vehicle::create([
      //'vehicle_name'=>$request->input('vname'),
      'vehicle_type'=>$request->input('vtype'),
      'vehicle_id'=>$request->input('vid'),
      'vehicle_no'=>$request->input('vehpl'),
      'vehicle_model'=>$request->input('vehmod'),
      'seats'=>$request->input('seats'),
      'vehicle_expire'=>$request->input('vehexp'),
      'paper_expire'=>$request->input('expire_name')
       ]);    //
       $vm = $vehicle->id;
       $v_m= Vehicle::where('id',$vm)->value('vehicle_model');
       $v_n= Vehicle::where('id',$vm)->value('vehicle_no');
$vehicle->where('id',$vm)->update([
  'vehicle_name'=>$v_m ."-". $v_n,
]);
 return redirect('allvehicles');
 }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function listvehicles(Request $request,Vehicle $id)
    {
      $vehicles=Vehicle::all()->where('status','YES');


      return view('allvehicles',compact('vehicles'))
      ->with('i', (request()->input('page', 1) - 1) * 6); //
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editvehicle($id)
    {
      $vehicle = Vehicle::all()->where('id',$id);

      return view('updatevehicle',['vehicle' => Vehicle::findOrFail($id)]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changev(Request $request,Vehicle $id)
    {
      $vehicles= Vehicle::all()->get('id',$id);

    $vehicles->update([
        'vehicle_no'=>$request->input('newvehpl'),
        'vehicle_expire'=>$request->input('newdate')

      ]);
      $vm = $vehicles->id;
      $v_m= Vehicle::where('id',$vm)->value('vehicle_model');
      $v_n= Vehicle::where('id',$vm)->value('vehicle_no');
$vehicles->where('id',$vm)->update([
 'vehicle_name'=>$v_m ."-". $v_n,
]);  //
        return redirect()->back();
    }
public function remove(Request $request,Vehicle $id)
{
   Vehicle::all()->get('id',$id)
  ->update([
    'status'=>'NO'
  ]);

  return redirect()->back();
}

public function altervehicles(Request $request,Vehicle $id)
{
  $vehicles=Vehicle::all();


  return view('altervehicles',compact('vehicles'))
  ->with('i', (request()->input('page', 1) - 1) * 6); //
}

public function addvehicle(Request $request,Vehicle $id)
{
  $veh=Vehicle::all()->get('id',$id)
  ->update([
    'status'=>'YES'
  ]);

  return redirect()->back();
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
