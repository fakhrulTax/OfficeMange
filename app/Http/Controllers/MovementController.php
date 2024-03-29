<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Movement;
use App\Models\Stock;
use App\Models\Arrear;
use Toastr;

class MovementController extends Controller
{
    // Display a listing of the movements.
    public function index()
    {
        $movements = Movement::where('circle',Auth::user()->circle)
                                ->orderBy('move_date', 'DESC')
                                ->paginate(100);

    	return view('circle.movement.index')->with([
    				'title' 	=> 'Movement',
    				'movements' => $movements
    	]);
    }

    // Store a newly created movement in the database.
    public function store(Request $request)
    {
        // Validation rules
        $request->validate([
            'tin' => 'required|digits:12',
            'move_date' => 'required|date_format:d-m-Y',
            'office_name' => 'required',
            'assessment_year' => 'required|array',
            'assessment_year.*' => 'integer|min:20052006|max:20232024',           
        ]);

        //Check The TIN Is Available in Stock
        if( Stock::stockCheck($request->tin) == false ) 
        {
            Toastr::error('TIN is not available in stock..', 'danger');
            return back()->withInput();
        }

        //Check The File is already moved out of office
        $m = Movement::Where('tin', '=', $request->tin)->Where('receive_date', '=', null)->first();
        if( $m )
        {
            Toastr::error('File is already out of office..', 'danger');
        	return back()->withInput();
        }  

        //If File Move For Appeal Tribunal
        if( in_array($request->office_name, ['appeal', 'tribunal', 'high_court', 'review']) )
        {
            //Check The Arrear is avialable for given all assessment year
            foreach($request->assessment_year as $assessment_year){
                $arrear = Arrear::checkArrear($request->tin, $assessment_year);
                if (!$arrear) {
                    Toastr::error('There is no arrear for Assessment Year '.$assessment_year, 'danger');
                    return back()->withInput();
                }
            }
        
            //Update Arrear Status
            Arrear::updateStatus($request->tin, $request->assessment_year, 'disputed');

        }        
        
        //Store Movement
        Movement::create([
            'tin' => $request->tin,
            'move_date' => date('Y-m-d', strtotime($request->move_date)),
            'office_name' => $request->office_name,
            'assessment_year' => json_encode($request->assessment_year),
            'circle' => Auth::user()->circle
        ]);
    
        Toastr::success('Movement recorded successfully and Arrear Status Update.', 'success');
        return redirect()->route('circle.movement.index');
        
    }

    
    // Show the form for editing the specified movement.
    public function edit($id)
    {
        $movements = Movement::orderBy('move_date', 'DESC')->paginate(100);
		$editMovement = Movement::find($id);

    	return view('circle.movement.index')->with([
    				'title' 	=> 'Movement',
    				'movements' => $movements,
    				'editMovement' => $editMovement
    	]);
    }

    // Update the specified movement in the database.
    public function update(Request $request, $id)
    {
        // Validation rules
        $request->validate([
            'tin' => 'required|digits:12',
            'move_date' => 'required|date_format:d-m-Y',
            'office_name' => 'required',
            'assessment_year' => 'required|array',
            'assessment_year.*' => 'integer|min:20052006|max:20232024',
        ]);
    
        //Check The TIN Is Available in Stock
        if( Stock::stockCheck($request->tin) == false ) 
        {
            Toastr::error('TIN is not available in stock..', 'danger');
            return back()->withInput();
        }
    
        //Check The File is already moved out of office
        $m = Movement::find($id);
        if( !$m )
        {
            Toastr::error('Movement not found.', 'danger');
            return back()->withInput();
        }
    
        // If the office_name is one of the specified types, perform arrear-related checks and updates
        if( in_array($request->office_name, ['appeal', 'tribunal', 'high_court', 'review']) )
        {
            // Check The Arrear is available for given all assessment year
            foreach($request->assessment_year as $assessment_year){
                $arrear = Arrear::checkArrear($request->tin, $assessment_year);
                if (!$arrear) {
                    Toastr::error('There is no arrear for Assessment Year '.$assessment_year, 'danger');
                    return back()->withInput();
                }
            }
    
            // Update Arrear Status
            Arrear::updateStatus($request->tin, $request->assessment_year, 'disputed');
        }        
    
        // Update Movement
        $m->update([
            'tin' => $request->tin,
            'move_date' => date('Y-m-d', strtotime($request->move_date)),
            'office_name' => $request->office_name,
            'assessment_year' => json_encode($request->assessment_year),
            'circle' => Auth::user()->circle
        ]);
    
        Toastr::success('Movement updated successfully and Arrear Status updated.', 'success');
        return redirect()->route('circle.movement.index');
    }
    

    public function receive($id)
    {
        $movements = Movement::orderBy('move_date', 'DESC')->paginate(100);
        $receiveMovement = Movement::find($id);
        return view('circle.movement.index')->with([
                    'title'     => 'Movement Receive',
                    'movements' => $movements,
                    'receiveMovement' => $receiveMovement
        ]);
    }

    public function receiveUpdate(Request $request, $id)
    {
        $request->validate([
    		'receive_date' => 'required|date_format:d-m-Y',
    	]);

    	$movement = Movement::find($id);
    	$movement->receive_date = date('Y-m-d', strtotime($request->receive_date));
        $movement->save();

        Toastr::success('File Received successful.', 'success');
        return redirect()->route('circle.movement.index');
    }
}
