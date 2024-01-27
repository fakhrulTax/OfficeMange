<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\MyHelper;
use App\Models\Stock;
use Illuminate\Support\Facades\Auth;


class StockController extends Controller
{
    public function index(){

<<<<<<< HEAD
        return view('circle.stock.index');
=======
        $Stocks = Stock::latest()->get();

        return view('circle.stock.index', compact('Stocks'));
    }


    public function store(Request $request){
        
        try {
            $request->validate([
                'tin' => 'required|unique:stocks|min:12|max:12',
                'name' => 'required',
                'bangla_name' => 'required',
                'mobile' => 'min:11|max:11',
            ]);
            //check existing court name for current user

            $sort_name = MyHelper::sortName($request->name);

            $circle = Auth::user()->circle;
           
            if($request->address_line_one != null && $request->address_line_two != null && $request->address_line_three != null){
               
                // $address = $request->address_line_one . ' | ' . $request-> address_line_two . ' | '. $request->address_line_three;

                $address = '<p>'. $request->address_line_one .'</p>, <p>' . $request-> address_line_two .'</p>, <p>' . $request->address_line_three .'</p>';
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
        return view('circle.stock.edit_modal', compact('StockInfo'))->render();

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
                'bangla_name' => 'required',
                'mobile' => 'min:11|max:11',
            ]);
            //check existing court name for current user

            $sort_name = MyHelper::sortName($request->name);
           
            if($request->address_line_one != null && $request->address_line_two != null && $request->address_line_three != null){
               
                // $address = $request->address_line_one . ' | ' . $request-> address_line_two . ' | '. $request->address_line_three;

                $address = '<p>'. $request->address_line_one .'</p>, <p>' . $request-> address_line_two .'</p>, <p>' . $request->address_line_three .'</p>';
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
>>>>>>> c8c99453e942ba3b1e698c8c6bacd41c86185225
    }
}
