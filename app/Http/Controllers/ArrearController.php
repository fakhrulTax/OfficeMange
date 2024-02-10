<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Arrear;
use Illuminate\Support\Facades\Auth;
use App\Helpers\MyHelper;
use PDF;

class ArrearController extends Controller
{
    public function index()
    {

        $arrears = Arrear::where('circle', Auth::user()->circle)->with('stock')->latest()->get()->groupBy('tin');

        // $arrears = Arrear::with('stock')->latest()->get();
        
  

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


        $isExistTin = MyHelper::tinCheck($request->tin);

        if($isExistTin == false){
            throw new \Exception('Tax Payer Not Added Yet!');
        }

        $isExistArrear = Arrear::where('tin', $request->tin)->where('assessment_year', $request->assessment_year)->first();

        if($isExistArrear){
            throw new \Exception('Arrear Already Added!');
        }


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

    public function edit(Request $request){

        $arrear = Arrear::where('id',  $request->id)->first();
        return view('circle.arrear.edit_arrear', compact('arrear'))->render();
    }



    public function update(Request $request){
        try{


            $request->validate([
                'arrear_type' => 'required',
                'demand_create_date' => 'required',
                'assessment_year' => 'required | digits:8',
                'arrear' => 'required',
            ]);

            $tin = Arrear::where('id', $request->id)->first();

             //check tin is exist in another row or not
          
            $isExistArrear = Arrear::where('tin', $tin->tin)->where('assessment_year', $request->assessment_year)->first();

            
            if($isExistArrear){
                if($isExistArrear->id != $tin ->id){
                    throw new \Exception('Arrear Already Added!');
                }
                
            }
    
    
    
            Arrear::where('id', $request->id)->update([
                'arrear_type' => $request->arrear_type,
                'demand_create_date' => date('d-m-Y', strtotime($request->demand_create_date)),
                'assessment_year' => $request->assessment_year,
                'arrear' => $request->arrear,
                'fine' => $request->fine,
                'comments' => $request->comments
            ]);
    
            return response()->json([
                'message' => 'Arrear updated successfully',
                'status' => 200
            ], 200);
    
    
           }catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'status' => 500
            ]);
         }
    }
 

    public function CommissionerArrear($circle){

        $arrears = Arrear::with('stock')->latest()->get()->groupBy('tin');
        if($circle != 'all'){
            $arrears = Arrear::with('stock')->where('circle', $circle)->latest()->get()->groupBy('tin');
        }

        $result = MyHelper::calculateArrearSum('all');

        $GrandArrear = $result['GrandArrear'];
        $TotalDisputedArrear = $result['TotalDisputedArrear'];
        $TotalUndisputedArrear = $result['TotalUndisputedArrear'];

       

        return view ('commissioner.arrear.index', compact('GrandArrear', 'TotalDisputedArrear', 'TotalUndisputedArrear', 'arrears', 'circle' ));

    }




    public function CommissionerArrearSort(Request $request ) {
        
        $circle = $request->circle;
        if( $circle == 'all'){
            $arrears = Arrear::with('stock')->latest()->get()->groupBy('tin');
            $result = MyHelper::calculateArrearSum('all');
        }else{
            $arrears = Arrear::with('stock')->where('circle', $circle)->latest()->get()->groupBy('tin');
            $result = MyHelper::calculateArrearSum($circle);
        }

        $GrandArrear = $result['GrandArrear'];
        $TotalDisputedArrear = $result['TotalDisputedArrear'];
        $TotalUndisputedArrear = $result['TotalUndisputedArrear'];

       

        return view ('commissioner.arrear.index', compact('GrandArrear', 'TotalDisputedArrear', 'TotalUndisputedArrear', 'arrears', 'circle' ));

    }
    
    
}
