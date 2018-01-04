<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Auth;
use Auth;
use App\User;

class LoginController extends Controller{



    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

  use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
      // COMBAK:   $this->middleware('guest')->except('/');
    }


     public function postLogin(Request $request)
        {
            $this->validate($request, [
                'email' => 'required|user_name', 'password' => 'required',
            ]);
        if ($this->auth->validate([user_name => $request->user_name, 'password' => $request->password, 'status' => 0])) {
                return redirect($this->loginPath())
                  ->withInput($request->only('user_name', 'remember'))
                   ->withErrors('Your account is Inactive or not verified');
            }
           $credentials  = array('user_name' => $request->email, 'password' => $request->password,);
            if ($this->auth->attempt($credentials, $request->has('remember'))){
                    return redirect()->intended($this->redirectPath());
           }

            return redirect($this->loginPath())
              ->withInput($request->only('user_name', 'remember'))
                ->withErrors([
                    'email' => 'Incorrect Username or password',
                ]);
        }

//old
    // COMBAK:     protected function sendLoginResponse(Request $request)
      // COMBAK:  {
// COMBAK:$request->session()->regenerate();

  // COMBAK:          $this->clearLoginAttempts($request);

  // COMBAK:        foreach ($this->guard()->user()->user as $user) {
    // COMBAK:        if ($user->role =='superadmin') {
          // COMBAK:    return redirect('/superadmin');
    // COMBAK:        }
  // COMBAK:          @endif
    // COMBAK:      }
    // COMBAK:      @endforeach



}
