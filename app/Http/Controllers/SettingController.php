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
    	return view('circle.setting.index',[
    		'title' => 'Settings'
    	]);
    }

    public function update(Request $request)
    {
        
        if( !isset($request->sidebar_collapse) )
        {
            $request['sidebar_collapse_'. Auth::user()->circle] = null;
        }

    	$keys = $request->except('_token');	

        foreach ($keys as $key => $value)
        {
            Setting::set($key, $value);
        }

        Toastr::success('Settings Save Successful', 'Success');
        return redirect()->route('circle.setting.index');
    }
}
