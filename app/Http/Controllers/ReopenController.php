<?php

namespace App\Http\Controllers;

use App\Models\Reopen;
use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Collection;
use Illuminate\Support\Facades\Auth;
use App\Helpers\MyHelper;
use Carbon\Carbon;
use PDF;
use Toastr;

class ReopenController extends Controller
{

    public function register(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'assessment_year' => 'required|integer|digits:8',
        ]);

        //Get Date Range For Assessment Year
        $startDate =  '01-07-' . substr($request->assessment_year,0,4);
        $endDate =  '30-06-' . substr($request->assessment_year,4,8);        
        $startDate= Carbon::createFromFormat('d-m-Y', $startDate)->toDateString();
        $endDate= Carbon::createFromFormat('d-m-Y', $endDate)->toDateString();

        $reopens = Reopen::whereBetween('reopen_date', [$startDate, $endDate])
        ->orderby('reopen_date', 'ASC')
        ->orderby('tin')
        ->get();

        return view('circle.reopen.register', [
            'reopens' => $reopens,
            'title' => 'Reopen Register',
            'circle' => Auth::user()->circle,
        ]);
        
       
    }

    public function search(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'tin' => 'nullable|digits:12',
            'assessment_year' => 'nullable|integer|digits:8',
            'expire_date' => 'nullable|date',
            'disposal' => 'nullable|boolean',
        ]);
    
        // Start query builder
        $query = Reopen::query();
    
        // Filter by TIN
        if ($request->has('tin') && !empty($request->tin)) {
            $query->where('tin', $request->tin);
        }
    
        // Filter by Assessment Year
        if ($request->has('assessment_year') && !empty($request->assessment_year)) {
            $query->where('assessment_year', $request->assessment_year);
        }
    
          // Filter by Expire Date using Carbon
        if ($request->has('expire_date') && !empty($request->expire_date)) {
            $expireDate = Carbon::createFromFormat('d-m-Y', $request->expire_date)->toDateString();
            $query->whereDate('expire_date', $expireDate);
        }
    
        // Filter by Disposed status
        if ($request->has('disposal')) {
            if ($request->disposal == '1') { // Yes
                $query->whereNotNull('disposal_date');
            } elseif ($request->disposal == '0') { // No
                $query->whereNull('disposal_date');
            }
        }
    
        // Get the results
        $reopens = $query->paginate(100)->appends($request->except('page'));
    
        // Return view with the results
        return view('circle.reopen.index', [
            'reopens' => $reopens,
            'title' => 'Reopen Search',
            'circle' => Auth::user()->circle,
        ]);
    }
    
    // Show all reopens
    public function index()
    {
        $reopens = Reopen::where('circle', Auth::user()->circle)->latest()->paginate(100);
        return view('circle.reopen.index', [
            'reopens' => $reopens,
            'title' => 'Reopen',
            'circle' => Auth::user()->circle,
        ]);
    }

    // Show form for creating a new reopen
    public function create()
    {
        return view('circle.reopen.create');
    }

    // Store a newly created reopen in storage
    public function store(Request $request)
    {
        // Validate incoming request data
        $request->validate([
            'tin' => 'required|digits:12',
            'assessment_year' => 'required|integer|digits:8',
            'reopen_date' => 'required|date',
            'main_income' => 'required|numeric',
            'main_tax' => 'required|numeric',
            'expire_date' => 'required|date',
            'disposal_date' => 'nullable|date',
            'assessed_income' => 'nullable|numeric',
            'demand' => 'nullable|numeric',
        ]);

         //check the tin is exist in stock table

         $stock = Stock::where('tin', $request->tin)->first();

         if(!$stock){ 
             Toastr::error('There is no stock for this TIN', 'danger'); 
             return back(); 
         }

       
         //Check the file is already added
         $reopen = Reopen::where('tin', $request->tin)
        ->where('assessment_year', $request->assessment_year)
        ->where('reopen_date', Carbon::createFromFormat('d-m-Y', $request->reopen_date)->toDateString()) 
        ->first();


         if($reopen){
 
             Toastr::error('There is already Reopen for this TIN and Assessment Year', 'danger');
 
             return back();
 
         }
        // Handle disposal_date, which can be null
        $expire_date = $request->expire_date ? Carbon::createFromFormat('d-m-Y', $request->expire_date)->toDateString() : null;
        $disposalDate = $request->disposal_date ? Carbon::createFromFormat('d-m-Y', $request->disposal_date)->toDateString() : null;

        // Create a new Reopen record
        Reopen::create([
            'tin' => $request->tin,
            'assessment_year' => $request->assessment_year,
            'reopen_date' => Carbon::createFromFormat('d-m-Y', $request->reopen_date)->toDateString(),
            'main_income' => $request->main_income,
            'main_tax' => $request->main_tax,
            'expire_date' => $expire_date,
            'disposal_date' => $disposalDate,
            'assessed_income' => $request->assessed_income,
            'demand' => $request->demand,
            'circle' => Auth::user()->circle,
        ]);

        // Redirect back with a success message
        Toastr::success('Reopen Added Successfully', 'Success');
        return redirect()->route('circle.reopen.index')->with('success', 'Reopen record created successfully.');
    }


    // Show form for editing the specified reopen
    public function edit(Reopen $reopen)
    {
        
        return view('circle.reopen.edit', compact('reopen'));
    }

    // Update the specified reopen in storage
    public function update(Request $request, Reopen $reopen)
    {
        // Validate incoming request data
        $request->validate([
            'assessment_year' => 'required|integer|digits:8',
            'reopen_date' => 'required|date',
            'main_income' => 'required|numeric',
            'main_tax' => 'required|numeric',
            'expire_date' => 'required|date',
            'disposal_date' => 'nullable|date',
            'assessed_income' => 'nullable|numeric',
            'demand' => 'nullable|numeric',
        ]);

        // Check if the reopen entry with same tin, assessment_year, and reopen_date already exists (excluding the current record)
        $existingReopen = Reopen::where('tin', $reopen->tin)
            ->where('id', '!=', $reopen->id)
            ->where('assessment_year', $request->assessment_year)
            ->where('reopen_date', Carbon::createFromFormat('d-m-Y', $request->reopen_date)->toDateString())
            ->first();

        if ($existingReopen) {
            Toastr::error('There is already a Reopen entry for this TIN and Assessment Year.', 'danger');
            return back();
        }

        // Update the Reopen record with new data
        $reopen->update([
            'assessment_year' => $request->assessment_year,
            'reopen_date' => Carbon::createFromFormat('d-m-Y', $request->reopen_date)->toDateString(),
            'main_income' => $request->main_income,
            'main_tax' => $request->main_tax,
            'expire_date' => Carbon::createFromFormat('d-m-Y', $request->expire_date)->toDateString(),
            'disposal_date' => $request->disposal_date ? Carbon::createFromFormat('d-m-Y', $request->disposal_date)->toDateString() : null,
            'assessed_income' => $request->assessed_income,
            'demand' => $request->demand,
        ]);

        // Redirect back with a success message
        Toastr::success('Reopen Updated Successfully', 'Success');
        return redirect()->route('circle.reopen.index')->with('success', 'Reopen record updated successfully.');
    }



    // Remove the specified reopen from storage
    public function destroy(Reopen $reopen)
    {
        $reopen->delete();
        return redirect()->route('reopens.index')->with('success', 'Reopen deleted successfully.');
    }
}

