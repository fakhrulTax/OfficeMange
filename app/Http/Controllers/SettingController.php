<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Setting;
use Toastr;

class SettingController extends Controller
{
    public function index()
    {
        
        if( Auth::user()->user_role == 'commissioner' )
        {            
            return view('commissioner.setting.index',[
                'title' => 'Settings'
            ]);
        }

    	return view('circle.setting.index',[
    		'title' => 'Settings'
    	]);
    }

    public function update(Request $request)
    {

        
        if (Auth::user()->user_role == 'circle' && !isset($request['sidebar_collapse_' . Auth::user()->circle])) {
            $request['sidebar_collapse_' . Auth::user()->circle] = null;
        }
        

        if( Auth::user()->user_role == 'commissioner' &&  !isset($request->sidebar_collapse_commissioner) )
        {   
            $request['sidebar_collapse_commissioner'] = null;
        }
      
    	$keys = $request->except('_token');	

        foreach ($keys as $key => $value)
        {
            Setting::set($key, $value);
        }

        if( Auth::user()->user_role == 'commissioner' )
        {            
            Toastr::success('Settings Save Successful', 'Success');
            return redirect()->route('commissioner.setting.index');
        }

        Toastr::success('Settings Save Successful', 'Success');
        return redirect()->route('circle.setting.index');
    }
}
