<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Setting;
use App\Models\Zilla;
use App\Models\Upazila;
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

        $zillas = Zilla::orderBy('name', 'ASC')->get();
        $selectedUpazilaIds = json_decode(config('settings.upazila_id_' . Auth::user()->circle));   
        if(!$selectedUpazilaIds)
        {
            $selectedUpazilaIds = [];
        }
        $selectedUpazilas = Upazila::whereIn('id', $selectedUpazilaIds)->orderBy('name', 'ASC')->get();

    	return view('circle.setting.index',[
    		'title' => 'Settings',
            'zillas' => $zillas,
            'selectedUpazilas' =>  $selectedUpazilas,
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
        
        //Take Mutiple Upaziall ID
        if( $request['upazila_id_' . Auth::user()->circle] )
        {           
            $request['upazila_id_' . Auth::user()->circle] = json_encode($request['upazila_id_' . Auth::user()->circle]);            
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

    // Update Assessment Year
    public function updateAssessmentYear(Request $request)
    {
        // Validate assessment year (example: 8-digit validation)
        $request->validate([
            'assessment_year' => 'required|digits:8|numeric',
        ]);

        if (Auth::user()->user_role == 'commissioner' && isset($request->assessment_year)) {
            // Update the assessment year for commissioner role
            Setting::set('assessment_year_commissioner', $request->assessment_year);
            
            // Show success message
            Toastr::success('Assessment Year Changed', 'Success');
            
            // Redirect back to the previous page
            return redirect()->back();
        }

        // Optionally handle cases when the user role is not commissioner
        Toastr::error('Unauthorized access', 'Error');
        return redirect()->back();
    }

}
