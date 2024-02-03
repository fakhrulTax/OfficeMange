<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\ForwardDairy;
use PDF;

class NoticeController extends Controller
{ 
    public function index($tin)
    {
        $stock = Stock::where('tin',$tin)->firstOrFail();
    	return view('pages.Notice.index',['title' => 'Notice|Create a Notice', 'stock' => $stock]);
    }
    //Envelop
    public function envelop($tin)
    {   $stock =  Stock::where('tin',$tin)->first();
        $pdf = PDF::loadView('pages.Notice.envelop', ['stock' => $stock]);
        return $pdf->stream('document.pdf'); 
    }
    
    //214 Demand
    public function notice214(Request $request, $tin)
    {
        //Validation
        $request->validate([
            'assessment_year' => 'required',
            'issue_date' => 'required',
            'hearing_date' => 'required',
            'tax' => 'required|numeric',
        ]);
        
        //Total
        $total = $request->tax + $request->surcharge + $request->interest + $request->fine;
        $totalInWord = num2bangla($total);
        //Number With Comma
        $total = moneyFormatBD($total);
        $request->tax = moneyFormatBD($request->tax);
        $request->fine = moneyFormatBD($request->fine);
        $request->interest = moneyFormatBD($request->interest);
        //Get Stock Information
        $stock = Stock::where('tin',$tin)->firstOrFail();
        //Add or create Task in Forward Dairy
        $notice = 'Demand';
        $description = '<p>'.$stock->tin.'<p><p>'.$stock->name.'<p>';
        $deadline = date('Y-m-d',strtotime($request->hearing_date));
        ForwardDairy::addOrUpdateTaskFromNotice($notice, $description, $deadline);

        //Convert Numeric Digit English To Bangla 
        $total = en2bn($total);
        $request->tax = en2bn($request->tax);
        $request->surcharge = en2bn($request->surcharge);
        $request->interest = en2bn($request->interest);
        $request->fine = en2bn($request->fine);
        $request->assessment_year = en2bn($request->assessment_year);
        $request->issue_date = en2bn(date('d-m-Y',strtotime($request->issue_date)));
        $request->hearing_date = en2bn(date('d-m-Y',strtotime($request->hearing_date)));
        $stock->tin = en2bn(tinSlice($stock->tin));       
        
         $pdf = PDF::loadView('pages.Notice.two_fourteen', ['stock' => $stock, 'data' => $request, 'total' => $total, 'totalInWord' => $totalInWord
     ]);
         return $pdf->stream('document.pdf');                
    }
   
     //183
     public function newRefix(Request $request, $tin)
     {
         //Validation
         $request->validate([
             'assessment_year' => 'required',
             'issue_date' => 'required',
             'hearing_date' => 'required',
         ]);
         //Get Stock Information
         $stock = Stock::where('tin',$tin)->firstOrFail();
         
        //Add or create Task in Forward Dairy
        $notice = 'Refix';
        $description = '<p>'.$stock->tin.'<p><p>'.$stock->name.'<p>';
        $deadline = date('Y-m-d',strtotime($request->hearing_date));
        ForwardDairy::addOrUpdateTaskFromNotice($notice, $description, $deadline);
                 
         //Convert Numeric Digit English To Bangla
         $request->assessment_year = en2bn($request->assessment_year);
         $request->issue_date = en2bn(date('d-m-Y',strtotime($request->issue_date)));
         $request->hearing_date = en2bn(date('d-m-Y',strtotime($request->hearing_date)));
         $stock->tin = en2bn(tinSlice($stock->tin));
         
         $pdf = PDF::loadView('pages.Notice.new_refix', ['stock' => $stock, 'data' => $request]);
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
        ]);
        //Get Stock Information
        $stock = Stock::where('tin',$tin)->firstOrFail();

        //Add or create Task in Forward Dairy
        $notice = '280';
        $description = '<p>'.$stock->tin.'<p><p>'.$stock->name.'<p>';
        $deadline = date('Y-m-d',strtotime($request->hearing_date));
        ForwardDairy::addOrUpdateTaskFromNotice($notice, $description, $deadline);

        //Convert Numeric Digit English To Bangla
        $request->assessment_year = en2bn($request->assessment_year);
        $request->issue_date = en2bn(date('d-m-Y',strtotime($request->issue_date)));
        $request->hearing_date = en2bn(date('d-m-Y',strtotime($request->hearing_date)));
        $stock->tin = en2bn(tinSlice($stock->tin));
        
        $pdf = PDF::loadView('pages.Notice.two_eighty', ['stock' => $stock, 'data' => $request]);
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

        if( $stock->mobile_number )
        {
            api('আপনার নিকট ১৮৩(৩) ধারার একটি নোটিশ প্রেরণ করা হয়েছে। শুনানি '. $request->hearing_date . 'খ্রি.।'. config('settings.circle_name_'.Auth::user()->circle));
        }

        
        
        //Add or create Task in Forward Dairy
        $notice = '183(3)';
        $description = '<p>'.$stock->tin.'<p><p>'.$stock->name.'<p>';
        $deadline = date('Y-m-d',strtotime($request->hearing_date));

        //Add Forward Dairy
        //ForwardDairy::addOrUpdateTaskFromNotice($notice, $description, $deadline);

      
        //Convert Numeric Digit English To Bangla
        $request->assessment_year = en2bn($request->assessment_year);
        $request->issue_date = en2bn(date('d-m-Y',strtotime($request->issue_date)));
        $request->hearing_date = en2bn(date('d-m-Y',strtotime($request->hearing_date)));
        $stock->tin = en2bn(tinSlice($stock->tin));       

        $pdf = PDF::loadView('pages.Notice.one_eighty_three', ['stock' => $stock, 'data' => $request]);
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

        //Add or create Task in Forward Dairy
        $notice = '179';
        $description = '<p>'.$stock->tin.'<p><p>'.$stock->name.'<p>';
        $deadline = date('Y-m-d',strtotime($request->hearing_date));
        ForwardDairy::addOrUpdateTaskFromNotice($notice, $description, $deadline);

        //Convert Numeric Digit English To Bangla
        $request->assessment_year = en2bn($request->assessment_year);
        $request->issue_date = en2bn(date('d-m-Y',strtotime($request->issue_date)));
        $request->hearing_date = en2bn(date('d-m-Y',strtotime($request->hearing_date)));
        $stock->tin = en2bn(tinSlice($stock->tin));
              
        $pdf = PDF::loadView('pages.Notice.one_seventy_nine', ['stock' => $stock, 'data' => $request]);
        return $pdf->stream('document.pdf');                
    }
    
    //79 Notice Controllsr
    public function notice79(Request $request, $tin)
    {
        //Validation
        $request->validate([
            'assessment_year' => 'required',
            'issue_date' => 'required',
            'hearing_date' => 'required',
        ]);
        //Get Stock Information
        $stock = Stock::where('tin',$tin)->firstOrFail();
        //Convert Numeric Digit English To Bangla
        $request->assessment_year = en2bn($request->assessment_year);
        $request->issue_date = en2bn(date('d-m-Y',strtotime($request->issue_date)));
        $request->hearing_date = en2bn(date('d-m-Y',strtotime($request->hearing_date)));
        $stock->tin = en2bn(tinSlice($stock->tin));
        
        $pdf = PDF::loadView('pages.Notice.seventy_nine', ['stock' => $stock, 'data' => $request]);
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
            
        $pdf = PDF::loadView('pages.Notice.defaultOrderSheet', ['stock' => $stock, 'data' => $request]);
        return $pdf->stream('document.pdf');   
    }
    //83 Notice Controllsr
    public function notice83(Request $request, $tin)
    {
        //Validation
        $request->validate([
            'assessment_year' => 'required',
            'issue_date' => 'required',
            'hearing_date' => 'required',
        ]);
        //Get Stock Information
        $stock = Stock::where('tin',$tin)->firstOrFail();
        //Convert Numeric Digit English To Bangla
        $request->assessment_year = en2bn($request->assessment_year);
        $request->issue_date = en2bn(date('d-m-Y',strtotime($request->issue_date)));
        $request->hearing_date = en2bn(date('d-m-Y',strtotime($request->hearing_date)));
        $stock->tin = en2bn(tinSlice($stock->tin));
        
        $pdf = PDF::loadView('pages.Notice.eighty_three', ['stock' => $stock, 'data' => $request]);
        return $pdf->stream('document.pdf');                
    }
    //93 Notice Controllsr
    public function notice93(Request $request, $tin)
    {
        //Validation
        $request->validate([
            'assessment_year' => 'required',
            'issue_date' => 'required',
            'hearing_date' => 'required',
        ]);
        //Get Stock Information
        $stock = Stock::where('tin',$tin)->firstOrFail();
        //Convert Numeric Digit English To Bangla
        $request->assessment_year = en2bn($request->assessment_year);
        $request->issue_date = en2bn(date('d-m-Y',strtotime($request->issue_date)));
        $request->hearing_date = en2bn(date('d-m-Y',strtotime($request->hearing_date)));
        $stock->tin = en2bn(tinSlice($stock->tin));
        
        $pdf = PDF::loadView('pages.Notice.ninety_three', ['stock' => $stock, 'data' => $request]);
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
        ]);
        //Get Stock Information
        $stock = Stock::where('tin',$tin)->firstOrFail();
        
        //Add or create Task in Forward Dairy
        $notice = '212';
        $description = '<p>'.$stock->tin.'<p><p>'.$stock->name.'<p>';
        $deadline = date('Y-m-d',strtotime($request->hearing_date));
        ForwardDairy::addOrUpdateTaskFromNotice($notice, $description, $deadline);

        //Convert Numeric Digit English To Bangla
        $request->assessment_year = en2bn($request->assessment_year);
        $request->issue_date = en2bn(date('d-m-Y',strtotime($request->issue_date)));
        $request->hearing_date = en2bn(date('d-m-Y',strtotime($request->hearing_date)));
        $stock->tin = en2bn(tinSlice($stock->tin));
        
        $pdf = PDF::loadView('pages.Notice.two_twelve', ['stock' => $stock, 'data' => $request]);
        return $pdf->stream('document.pdf');                
    }
    //130 Notice Controllsr
    public function notice130(Request $request, $tin)
    {
        //Validation
        $request->validate([
            'assessment_year' => 'required',
            'issue_date' => 'required',
            'hearing_date' => 'required',
        ]);
        //Get Stock Information
        $stock = Stock::where('tin',$tin)->firstOrFail();
        //Convert Numeric Digit English To Bangla
        $request->assessment_year = en2bn($request->assessment_year);
        $request->issue_date = en2bn(date('d-m-Y',strtotime($request->issue_date)));
        $request->hearing_date = en2bn(date('d-m-Y',strtotime($request->hearing_date)));
        $stock->tin = en2bn(tinSlice($stock->tin));
        
        $pdf = PDF::loadView('pages.Notice.one_thirty', ['stock' => $stock, 'data' => $request]);
        return $pdf->stream('document.pdf');                
    }
    //Refix Notice Controllsr
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
        //Convert Numeric Digit English To Bangla
        $request->assessment_year = en2bn($request->assessment_year);
        $request->issue_date = en2bn(date('d-m-Y',strtotime($request->issue_date)));
        $request->hearing_date = en2bn(date('d-m-Y',strtotime($request->hearing_date)));
        $stock->tin = en2bn(tinSlice($stock->tin));
        
        $pdf = PDF::loadView('pages.Notice.refix', ['stock' => $stock, 'data' => $request]);
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
    //Demand
    public function demand(Request $request, $tin)
    {
        //Validation
        $request->validate([
            'assessment_year' => 'required',
            'issue_date' => 'required',
            'hearing_date' => 'required',
            'tax' => 'required',
            'class' => 'required',
        ]);
        //Total
        $total = $request->tax + $request->fine + $request->interest+ $request->others;
        $totalInWord = num2bangla($total);
        //Number With Comma
        $total = moneyFormatBD($total);
        $request->tax = moneyFormatBD($request->tax);
        $request->fine = moneyFormatBD($request->fine);
        $request->interest = moneyFormatBD($request->interest);
        $request->others = moneyFormatBD($request->others);
        //Get Stock Information
        $stock = Stock::where('tin',$tin)->firstOrFail();
        //Convert Numeric Digit English To Bangla 
        $total = en2bn($total);
        $request->tax = en2bn($request->tax);
        $request->fine = en2bn($request->fine);
        $request->interest = en2bn($request->interest);
        $request->others = en2bn($request->others);
        $request->assessment_year = en2bn($request->assessment_year);
        $request->issue_date = en2bn(date('d-m-Y',strtotime($request->issue_date)));
        $request->hearing_date = en2bn(date('d-m-Y',strtotime($request->hearing_date)));
        $stock->tin = en2bn(tinSlice($stock->tin));        
        
         $pdf = PDF::loadView('pages.Notice.demand', ['stock' => $stock, 'data' => $request, 'total' => $total, 'totalInWord' => $totalInWord]);
         return $pdf->stream('document.pdf');                
    }
    //Demand
    public function newDemand(Request $request, $tin)
    {
        //Validation
        $request->validate([
            'assessment_year' => 'required',
            'issue_date' => 'required',
            'hearing_date' => 'required',
            'tax' => 'required|numeric',
            'class' => 'required',
        ]);
        //Total
        $total = $request->tax + $request->surcharge + $request->interest + $request->lateInterest + $request->fine + $request->others;
        $totalInWord = num2bangla($total);
        //Number With Comma
        $total = moneyFormatBD($total);
        $request->tax = moneyFormatBD($request->tax);
        $request->fine = moneyFormatBD($request->fine);
        $request->interest = moneyFormatBD($request->interest);
        $request->others = moneyFormatBD($request->others);
        //Get Stock Information
        $stock = Stock::where('tin',$tin)->firstOrFail();
        //Convert Numeric Digit English To Bangla 
        $total = en2bn($total);
        $request->tax = en2bn($request->tax);
        $request->surcharge = en2bn($request->surcharge);
        $request->interest = en2bn($request->interest);
        $request->lateInterest = en2bn($request->lateInterest);
        $request->fine = en2bn($request->fine);
        $request->others = en2bn($request->others);
        $request->assessment_year = en2bn($request->assessment_year);
        $request->issue_date = en2bn(date('d-m-Y',strtotime($request->issue_date)));
        $request->hearing_date = en2bn(date('d-m-Y',strtotime($request->hearing_date)));
        $stock->tin = en2bn(tinSlice($stock->tin));       
        
         $pdf = PDF::loadView('pages.Notice.newdemand', ['stock' => $stock, 'data' => $request, 'total' => $total, 'totalInWord' => $totalInWord
     ]);
         return $pdf->stream('document.pdf');                
    }
}
