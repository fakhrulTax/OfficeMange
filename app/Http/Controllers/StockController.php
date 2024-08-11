<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\MyHelper;
use App\Models\Stock;
use Illuminate\Support\Facades\Auth;
use App\Imports\StocksImport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Toastr;
use Toastr;


class StockController extends Controller
{
    //Upload
    public function upload(Request $request)
    {
        $request->validate([
            'stockFile' => 'required|mimes:xls,xlsx,csv'
        ]);
    
        // Store the uploaded file and get its path
        $path = $request->file('stockFile')->store('temp');
    
        // Import data from the Excel file
        try {

            Excel::import(new StocksImport, storage_path('app').'/'.$path);
            //return back()->with('success', 'Excel file imported successfully.');

        } catch (\Exception $e) {

            // Handle any exceptions that occur during the import process

            return back()->with('error', 'Error importing Excel file: '.$e->getMessage());
            
        }
    }

    //Search
    public function search(Request $request)
    {
        $stocks = Stock::query();

        if(!empty($request->tin))
        {
            $stocks = $stocks->where('tin', '=', $request->tin);
        }    
        
        if(!empty($request->name))
        {
            $stocks = $stocks->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($request->name) . '%']);
        }     
        
        if(!empty($request->type))
        {
            $stocks = $stocks->where('type', '=', $request->type);
        }  

        if (isset($request->file_in_stock) || $request->file_in_stock === '0') 
        {
            $stocks = $stocks->where('file_in_stock', '=', $request->file_in_stock);
        }

        if(!empty($request->circle))
        {
            $stocks = $stocks->where('circle', '=', $request->circle);
        }  
        
        $stocks = $stocks->paginate(100);

        return view('commissioner.stock.index',[
            'stocks' => $stocks,
            'search' => $request
        ]);
    }

    public function circleSearch(Request $request)
    {        
        $stocks = Stock::query();

        if(!empty($request->tin))
        {
            $stocks = $stocks->where('tin', '=', $request->tin);
        }    
        
        if(!empty($request->name))
        {
            $stocks = $stocks->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($request->name) . '%']);
        }     
        
        if ( isset($request->file_has)  ) 
        {
            if( $request->file_has == 1 )
            {
                $stocks = $stocks->where('file_in_stock', '=', 1);
            }
            else
            {
                $stocks = $stocks->where('file_in_stock', '=', 0);
            }
           
        }
        
        $stocks = $stocks->paginate(1);

        return view('circle.stock.index',[
            'stocks' => $stocks,
            'search' => $request
        ]);
    }


    //Commissioner Index
    public function commissionerIndex()
    {
        $stocks = Stock::latest()->paginate(100);

        return view('commissioner.stock.index', compact('stocks'));
    }

    //Circle Index
    //Upload
    public function upload(Request $request)
    {
        $request->validate([
            'stockFile' => 'required|mimes:xls,xlsx,csv'
        ]);
    
        // Store the uploaded file and get its path
        $path = $request->file('stockFile')->store('temp');
    
        // Import data from the Excel file
        try {

            Excel::import(new StocksImport, storage_path('app').'/'.$path);
            //return back()->with('success', 'Excel file imported successfully.');

        } catch (\Exception $e) {

            // Handle any exceptions that occur during the import process

            return back()->with('error', 'Error importing Excel file: '.$e->getMessage());
            
        }
    }

    //Search
    public function search(Request $request)
    {
        $stocks = Stock::query();

        if(!empty($request->tin))
        {
            $stocks = $stocks->where('tin', '=', $request->tin);
        }    
        
        if(!empty($request->name))
        {
            $stocks = $stocks->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($request->name) . '%']);
        }     
        
        if(!empty($request->type))
        {
            $stocks = $stocks->where('type', '=', $request->type);
        }  

        if (isset($request->file_in_stock) || $request->file_in_stock === '0') 
        {
            $stocks = $stocks->where('file_in_stock', '=', $request->file_in_stock);
        }

        if(!empty($request->circle))
        {
            $stocks = $stocks->where('circle', '=', $request->circle);
        }  
        
        $stocks = $stocks->paginate(100);

        return view('commissioner.stock.index',[
            'stocks' => $stocks,
            'search' => $request
        ]);
    }


    //Commissioner Index
    public function commissionerIndex()
    {
        $stocks = Stock::latest()->paginate(100);

        return view('commissioner.stock.index', compact('stocks'));
    }

    //Circle Index
    public function index(){

        $Stocks = Stock::latest()->where('circle', Auth::user()->circle)->paginate(500);

        return view('circle.stock.index', compact('stocks'));
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

    //Delete
    public function destroy($id)
    {
        // Find the stock by ID
        $stock = Stock::findOrFail($id);

        // Delete the stock
        $stock->delete();

        // Redirect back with success message
        Toastr::success('TIN Delete Successfull', 'success');
        return redirect()->back();
    }
}
