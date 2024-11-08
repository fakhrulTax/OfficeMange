<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

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

        //$otpResponse = MyHelper::sendOtp(Auth::user());
        $otpResponse ="success";

        if($otpResponse){

            Toastr::success('OTP Sending successfully');
            return view('commissioner.users.create');
        }else{

            Toastr::error('OTP Sendign failed. Please try again.', 'Error');
            return redirect()->route('commissioner.users');
        }

  
        
    }

    public function userStore(Request $request){

        //$savedOTP = Auth::user()->user_otp;
        $savedOTP = 111111;

        if ($request->user_otp != $savedOTP) {
            Toastr::error('Invalid OTP. Please try again.', 'Error');
            return redirect()->route('commissioner.users');
        }
        
        $request->validate([

            'user_role' => 'required',
            'name' => 'required',
            'designation' => 'required',
            'mobile_number' => 'required | digits:11',
            'email' => 'required | email | unique:users',
            'password' => ['required', Password::min(8)
            ->mixedCase()
            ->symbols()],
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

        //$otpResponse = MyHelper::sendOtp(Auth::user());
        $otpResponse = 11111;

        if($otpResponse){

            Toastr::success('OTP Sending successfully');
            return view('commissioner.users.edit', compact('user'));
        }else{

            Toastr::error('OTP Sendign failed. Please try again.', 'Error');
            return redirect()->route('commissioner.users');
        }
    }



    public function userUpdate(Request $request, $id)
    {
        //$savedOTP = Auth::user()->user_otp;
        $savedOTP = 111111;

        // Check OTP validity
        if ($request->user_otp != $savedOTP) {
            Toastr::error('Invalid OTP. Please try again.', 'Error');
            return redirect()->route('commissioner.users');
        }

        // Define validation rules
        $rules = [
            'user_role' => 'required',
            'name' => 'required',
            'designation' => 'required',
            'mobile_number' => 'required|digits:11',
            'email' => 'required|email',
            'range' => $request->user_role == 'range' ? 'required' : '',
            'circle' => $request->user_role == 'circle' ? 'required' : '',
            'user_otp' => 'required|digits:6',
        ];

        // Conditionally add password validation if password is provided
        if ($request->filled('password')) {
            $rules['password'] = [
                'nullable',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ];
        }

        // Validate the request with custom error messages
        $request->validate($rules, [
            'range.required' => 'The range field is required when user Type is "Range".',
            'circle.required' => 'The circle field is required when user Type is "Circle".',
            'password' => 'Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one digit, and one special character.',
        ]);

        // Prepare data to update
        $updateData = [
            'user_role' => $request->user_role,
            'name' => $request->name,
            'designation' => $request->designation,
            'mobile_number' => $request->mobile_number,
            'email' => $request->email,
            'range' => $request->range,
            'circle' => $request->circle,
        ];

        // If password is provided, hash it and include in update
        if ($request->filled('password')) {
            $updateData['password'] = bcrypt($request->password);
        }

        // Update the user record
        User::where('id', $id)->update($updateData);

        Toastr::success('User Updated Successfully!', 'Success');
        return redirect()->route('commissioner.users');
    }


    public function profileEdit($id){
        $user = User::find($id);
        return view ('auth.profile_edit', compact('user'));
    }

    public function profileUpdate(Request $request, $id){
        
        $request->validate([
            'name' => 'required',
            'designation' => 'required',
            'mobile_number' => 'required | digits:11',
            'office_name' => 'required',

        ]);
        User::where('id', $id)->update([
            'name' => $request->name,
            'designation' => $request->designation,
            'mobile_number' => $request->mobile_number,
            'office_name' => $request->office_name,
        ]);

        Toastr::success('Profile Updated Successfully!', 'Success');
        return redirect()->route('profile');
        
    }


    public function userDelete($id){

        if($id == Auth::user()->id){
            Toastr::error('You can not delete yourself!', 'Error');
            return redirect()->back();
        }
        User::where('id', $id)->delete();
        Toastr::success('User Deleted Successfully!', 'Success');
        return redirect()->back();

        
    }



    public function showPasswordResetForm(){
     
        if(!Auth::check()){
            return view('auth.login');
        }

       // $otpResponse = MyHelper::sendOtp(Auth::user());
       $otpResponse = 'success';

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

        
        //$savedOTP = Auth::user()->user_otp;
        $savedOTP = 11111111;

        if ($request->user_otp != $savedOTP) {
            Toastr::error('Invalid OTP. Please try again.', 'Error');
            return redirect()->back();

        };

        $request->validate([
            'password' => ['required', Password::min(8)
            ->mixedCase()
            ->symbols()],
            'user_otp' => 'required|digits:8'  ,
        ]);
        
       
        

        User::where('id', Auth::user()->id)->update([
            'password' => bcrypt($request->password),

        ]);

        Toastr::success('Password Updated Successfully!', 'Success');

        Auth::logout();
        return redirect()->route('login');

    }
}
