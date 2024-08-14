<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Retarn;
use Illuminate\Support\Facades\Auth;
use App\Helpers\MyHelper;
use Toastr;


class RetarnController extends Controller
{

    //Check the Valid TIN
    public function checkTIN(Request $request)
    {
        $stock = Stock::where('tin', $request->tin)->first();

        if ($stock) {
            if ($stock->circle == Auth::user()->circle) {
                return response()->json(['name' => $stock->name, 'circleStatus' => 'same', 'circle' => $stock->circle ]);
            } else {
                return response()->json(['name' => $stock->name, 'circleStatus' => 'another', 'circle' => $stock->circle]);
            }
        }

        return response()->json(['circleStatus' => 'not added']);
    }


    //Register Serial
    public function getRegisterSerial(Request $request)
    {
        $last_register_serial = Retarn::where('register', $request->register)
                                        ->where('assessment_year', $request->assessment_year)
                                        ->where('circle', Auth::user()->circle)
                                        ->orderBy('register_serial', 'DESC')
                                        ->first();
        $next_register_serial = $last_register_serial ? $last_register_serial->register_serial + 1 : 1;
        return response()->json(['next_register_serial' => $next_register_serial]);
    }

    //Index
    public function index()
    {
        $retarns = Retarn::where('circle', Auth::user()->circle)->orderBy('id', 'DESC')->paginate(500);
        return view('circle.retarn.index', [
                                'retarns' => $retarns, 
                                'helper' => new MyHelper(),
                    ]);
    }

    //Return Create
    public function create(){
        return view('circle.retarn.create', ['Helper' => new MyHelper()]);
    }

    //Store
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'assessment_year' => 'required|integer|digits:8',
            'register' => 'required|string',
            'return_submission_date' => 'required|date_format:d-m-Y',
            'register_serial' => 'required|integer',
            'tin' => 'required|integer|digits:12',
            'source_of_income' => 'nullable|string',
            'income' => 'required|numeric',
            'income_of_poultry_fisheries' => 'nullable|numeric',
            'income_of_remittance' => 'nullable|numeric',
            'source_tax' => 'nullable|numeric',
            'advance_tax' => 'nullable|numeric',
            'retarn_tax' => 'nullable|numeric',
            'late_fee' => 'nullable|numeric',
            'sercharge' => 'nullable|numeric',
            'total_tax' => 'nullable|numeric',
            'liabilities' => 'nullable|numeric',
            'net_asset' => 'required|numeric',
            'comments' => 'nullable|string',
            'tax_of_schedule_one' => 'nullable|numeric',
            'special_tax' => 'nullable|numeric',
            'special_invest' => 'nullable|numeric',
        ]);
        
        //check the tin is exist in stock table
        $stock = Stock::where('tin', $request->tin)->first();
        if(!$stock){
            Toastr::error('The TIN is not available in Stock', 'danger');
            return back()->withInput();
        }

        //Check the taxpayer already submitted return for the same assessment year
        $checkRetarn = Retarn::where('tin', $request->tin)->where('assessment_year', $request->assessment_year)->first();
        if($checkRetarn){
            Toastr::error('The Taxpayer already submitted return for ass. year '. $request->assessment_year, 'danger');
            return back()->withInput();
        }

        // Convert the date to the correct format for storing in the database
        $validatedData['return_submission_date'] = \Carbon\Carbon::createFromFormat('d-m-Y', $validatedData['return_submission_date'])->format('Y-m-d');
        
        // Store the validated data in the database
        $retarn = new Retarn($validatedData);
        $retarn->circle = Auth::user()->circle;
        $retarn->name = $stock->name;
        $retarn->save();

        // Store the last register_serial and register in session
        session([
            'next_register_serial' => $request->register_serial + 1,
            'last_register' => $request->register,
            'last_assessment_year' => $request->assessment_year,
            'subission_date' =>  $request->return_submission_date,
        ]);

        Toastr::success('Return Added Successful', 'success');
        return redirect()->back()->with('success', 'Retarn has been added successfully.');
    }

    //Update Return 
    public function edit($id)
    {
        // Retrieve the Retarn record by its ID
        $retarn = Retarn::findOrFail($id);

        // Return the edit view with the Retarn data
        return view('circle.retarn.edit',  ['retarn' => $retarn, 'Helper' => new MyHelper()]);
    }

    public function update(Request $request, $id)
    {
        $retarn = Retarn::findOrFail($id);

        //Validate
        $validatedData = $request->validate([
            'assessment_year' => 'required|integer|digits:8',
            'register' => 'required|string',
            'return_submission_date' => 'required|date_format:d-m-Y',
            'register_serial' => 'required|integer',
            'tin' => 'required|integer|digits:12',
            'source_of_income' => 'nullable|string',
            'income' => 'required|numeric',
            'income_of_poultry_fisheries' => 'nullable|numeric',
            'income_of_remittance' => 'nullable|numeric',
            'source_tax' => 'nullable|numeric',
            'advance_tax' => 'nullable|numeric',
            'retarn_tax' => 'nullable|numeric',
            'late_fee' => 'nullable|numeric',
            'sercharge' => 'nullable|numeric',
            'total_tax' => 'nullable|numeric',
            'liabilities' => 'nullable|numeric',
            'net_asset' => 'required|numeric',
            'comments' => 'nullable|string',
            'tax_of_schedule_one' => 'nullable|numeric',
            'special_tax' => 'nullable|numeric',
            'special_invest' => 'nullable|numeric',
        ]);

        //check the tin is exist in stock table
        $stock = Stock::where('tin', $request->tin)->first();
        if(!$stock){
            Toastr::error('The TIN is not available in Stock', 'danger');
            return back()->withInput();
        }

        //Check the taxpayer already submitted return for the same assessment year
        $checkRetarn = Retarn::where('tin', $request->tin)
                                ->where('assessment_year', $request->assessment_year)
                                ->where('id', '!=', $retarn->id) // Exclude the same ID
                                ->first();
        if($checkRetarn){
            Toastr::error('The Taxpayer already submitted return for ass. year '. $request->assessment_year, 'danger');
            return back()->withInput();
        }

        // Convert the date to the correct format for storing in the database
        $validatedData['return_submission_date'] = \Carbon\Carbon::createFromFormat('d-m-Y', $validatedData['return_submission_date'])->format('Y-m-d');
        
        // Update the Retarn with the validated data
        $retarn->update($validatedData);

        Toastr::success('Return Update Successful', 'success');
        return redirect()->route('circle.return.index')->with('success', 'Retarn has been updated successfully.');

    }                            

}
