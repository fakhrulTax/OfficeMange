<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Toastr;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('commissioner.users.index', compact('users'));
    }


 

    public function userCreate(){
        return view('commissioner.users.create');
    }

    public function userStore(Request $request){
        
        $request->validate([
            'user_role' => 'required',
            'name' => 'required',
            'designation' => 'required',
            'mobile_number' => 'required | digits:11 | unique:users',
            'email' => 'required | email | unique:users',
            'password' => 'required',
            'range' => $request->user_role == 'range' ? 'required' : '',
            'circle' => $request->user_role == 'circle' ? 'required' : '',
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
        return view('commissioner.users.edit', compact('user'));
    }


    public function userDelete($id){
        $user = User::find($id);
        $user->delete();
        Toastr::success('User Deleted Successfully!', 'Success');
        return redirect()->route('commissioner.users');
    }
}
