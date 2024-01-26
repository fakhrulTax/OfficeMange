<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
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
    protected $redirectTo = '/circle-dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       
    }

    //Redirct User
    protected function redirectTo()
    {
        $userRole = auth()->user()->user_role;

        if ($userRole === 'circle') {
            return '/circle-dashboard';
        } elseif ($userRole === 'range') {
            return '/range-dashboard';
        } elseif ($userRole === 'technical') {
            return '/technical-dashboard';
        } elseif ($userRole === 'commissioner') {
            return '/commissioner-dashboard';
        } else {
            return '/';
        }
    }
}
