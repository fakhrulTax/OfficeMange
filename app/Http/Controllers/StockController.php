<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\MyHelper;
use App\Models\Stock;
use Illuminate\Support\Facades\Auth;
use PDF;


class StockController extends Controller
{
    public function index(){

        $Stocks = Stock::latest()->where('circle', Auth::user()->circle)->get();

        return view('circle.stock.index', compact('Stocks'));
    }


    public function store(Request $request){
        
        try {
            $request->validate([
                'tin' => 'required|unique:stocks|min:12|max:12',
                'name' => 'required',
            ]);

            if($request->mobile != null){
                $request->validate([
                    'mobile' => 'min:11|max:11',
                ]);
            }
            //check existing court name for current user

            $sort_name = MyHelper::sortName($request->name);

            $circle = Auth::user()->circle;
           
            if($request->address_line_one != null && $request->address_line_two != null && $request->address_line_three != null){

                $address = MyHelper::address_encode($request->address_line_one, $request->address_line_two, $request->address_line_three);
                
            }else{

                $address = null;
            }
            

            Stock::create([
                'tin' => $request->tin,
                'name' => $request->name,
                'bangla_name' => $request->bangla_name,
                'sort_name' =>  $sort_name,
                'email' => $request->email,
                'mobile'=>$request->mobile,
                'type' => $request->type,
                'file_in_stock' => $request->file_in_stock,
                'file_rack' => $request->file_rack,
                'circle' =>  $circle,
                'address'=> $address,
                'last_return'=> $request->last_return

            ]);

            return response()->json([
                'message' => 'Tax payer added successfully',
                'status' => 200
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'status' => 500
            ]);
        }
    }




    public function edit(Request $request){
 
        $StockInfo = Stock::find($request->id);

        //Addrees convert to three line
        if( $StockInfo->address )
        {
            $address = MyHelper::address_decode($StockInfo->address);
            $StockInfo->address_line_one = $address[0];
            $StockInfo->address_line_two = $address[1];
            $StockInfo->address_line_three = $address[2];
        }
        
        return view('circle.stock.edit_modal', compact('StockInfo'))->render();

    }

    public function stockEditByid(Request $request){
 
        $StockInfo = Stock::find($request->id);

        //Addrees convert to three line
        if( $StockInfo->address )
        {
            $address = MyHelper::address_decode($StockInfo->address);
            $StockInfo->address_line_one = $address[0];
            $StockInfo->address_line_two = $address[1];
            $StockInfo->address_line_three = $address[2];
        }
        
        return view('circle.stock.edit_modal2', compact('StockInfo'))->render();

    }



    public function update(Request $request){
        try {

    
            $stock = Stock::find($request->id);

            if(!$stock){
                return response()->json([
                    'message' => 'Tax payer not found',
                    'status' => 404
                ]);
            }


            $request->validate([
                'name' => 'required',
            ]);

            if($request->mobile != null){
                $request->validate([
                    'mobile' => 'min:11|max:11',
                ]);
            }
            //check existing court name for current user

            $sort_name = MyHelper::sortName($request->name);
           
            if($request->address_line_one != null && $request->address_line_two != null && $request->address_line_three != null){
               
                $address = MyHelper::address_encode($request->address_line_one, $request->address_line_two, $request->address_line_three);
            }else{

                $address = null;
            }

            

            $stock->update([
                'name' => $request->name,
                'bangla_name' => $request->bangla_name,
                'sort_name' =>  $sort_name,
                'email' => $request->email,
                'mobile'=>$request->mobile,
                'type' => $request->type,
                'file_in_stock' => $request->file_in_stock,
                'file_rack' => $request->file_rack,
                'address'=> $address,
                'last_return'=> $request->last_return
            ]);

            return response()->json([
                'message' => 'Tax payer updated successfully',
                'status' => 200
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'status' => 500
            ]);
        }
    }



    public function stockUpdateByid(Request $request){
        try {

    
            $stock = Stock::find($request->id);

            if(!$stock){
                return response()->json([
                    'message' => 'Tax payer not found',
                    'status' => 404
                ]);
            }



            if($request->mobile != null){
                $request->validate([
                    'mobile' => 'min:11|max:11',
                ]);
            }
            //check existing court name for current user

            $sort_name = MyHelper::sortName($request->name);
           
            if($request->address_line_one != null && $request->address_line_two != null && $request->address_line_three != null){
               
                $address = MyHelper::address_encode($request->address_line_one, $request->address_line_two, $request->address_line_three);
                
            }else{

                $address = null;
            }

            

            $stock->update([
                'bangla_name' => $request->bangla_name,
                'mobile'=>$request->mobile,
                'address'=> $address,
            ]);

            return response()->json([
                'message' => 'Tax payer updated successfully',
                'status' => 200
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'status' => 500
            ]);
        }
    }






    public function tinChecker($tin){

        $stock = Stock::where('tin',$tin)->first();
        if($stock){
            return response()->json([
                'status' => 200
            ]);
        }else{
            return response()->json([
                'status' => 404
            ]);
        }
    }

    public function view($id){
        $stock = Stock::find($id);
        return view('circle.stock.view', compact('stock'));
    }

    //Envelop
    public function envelop($tin)
    {
        $stock = Stock::where('tin', $tin)->first();
        $officeAddress = config('settings.circle_address_'.Auth::user()->circle);
        $pdf = PDF::loadView('circle.notice.envelop', [
            'stock' => $stock,
            'officeAddress' => $officeAddress
        ]);
        return $pdf->stream('document.pdf');
        
    }
}
