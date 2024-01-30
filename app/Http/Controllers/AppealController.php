<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appeal;
use App\Models\Arrear;
use Toastr;

class AppealController extends Controller
{
    public function index()
    {
        $appeals = Appeal::orderBy('appeal_disposal_date', 'DESC')
                        ->where('circle', Auth::user()->circle)
                        ->paginate(100);
                        
        return view('circle.appeal.index',[
            'title' => 'Appeal|All Appeal', 
            'appeals' => $appeals,
        ]);
    }

    public function create()
    {
        return view('circle.appeal.create',[
            'title' => 'Appeal | Create',
        ]);
    }

    
    public function store(Request $request)
    {        
       // Validation rules
        $request->validate([
            'type' => 'required',
            'tin' => 'required|digits:12',
            'appeal_order' => 'required|string',
            'appeal_order_date' => 'required|date_format:d-m-Y',
            'appeal_disposal_date' => 'required|date_format:d-m-Y',
            'assessment_year' => 'required|digits:8',
            'main_income' => 'required|numeric',
            'main_tax' => 'required|numeric',
            'revise_income' => 'required|numeric',
            'revise_tax' => 'required|numeric',
        ]);

        //Check Arrear
        $arrear = Arrear::checkArrear($request->tin, $request->assessment_year);
        if (!$arrear) {
            Toastr::error('There is no arrear for this TIN and Assessment Year', 'danger');
            return back()->withInput();
        }

        //Update Arrear
        if($request->arrear_type == 'tax')
        {
            Arrear::updateArrearStatusAmountOrFine($request->tin, $request->assessment_year, 'undisputed', $request->revise_tax, false);
        }else
        {
            Arrear::updateArrearStatusAmountOrFine($request->tin, $request->assessment_year, 'undisputed', false , $request->revise_tax);
        }

         // Create a new instance of the Appeal model
         $appeal = new Appeal();

         // Assign values from the form to the model
         $appeal->type = $request->type;
         $appeal->tin = $request->tin;
         $appeal->appeal_order = $request->appeal_order;
         $appeal->appeal_order_date = date('Y-m-d', strtotime($request->appeal_order_date));
         $appeal->appeal_disposal_date = date('Y-m-d', strtotime($request->appeal_disposal_date));
         $appeal->assessment_year = $request->assessment_year;
         $appeal->main_income = $request->main_income;
         $appeal->main_tax = $request->main_tax;
         $appeal->revise_income = $request->revise_income;
         $appeal->revise_tax = $request->revise_tax;
         $appeal->circle = Auth::user()->circle;
 
         // Save the model to the database
         $appeal->save();   
         Toastr::success( ucwords($request->type) . ' Added Successful', 'success');
        return redirect()->route('circle.appeal.index');     

    } 

    //Collection Edit
    public function edit($id)
    {
        return 'go';
    }

    //Collection Update
    public function update(Request $request){
        
        return 'go';   

    }


}
