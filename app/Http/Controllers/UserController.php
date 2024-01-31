<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Helpers\MyHelper;
use Toastr;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('commissioner.users.index', compact('users'));
    }


 

    public function userCreate(){

        $otpResponse = MyHelper::sendOtp(Auth::user());

        if($otpResponse){

            Toastr::success('OTP Sending successfully');
            return view('commissioner.users.create');
        }else{

            Toastr::error('OTP Sendign failed. Please try again.', 'Error');
            return redirect()->route('commissioner.users');
        }

  
        
    }

    public function userStore(Request $request){

        $savedOTP = Auth::user()->user_otp;

        if ($request->user_otp != $savedOTP) {
            Toastr::error('Invalid OTP. Please try again.', 'Error');
            return redirect()->route('commissioner.users');
        }
        
        $request->validate([

            'user_role' => 'required',
            'name' => 'required',
            'designation' => 'required',
            'mobile_number' => 'required | digits:11 | unique:users',
            'email' => 'required | email | unique:users',
            'password' => 'required',
            'range' => $request->user_role == 'range' ? 'required' : '',
            'circle' => $request->user_role == 'circle' ? 'required' : '',
            'user_otp' => 'required | digits:6',
        ], [
            'range.required' => 'The range field is required when user Type is "Range".',
            'circle.required' => 'The circle field is required when user Type is "Circle".',
        ]);




        User::create([
            'user_role' => $request->user_role,
            'name' => $request->name,
            'designation' => $request->designation,
            'mobile_number' => $request->mobile_number,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'range' => $request->range,
            'circle' => $request->circle,

        ]);
        Toastr::success('User Added Successfully!', 'Success');
        return redirect()->route('commissioner.users');


    }


    public function userEdit($id){
        $user = User::find($id);

        $otpResponse = MyHelper::sendOtp(Auth::user());

        if($otpResponse){

            Toastr::success('OTP Sending successfully');
            return view('commissioner.users.edit', compact('user'));
        }else{

            Toastr::error('OTP Sendign failed. Please try again.', 'Error');
            return redirect()->route('commissioner.users');
        }
    }

    public function userUpdate(Request $request, $id){

        $savedOTP = Auth::user()->user_otp;

        if ($request->user_otp != $savedOTP) {
            Toastr::error('Invalid OTP. Please try again.', 'Error');
            return redirect()->route('commissioner.users');
        }
        
        $request->validate([

            'user_role' => 'required',
            'name' => 'required',
            'designation' => 'required',
            'mobile_number' => 'required | digits:11',
            'email' => 'required | email',
            'password' => 'required',
            'range' => $request->user_role == 'range' ? 'required' : '',
            'circle' => $request->user_role == 'circle' ? 'required' : '',
            'user_otp' => 'required | digits:6',
        ], [
            'range.required' => 'The range field is required when user Type is "Range".',
            'circle.required' => 'The circle field is required when user Type is "Circle".',
        ]);


        User::where('id', $id)->update([
            'user_role' => $request->user_role,
            'name' => $request->name,
            'designation' => $request->designation,
            'mobile_number' => $request->mobile_number,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'range' => $request->range,
            'circle' => $request->circle,

        ]);

        Toastr::success('User Udated Successfully!', 'Success');
        return redirect()->route('commissioner.users');

        
    }


    public function userDelete($id){

        return "Delete Functionality will be added soon";

        
    }



    public function showPasswordResetForm(){

        if(!Auth::check()){
            return view('auth.login');
        }

        $otpResponse = MyHelper::sendOtp(Auth::user());

        if($otpResponse){

            Toastr::success('OTP Sending successfully');
            return view('auth.passwords.reset');
        }else{

            Toastr::error('OTP Sendign failed. Please try again.', 'Error');
            return redirect()->back();
        }



        
    }




    public function profile(){
        $user = Auth::user();
        return view('auth.profile', compact('user'));
    }




    public function passwordReset(Request $request){
        $savedOTP = Auth::user()->user_otp;

        if ($request->user_otp != $savedOTP) {
            Toastr::error('Invalid OTP. Please try again.', 'Error');
            return redirect()->back();

        };

 
        
        $request->validate([
            'password' => [
                'required',
            ],
            'user_otp' => 'required|digits:8'  ,
        ]);
        

        User::where('id', Auth::user()->id)->update([
            'password' => bcrypt($request->password),

        ]);

        Toastr::success('Password Updated Successfully!', 'Success');

        return redirect()->route('profile');

    }
}
