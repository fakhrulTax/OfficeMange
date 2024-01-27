<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Arrear;
use Illuminate\Support\Facades\Auth;
class ArrearController extends Controller
{
    public function index()
    {
        $arrears = Arrear::with('stock')->get();


        return view('circle.arrear.index', compact('arrears'));
    }




    public function store(Request $request){

       
       try{
        $request->validate([
            'arrear_type' => 'required',
            'tin' => 'required | digits:12',
            'demand_create_date' => 'required',
            'assessment_year' => 'required | digits:8',
            'arrear' => 'required',
        ]);


        $circle = Auth::user()->circle;

        Arrear::create([
            'arrear_type' => $request->arrear_type,
            'tin' => $request->tin,
            'demand_create_date' => date('d-m-Y', strtotime($request->demand_create_date)),
            'assessment_year' => $request->assessment_year,
            'arrear' => $request->arrear,
            'circle' => $circle,
            'fine' => $request->fine,
            'comments' => $request->comments

        ]);

        return response()->json([
            'message' => 'Arrear added successfully',
            'status' => 200
        ], 200);


       }catch (\Throwable $th) {
        return response()->json([
            'message' => $th->getMessage(),
            'status' => 500
        ]);
    }

        
        
    }
}
