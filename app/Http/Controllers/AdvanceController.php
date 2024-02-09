<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Advance;
use App\Models\Stock;
use Toastr;
class AdvanceController extends Controller
{
    public function advanceIndex(){
        $advances = Advance::orderBy('id', 'DESC')->paginate(100);
        return view('circle.advance.index', compact('advances') );
    }


    public function create(){
        return view('circle.advance.create');
    }


    public function store(Request $request){
        $request->validate([
            'tin' => 'required|digits:12',
            'advance_assessment_year' => 'required',
            'return_submitted_assessment_year' => 'required|digits:8',
            'income' => 'required',
            'tax' => 'required',

        ]);

        //check the tin is exist in stock table
        $stock = Stock::where('tin', $request->tin)->first();
        if(!$stock){
            Toastr::error('There is no stock for this TIN', 'danger');
            return back();
        }

        //check the tin is exist in advance table

        $advance = Advance::where('tin', $request->tin)->where('advance_assessment_year', $request->advance_assessment_year)->first();
        if($advance){
            Toastr::error('There is already advance for this TIN and Assessment Year', 'danger');
            return back();
        }

        $advance = new Advance();
        $advance->tin = $request->tin;
        $advance->advance_assessment_year = $request->advance_assessment_year;
        $advance->return_submitted_assessment_year = $request->return_submitted_assessment_year;
        $advance->income = $request->income;
        $advance->tax = $request->tax;
        $advance->save();

        Toastr::success('Advance Added Successfully', 'Success');

        return redirect()->route('circle.advance.index');


        
        
    }


    public function edit($id){
        $advance = Advance::find($id);
        return view('circle.advance.edit', compact('advance'));
    }


    public function update(Request $request, $id){
        $request->validate([
            'tin' => 'required|digits:12',
            'advance_assessment_year' => 'required',
            'return_submitted_assessment_year' => 'required|digits:8',
            'income' => 'required',
            'tax' => 'required',

        ]);

        //check the tin is exist in stock table
        $stock = Stock::where('tin', $request->tin)->first();
        if(!$stock){
            Toastr::error('There is no stock for this TIN', 'Danger');
            return back();
        }

        //check the tin is exist in advance table
        $advance = Advance::where('tin', $request->tin)->where('advance_assessment_year', $request->advance_assessment_year)->first();

        if($advance->id != $id){
            
            Toastr::error('There is already advance for this TIN and Assessment Year', 'Danger');
            return back();
        }

        $advance = Advance::find($id);
        $advance->update([
            'tin' => $request->tin,
            'advance_assessment_year' => $request->advance_assessment_year,
            'return_submitted_assessment_year' => $request->return_submitted_assessment_year,
            'income' => $request->income,
            'tax' => $request->tax

        ]);
        Toastr::success('Advance Updated Successfully', 'success');
        return redirect()->route('circle.advance.index');

    }


    public function search(Request $request){
        $advances = Advance::query();

        if(!empty($request->tin)){
            $advances = $advances->where('tin', $request->tin);
        }

        if(!empty($request->advance_assessment_year)){

            $advances = $advances->where('advance_assessment_year', $request->advance_assessment_year);
            
        }

        $advances = $advances->paginate(100);


       
        return view('circle.advance.index', compact('advances') );
    }



}
