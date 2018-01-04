<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Driver;

class DriversController extends Controller
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

        return view('create_driver');  //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $driver= Driver::create([
      'driver_name'=>$request->input('driver_name'),
      'driver_phone_number'=>$request->input('phone_no'),
      'dlicence'=>$request->input('dlicence'),
      'driver_address'=>$request->input('address'),
      'licence_expiry'=>$request->input('driver_expiry'),
       ]); //

       return redirect('alldrivers');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function listdrivers()
    {
      $drivers = Driver::all();
      return view('alldrivers',compact('drivers'))
      ->with('i', (request()->input('page', 1) - 1) * 6);;  //
    }

    public function alterdriver(Request $request,Driver $id)
    {
      $drivers = Driver::all();
      return view('alterdriver',compact('drivers'))
      ->with('i', (request()->input('page', 1) - 1) * 6);;  //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function driverinfo(Request $request,Driver $id)
    {
      $driver = Driver::all()->get('id',$id);
      return view('editdriver',compact('driver'));  //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    $driver=Driver::all()->
    update([
      'driver_name'=>$request->input('driver_name'),
      'driver_phone_number'=>$request->input('phone_no'),
      'dlicence'=>$request->input('dlicence'),
      'driver_address'=>$request->input('address'),
      'licence_expiry'=>$request->input('driver_expiry'),
       ]); //    //
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
