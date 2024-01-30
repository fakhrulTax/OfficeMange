<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class VerifyOTP
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {   

       

     

        // Check if OTP has been verified (You may need to adjust this logic based on how you store OTP verification status)
        if ($request->session()->has('otp_verified')) {
            

            $request->session()->forget('otp_verified');
            return $next($request);
        }

        // If OTP verification hasn't been completed, redirect to the OTP verification form
        return redirect()->route('sendOTP');
    }
}
