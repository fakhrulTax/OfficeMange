<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Arrear;
use PDF;
use App\Helpers\MyHelper;
use Illuminate\Support\Facades\Auth;
use Toastr;

class NoticeController extends Controller
{ 

    //Order Sheet
    public function orderSheet(Request $request, $tin)
    { 
        dd('working');
        //Validation
        $request->validate([
            'type' => 'required',
            'assessment_year' => 'required',
            'issue_date' => 'required',
            'hearing_date' => 'required',
        ]);       

        //Get Stock Information
        $stock = Stock::where('tin',$tin)->firstOrFail();

        $pdf = PDF::loadView('circle.notice.order_sheet', ['stock' => $stock, 'data' => $request, 'Helper' => new MyHelper()]);
        return $pdf->stream('document.pdf');                
    }
    

    //183
    public function notice183(Request $request, $tin)
    { 
        //Validation
        $request->validate([
            'assessment_year' => 'required',
            'issue_date' => 'required',
            'hearing_date' => 'required',
        ]);       

        //Get Stock Information
        $stock = Stock::where('tin',$tin)->firstOrFail();

        $pdf = PDF::loadView('circle.notice.one_eighty_three', ['stock' => $stock, 'data' => $request, 'Helper' => new MyHelper()]);
        return $pdf->stream('document.pdf');                
    }

    //179
    public function notice179(Request $request, $tin)
    { 
        //Validation
        $request->validate([
            'assessment_year' => 'required',
            'issue_date' => 'required',
            'hearing_date' => 'required',
        ]);       

        //Get Stock Information
        $stock = Stock::where('tin',$tin)->firstOrFail();

        $pdf = PDF::loadView('circle.notice.one_seventy_nine', ['stock' => $stock, 'data' => $request, 'Helper' => new MyHelper()]);
        return $pdf->stream('document.pdf');                
    }

       //212 Notice Controllsr
       public function notice212(Request $request, $tin)
       {
           //Validation
           $request->validate([
               'assessment_year' => 'required',
               'issue_date' => 'required',
               'hearing_date' => 'required',
               'cause' => 'required'
           ]);

           //Get Stock Information
           $stock = Stock::where('tin',$tin)->firstOrFail();
           
           $pdf = PDF::loadView('circle.notice.two_twelve', ['stock' => $stock, 'data' => $request, 'Helper' => new MyHelper(), ]);
           return $pdf->stream('document.pdf');                
       }

       
       //Refix
       public function refix(Request $request, $tin)
       {
           //Validation
           $request->validate([
               'assessment_year' => 'required',
               'issue_date' => 'required',
               'hearing_date' => 'required',
           ]);

           //Get Stock Information
           $stock = Stock::where('tin',$tin)->firstOrFail();
           $circle = Auth::user()->circle;
           
           $pdf = PDF::loadView('circle.notice.refix', ['stock' => $stock, 'data' => $request, 'Helper' => new MyHelper(), 'circle' => $circle]);
           return $pdf->stream('document.pdf');                
       }

       
    //280
    public function notice280(Request $request, $tin)
    {
        //Validation
        $request->validate([
            'assessment_year' => 'required',
            'issue_date' => 'required',
            'hearing_date' => 'required',
            'notice_section' => 'required',
            'fine_section' => 'required'
        ]);

        //Get Stock Information
        $stock = Stock::where('tin',$tin)->firstOrFail();
        
        $pdf = PDF::loadView('circle.notice.two_eighty', ['stock' => $stock, 'data' => $request, 'Helper' => new MyHelper(), ]);
        return $pdf->stream('document.pdf');                
    }

    //IT57
    public function notice57(Request $request, $tin)
    {
        //Validation
        $request->validate([
            'assessment_year' => 'required',
            'issue_date' => 'required',
            'notice_section' => 'required',
        ]);

        //Get Stock Information
        $stock = Stock::where('tin',$tin)->firstOrFail();
        $circle = Auth::user()->circle;
        
        $pdf = PDF::loadView('circle.notice.fifty_seven', ['stock' => $stock, 'data' => $request, 'circle' => $circle, 'Helper' => new MyHelper(), ]);
        return $pdf->stream('document.pdf');                
    }

      //214 Demand
      public function demand(Request $request, $tin)
      {

          //Validation
          $request->validate([
              'assessment_year' => 'required',
              'issue_date' => 'required',
              'hearing_date' => 'required',
              'tax' => 'required|numeric',
              'surcharge' => 'required|numeric',
              'interest' => 'required|numeric',
              'fine' => 'required|numeric',
          ]);
          
          //Total
          $total = $request->tax + $request->surcharge + $request->interest + $request->fine;
        
          //Add Arrear if new
          $arrear = Arrear::where('tin', $tin)->where('assessment_year', $request->assessment_year)
                            ->where('circle', Auth::user()->circle)->first();
          if( $arrear )
          {
            Toastr::error('This Tax Payer has Arrear For Same Ass. Year. Update Arrear Manualy..', 'danger');  
          }else
          {
            //Create Arrer

                Arrear::create([
                    'arrear_type' => 'undisputed',
                    'tin' => $tin,
                    'demand_create_date' => date('Y-m-d', strtotime($request->issue_date)),
                    'assessment_year' => $request->assessment_year,
                    'arrear' => $total,
                    'circle' => Auth::user()->circle,
                    'fine' => 0,
                ]);
                Toastr::success('Arrear Added Successfuly.', 'success');  
          }          

          //Get Stock Information
          $stock = Stock::where('tin',$tin)->firstOrFail(); 
          
           $pdf = PDF::loadView('circle.notice.demand', [
                    'stock' => $stock, 
                    'data' => $request, 
                    'Helper' => new MyHelper(),
                    'total' => $total
            ]);
           return $pdf->stream('document.pdf');                
      }









    //93-130 OrderSheet
    public function ordersheet93(Request $request, $tin)
    {
        //Validation
        $request->validate([
            'assessment_year' => 'required',
            'issue_date' => 'required',
            'hearing_date' => 'required',
        ]);
        //Get Stock Information
        $stock = Stock::where('tin',$tin)->firstOrFail();
            
        $pdf = PDF::loadView('circle.notice.fifty_seven', ['stock' => $stock, 'data' => $request]);
        return $pdf->stream('document.pdf');   
    }

    
     
    //Letter Address
    public function letter($tin)
    {
        //Get Stock Information
        $stock = Stock::where('tin',$tin)->firstOrFail();
        //Convert Numeric Digit English To Bangla
        $stock->tin = en2bn(tinSlice($stock->tin));
        $pdf = new PDF(['orientation' => 'L']);
        $pdf = PDF::loadView('pages.Notice.letter', ['stock' => $stock]);
        return $pdf->stream('document.pdf');                
    }
 
}
