<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Redirect;
use Toastr;

class OTPController extends Controller
{
    public function sendOTP(Request $request)
    {
        // Generate OTP
        $otp = rand(100000, 999999);

        // Store OTP in database

        User::where('id', $request->user()->id)->update(['user_otp' => $otp, 'otp_expired_at' => now()->addMinutes(5)]);

        $request->session()->forget('otp_verified');

 
         

        //send otp to user via email
        try {
            
            Mail::to($request->user()->email)->send(new OtpMail($otp));
        } catch (\Exception $e) {
            
            Toastr::error('OTP Sending Failed. Please try again.');
        }

        Toastr::success('Check your mail to get OTP');
        return redirect()->route('verifyOTPForm');
        //send otp to user via email




        // Send OTP to user's mobile number via SMS (You need to replace the SMS service URL and parameters)
        $response = Http::post('https://api.smsapi.com/send-otp', [
            'to' => $request->user()->mobile_number,
            'message' => 'Your OTP is: ' . $otp,
        ]);

         

        if ($response->successful()) {
            return redirect()->route('verifyOTPForm');
        } else {
            Toastr::error('OTP Sending Failed. Please try again.');
        }
        // Send OTP to user's mobile number
    }

    public function showVerifyOTPForm()
    {
        return view('otp.verify_otp');
    }

    public function verifyOTP(Request $request)
    {
        $otp = $request->input('otp');

        // Retrieve saved OTP from session or database based on user's identifier
        $savedOTP = Auth::user()->user_otp;
        $OPTExpTime = Auth::user()->otp_expired_at;

        if ($OPTExpTime < now()) {
            Toastr::error('OTP expired. Please try again.');
            return back();
        }

        // Verify if entered OTP matches saved OTP
        if ($otp == $savedOTP) {
            $request->session()->put('otp_verified', true);

           
            return view('commissioner.users.create');
        } else {
            // OTP verification failed, redirect back with error message
            Toastr::error('OTP invalid. Please try again.');
            return back();
        }
    }
}
