<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Duty;


class DutiesController extends Controller
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
        return view('roster');//
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $roster= Duty::create([
        'driver_name'=>$request->input('driver'),
        'date'=>$request->input('date'),
        'shift'=>$request->input('shift'),
      ]);   //
      if($request->input('shift')=='morning'){
        $roster->update([
          'start_time'=> date('7:30:00'),
          'stop_time'=> date('17:30:00'),
        ]);
      }
  else{
    $start= date('16:40:00');
    $roster->update([
    'start_time'=>date('16:40:00'),
    'stop_time'=> date('H:i:s', strtotime($start . "+15 hours")),


    ]);


  }



        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

      $showroster = DB::table('duties')->get(); //
      return view('viewroster',compact('showroster'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
