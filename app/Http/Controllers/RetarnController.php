<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Retarn;
use Illuminate\Support\Facades\Auth;
use App\Helpers\MyHelper;


class RetarnController extends Controller
{
    //Return Create
    public function create(){
        return view('circle.retarn.create', ['Helper' => new MyHelper()]);
    }

    //Store
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'assessment_year' => 'required|integer',
            'register' => 'required|string',
            'return_submission_date' => 'required|date_format:d-m-Y',
            'register_serial' => 'required|integer',
            'tin' => 'required|integer',
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

        // Convert the date to the correct format for storing in the database if necessary
        $validatedData['return_submission_date'] = \Carbon\Carbon::createFromFormat('d-m-Y', $validatedData['return_submission_date'])->format('Y-m-d');
       
        // Store the validated data in the database
        $retarn = new Retarn($validatedData);
        $retarn->circle = Auth::user()->circle;
        $retarn->save();

        return redirect()->back()->with('success', 'Retarn has been added successfully.');
    }
}
