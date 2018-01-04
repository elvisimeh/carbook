<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
  protected function authenticated($request, $user)
{
    if($user->role) {
        return redirect()->intended('/superadmin');
    }
    return redirect()->intended('/admin');
}
    //
}
