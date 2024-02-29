<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Arrear;
use App\Models\Stock;
use App\Models\Collection;
use Illuminate\Support\Facades\Auth;
use App\Helpers\MyHelper;
use Illuminate\Support\Facades\DB;

use PDF;

use Illuminate\Pagination\LengthAwarePaginator;

class ArrearController extends Controller
{

    //Arrear Notice
     public function notice( Request $request )
     {
                       
         //Validation
         $request->validate([
             'issue_date' => 'required',
             'hearing_date' => 'required',
         ]);

         //Get Stock Information
         $arrears = Arrear::orderBy('assessment_year', 'ASC')->where('tin', $request->tin)->get();
         $stock = Stock::where('tin',$request->tin)->firstOrFail();

         $circle = Auth::user()->circle;
 
         $pdf = PDF::loadView('circle.arrear.notice', [
             'stock' => $stock, 
             'data' => $request, 
             'arrears' => $arrears, 
             'collection' => new Collection(),
             'circle' => $circle,
             'Helper' => new MyHelper(),
             ]);
         return $pdf->stream('document.pdf');
     }

    //Arrear Search
    public function search(Request $request){

        $circle = Auth::user()->circle;

        $arrears = Arrear::query();

        if(!empty($request->tin)){
            $arrears = $arrears->where('tin', $request->tin);
        }

        if(!empty($request->arrear_type)){
            $arrears = $arrears->where('arrear_type', $request->arrear_type);
        }

        if (!empty($request->from_date) && !empty($request->to_date)) {

            $arrears = $arrears->whereBetween('demand_create_date', [date('Y-m-d', strtotime($request->from_date)), date('Y-m', strtotime($request->to_date))]);
        }

        $arrears = $arrears->where('circle', $circle);

        $arrears = $arrears->get();

        $arrears = $arrears->groupBy('tin');

        // Manually paginate the grouped data
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 100; // Adjust the number of items per page as needed

        $currentPageItems = $arrears->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $paginatedData = new LengthAwarePaginator($currentPageItems, count($arrears), $perPage);
        $paginatedData->setPath(request()->url());

        return view('circle.arrear.index', [
            'arrears' => $paginatedData, 
            'Helper' => new MyHelper(),
            'title' => 'Advance | Search'
            ]);
    }

    public function index()
    {
        $circle = Auth::user()->circle;
        
        $arrears = Arrear::where('circle', $circle)
        ->orderBy('tin', 'ASC')
        ->orderBy('assessment_year', 'ASC')
        ->get()
        ->groupBy('tin');


        // Manually paginate the grouped data
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 100; // Adjust the number of items per page as needed

        $currentPageItems = $arrears->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $paginatedData = new LengthAwarePaginator($currentPageItems, count($arrears), $perPage);
        $paginatedData->setPath(request()->url());

        return view('circle.arrear.index', [
            'arrears' => $paginatedData, 
            'Helper' => new MyHelper(),
        ]);
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

            'demand_create_date' => date('Y-m-d', strtotime($request->demand_create_date)),

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

                'demand_create_date' => date('Y-m-d', strtotime($request->demand_create_date)),

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
