<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Advance;
use App\Models\Stock;
use App\Models\Collection;
use Illuminate\Support\Facades\Auth;
use App\Helpers\MyHelper;
use PDF;
use Toastr;

class AdvanceController extends Controller
{

    public function advanceReport ()
    {
        $assessment_year = config('settings.assessment_year_commissioner') + 10001;

        if( Auth::user()->user_role == 'range' )
        {
            $circles = Myhelper::ranges( 'range-' . Auth::user()->range );
           
        }elseif(Auth::user()->user_role == 'commissioner')
        {
            $circles = [];
            for ($i = 1; $i <= 22; $i++) {
                $circles[] = $i;
            }
        }else
        {
            dd('You are not Authorized.');
        }

       
        $totalAdvanceTaxPayers = count(Advance::getAdvanceTaxPayersByCircle($circles, $assessment_year));
        $totalAdvanceTaxPaidTaxPayers = count(Collection::advanceTaxPaidTaxPayers($circles, $assessment_year));
        $totalAdvanceCollection = Collection::advanceCollectionByCircles($circles, $assessment_year);        
       
        return view('commissioner.advance.report', [
            'circles' => $circles,
            'assessment_year' => $assessment_year,
            'totalAdvanceTaxPayers' => $totalAdvanceTaxPayers, 
            'totalAdvanceCollection' => $totalAdvanceCollection,
            'totalAdvanceTaxPaidTaxPayers' => $totalAdvanceTaxPaidTaxPayers
        ]);
    }

    public function register()
    {
        $assessment_year = config('settings.assessment_year_'.Auth::user()->circle) + 10001;
        $advances = Advance::where('advance_assessment_year', $assessment_year)
                    ->where('circle', Auth::user()->circle)
                    ->get();

        $pdf = PDF::loadView('circle.notice.advanceRegister', [
            'advances' =>  $advances
        ]);
        return $pdf->stream('document.pdf'); 
    }

    public function notice(Request $request)
    {
        $request->validate([
            'advanceTIN' => 'required|digits:12',
            'noticeYear' => 'required|digits:8',
            'issue_date' => 'required',
        ]);

        $advance = Advance::where('tin',$request->advanceTIN)->where('advance_assessment_year', $request->noticeYear)->first();

        $pdf = PDF::loadView('circle.notice.advance', [
            'advance' => $advance,
            'noticePremimum' => $request->premimum,
            'issue_date' => $request->issue_date
        ]);
        return $pdf->stream('document.pdf'); 
    }
    

    public function advanceIndex(){

        $advances = Advance::orderBy('id', 'DESC')->where('circle', Auth::user()->circle)->paginate(100);

        if( Auth::user()->user_role == 'commissioner' )
        {
            $advances = Advance::orderBy('id', 'DESC')->paginate(100);
        }

        return view('circle.advance.index', [
            'title' => 'Advance Tax',
            'advances' => $advances
            ]);
    }


    public function create(){
        return view('circle.advance.create', [
            'title' => 'Advance | Create'

        ]);
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
        $advance->circle = Auth::user()->circle;
        $advance->save();

        Toastr::success('Advance Added Successfully', 'Success');

        return redirect()->route('circle.advance.index');


        
        
    }


    public function edit($id){
        $advance = Advance::find($id);
        return view('circle.advance.edit', [
            'title' => 'Edit Advance',    
            'advance' => $advance,
        ]);
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

        if( isset($request->circle) && !empty($request->circle)){

            
            if( $request->circle == "range-1" || $request->circle == "range-2" || $request->circle == "range-3" || $request->circle == "range-4" )
            {
                //search for range
                $circles = MyHelper::ranges($request->circle);
                $advances = $advances->whereIN('circle', $circles);
            }else
            {
                $advances = $advances->where('circle', $request->circle);
            }           
        }



        if(!empty($request->advance_assessment_year)){


            $advances = $advances->where('advance_assessment_year', $request->advance_assessment_year);
            
        }


        if( Auth::user()->user_role == 'circle' )
        {
            $advances = $advances->where('circle', Auth::user()->circle);
        }

        $advances = $advances->paginate(200);


       
        return view('circle.advance.index', [
            'advances' => $advances, 
            'title' => 'Advance | Search'
            ]);
    }



}
