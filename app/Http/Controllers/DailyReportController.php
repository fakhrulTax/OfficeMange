<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DailyReport;
use Illuminate\Support\Facades\Auth;
use Toastr;
use Carbon\Carbon;
use App\Helpers\MyHelper;

class DailyReportController extends Controller
{
    private $types = [
        'Online File Transfer',
        'Express Certificate',
        'Offline Return Entry',
        'CIC Report',
        'Advance Tax',
        'Arrear Tax',
        'Bank Attachment',
        'AMMS-2',
        'PSR',
    ];

    public function search(Request $request)
    {
       
        if( Auth::user()->user_role == 'commissioner')
        {
            $circles =  range(1, 22);
           
        }elseif( Auth::user()->user_role == 'range')
        {
            
            $circles = MyHelper::ranges('range-'.Auth::user()->range);
           
        }else
        {
            $circles = [Auth::user()->circle];
        }

       
        $lastReports = [];

        // Validate issue_date format
        $request->validate([
            'issue_date' => 'nullable|date_format:d-m-Y',
        ]);
    
        // Check if issue_date is provided in the request
        if ($request->filled('issue_date')) {
            $issue_date = \Carbon\Carbon::createFromFormat('d-m-Y', $request->issue_date)->format('Y-m-d');
            
           

            foreach ($this->types as $type) {   

                $reports = DailyReport::whereIn('circle', [$request->circle] ? [$request->circle] : $circles)
                ->where('type', $type)
                ->where('issue_date', $issue_date)
                ->get();
    
                // Calculate sums
                $sumNumber = $reports->sum('number');
                $sumTotalNumber = $reports->sum('total_number');
                $sumCollection = $reports->sum('collection');
                $sumTotalCollection = $reports->sum('total_collection');
    
                // Create a dummy model to store the aggregated results
                $lastReports[$type] = new DailyReport([
                    'issue_date' => $issue_date,
                    'type' => $type,
                    'number' => $sumNumber,
                    'total_number' => $sumTotalNumber,
                    'collection' => $sumCollection,
                    'total_collection' => $sumTotalCollection,
                ]);
    
            }
            
            
        }

        
        return view('circle.dailyreport.index', [
            'types' => $this->types,
            'lastReports' => $lastReports,
            'Auth' => new Auth(),
            'circles' => $circles
        ]);
    }
    

    public function index()
    {
        if( Auth::user()->user_role == 'commissioner')
        {
            $circles = $circle = range(1, 22);
           
        }elseif( Auth::user()->user_role == 'range')
        {
            
            $circles = MyHelper::ranges('range-'.Auth::user()->range);
           
        }else
        {
            $circles = [Auth::user()->circle];
        }

        $lastReports = [];
        $issue_date = Carbon::today()->toDateString();      

        foreach ($this->types as $type) {   

            $reports = DailyReport::whereIn('circle', $circles)
            ->where('type', $type)
            ->where('issue_date', $issue_date)
            ->get();


            // Calculate sums
            $sumNumber = $reports->sum('number');
            $sumTotalNumber = $reports->sum('total_number');
            $sumCollection = $reports->sum('collection');
            $sumTotalCollection = $reports->sum('total_collection');

            // Create a dummy model to store the aggregated results
            $lastReports[$type] = new DailyReport([
                'issue_date' => $issue_date,
                'type' => $type,
                'number' => $sumNumber,
                'total_number' => $sumTotalNumber,
                'collection' => $sumCollection,
                'total_collection' => $sumTotalCollection,
            ]);

        }
      
       return view('circle.dailyreport.index', [
        'types' => $this->types,
        'lastReports' => $lastReports,
        'Auth' => new Auth(),
        'circles' => $circles
       ]);
    }

    public function create()
    {
        $lastReports = [];

        foreach ($this->types as $type) {
            $lastReports[$type] = DailyReport::where('circle', Auth::user()->circle)
                ->where('type', $type)
                ->latest()
                ->first(); // Get the latest report for each type
        }
      
       return view('circle.dailyreport.create', [
        'types' => $this->types,
        'lastReports' => $lastReports,
       ]);
    }

    // Store the report
    public function store(Request $request)
    {
        $request->validate([
            'issue_date' => 'required|date',
            'types.*.number' => 'required|integer|min:0',
            'types.*.total_number' => 'required|integer|min:0',
            'types.*.collection' => 'required|integer|min:0',
            'types.*.total_collection' => 'required|integer|min:0',
        ]);

        // Check if the report is already submitted
        $daily = DailyReport::where('circle', Auth::user()->circle)
        ->where('issue_date', Carbon::createFromFormat('d-m-Y', $request->issue_date)->toDateString())
        ->first();

        if ($daily) {
            Toastr::error('Report already submitted. You may edit the existing report.', 'Danger');
            return back(); 
        }


        foreach ($request->types as $typeIndex => $data) {
            DailyReport::create([
                'issue_date' => Carbon::createFromFormat('d-m-Y', $request->issue_date)->toDateString(),
                'type' => $this->types[$typeIndex], // Use the reusable property
                'number' => $data['number'],
                'total_number' => $data['total_number'],
                'collection' => $data['collection'],
                'total_collection' => $data['total_collection'],
                'circle' => Auth::user()->circle,
            ]);
        }

        Toastr::success('Audit Added Successfully', 'Success');
        return redirect()->route('circle.daily.index');
    }


}
