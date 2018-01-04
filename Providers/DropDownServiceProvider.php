<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Request;
use Illuminate\Support\Facades\DB;


use App\Http\Requests;
use App\Driver;
use App\Vehicle;
use App\Expense_type;
use App\Vehicle_type;
use App\Part;

class DropDownServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(Request $request)
    {

      

      //$id=request()->id;

        //where('date','=','date_of_trip')
        //->pluck('driver_name'));
      //



      view()->composer('roster', function($view){
        $view->with('drivers', Driver::pluck('driver_name'));
      });

      view()->composer('show', function($view){
        $view->with('vehicles', Vehicle::pluck('vehicle_name'));
      });

      view()->composer('expense', function($view){
        $view->with('vehicles', Vehicle::pluck('vehicle_name'));
      });

      view()->composer('expense', function($view){
        $view->with('exptype', Expense_type::pluck('expense_type'));
      });

      view()->composer('add_vehicle', function($view){
        $view->with('vtype', Vehicle_type::pluck('vehicle_type'));
      });


    view()->composer('expense', function($view){
      $view->with('vpart', Part::pluck('parts'));
    });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
