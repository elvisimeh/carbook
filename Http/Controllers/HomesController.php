<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Staff;

class HomesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
      //  $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $staff= Staff::pluck('staff_name');
      return $staff;
        return view('home', compact('staff'));
    }
    public function autocomplete()
    {
      $term = str::lower(Input::get('staff'));
      $data = DB::table('staff')->distinct()->select('staff_name')
      ->where('staff_name', 'LIKE', $term. '%')->groupBy('staff_name')
      ->take(10)->get();
      foreach ($data as $v){
        $return_array[] = array('value' => $v->staff_name);
      }
      return Response::json($return_array);
    }

    public function login()
    {
        //return view('login');
        if (Auth::check()&&Auth::User()->isRole()=="admin")
      return  redirect ('/');
    }

    public function admin()
    {
        return view('admin');
    }

    public function approved_rides()
    {
        return view('approved_rides');
    }
}
