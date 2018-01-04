<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Book;
use App\Join;
use App\Driver;
use App\User;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

      Schema::defaultStringLength(191);
      view()->composer('inc.sidebar', function($view){

        $view->with('rides', Book::where('status', '=', 'YES')
        ->where('date_of_trip', '>=', date('y-m-d'))
        ->orderBy('date_of_trip','asc')
        //->where('time_of_trip', '>=', date('h:i:s', strtotime("+30 minutes")))
        ->orderBy('time_of_trip','asc')
        ->get());

      });

      view()->composer('inc.sidebar', function($view){
        $view->with('declined', Book::where('status', '=', 'NO')
        ->where('date_of_trip', '>=', date('y-m-d'))
        ->where('time_of_trip', '>', date('h:i:s', strtotime("+30 minutes")))
        ->get());
      });
      // COMBAK: JOIN A rides
      view()->composer('home', function($view){
        $view->with('rides', Book::where('status', '=', 'YES')
        ->where('date_of_trip', '>=', date('y-m-d'))
        ->orderBy('date_of_trip','asc')
        ->orderBy('time_of_trip','asc')
        ->get());
      });  //

      view()->composer('home', function($view){
        $view->with('await', Book::where('status', '=', 'await')
        ->orderBy('created_at','desc')
        ->get());
      });
      // COMBAK: id for Show
      view()->composer('inc.navbar', function($view){
        $view->with('counter', Book::where('status', '=', 'await')->get());
      });

      view()->composer('inc.navbar', function($view){
        $view->with('jcounter', Join::where('join_status', '=', 'await')->get());
      });
      view()->composer('inc.navbar', function($view){
        $view->with('dexp', Driver::where('status', '=', 'expired')->get());
      });

      view()->composer('inc.navbar', function($view){
        $view->with('vhexp', Driver::where('alert', '=', 'expired')->get());
      });



      //view()->composer('join_ride', function($view){
      //  $view->with('books', Join::all());
    //  });  //

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
