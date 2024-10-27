<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Collection;
use Illuminate\Support\Facades\Auth;
use App\Helpers\MyHelper;
use Carbon\Carbon;
use PDF;
use Toastr;

class AuditController extends Controller
{

    public function register(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'assessment_year' => 'required|integer|digits:8',
        ]);

        
        $audits = Audit::where('assessment_year', $request->assessment_year)
        ->orderby('audit_date', 'ASC')
        ->orderby('tin')
        ->get();

        return view('circle.audit.register', [
            'audits' => $audits,
            'title' => 'Audit Register',
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
        $query = Audit::query();
    
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

        //Only Auth User Circle
        $query->where('circle', Auth::user()->circle);
    
        // Get the results
        $audits = $query->paginate(100)->appends($request->except('page'));
    
        // Return view with the results
        return view('circle.audit.index', [
            'audits' => $audits,
            'title' => 'Audit Search',
            'circle' => Auth::user()->circle,
        ]);
    }
    
    // Show all Audits
    public function index()
    {
        $audits = Audit::where('circle', Auth::user()->circle)->latest()->paginate(100);
        return view('circle.audit.index', [
            'audits' => $audits,
            'title' => 'Audit',
            'circle' => Auth::user()->circle,
        ]);
    }

    // Show form for creating a new Audit
    public function create()
    {
        return view('circle.audit.create');
    }

    // Store a newly created Audit in storage
    public function store(Request $request)
    {
        // Validate incoming request data
        $request->validate([
            'tin' => 'required|digits:12',
            'assessment_year' => 'required|integer|digits:8',
            'audit_date' => 'required|date',
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
         $audit = Audit::where('tin', $request->tin)
        ->where('assessment_year', $request->assessment_year) 
        ->first();


         if($audit){
 
             Toastr::error('There is already Audit for this TIN and Assessment Year', 'danger');
 
             return back();
 
         }
        // Handle disposal_date, which can be null
        $expire_date = $request->expire_date ? Carbon::createFromFormat('d-m-Y', $request->expire_date)->toDateString() : null;
        $disposalDate = $request->disposal_date ? Carbon::createFromFormat('d-m-Y', $request->disposal_date)->toDateString() : null;

        // Create a new Audit record
        Audit::create([
            'tin' => $request->tin,
            'assessment_year' => $request->assessment_year,
            'audit_date' => Carbon::createFromFormat('d-m-Y', $request->audit_date)->toDateString(),
            'main_income' => $request->main_income,
            'main_tax' => $request->main_tax,
            'expire_date' => $expire_date,
            'disposal_date' => $disposalDate,
            'assessed_income' => $request->assessed_income,
            'demand' => $request->demand,
            'circle' => Auth::user()->circle,
        ]);

        // Redirect back with a success message
        Toastr::success('Audit Added Successfully', 'Success');
        return redirect()->route('circle.audit.index')->with('success', 'Audit record created successfully.');
    }


    // Show form for editing the specified Audit
    public function edit(Audit $audit)
    {
        
        return view('circle.audit.edit', compact('audit'));
    }

    // Update the specified Audit in storage
    public function update(Request $request, Audit $audit)
    {
        // Validate incoming request data
        $request->validate([
            'assessment_year' => 'required|integer|digits:8',
            'audit_date' => 'required|date',
            'main_income' => 'required|numeric',
            'main_tax' => 'required|numeric',
            'expire_date' => 'required|date',
            'disposal_date' => 'nullable|date',
            'assessed_income' => 'nullable|numeric',
            'demand' => 'nullable|numeric',
        ]);

        // Check if the Audit entry with same tin, assessment_year, and audit_date already exists (excluding the current record)
        $existingAudit = Audit::where('tin', $audit->tin)
            ->where('id', '!=', $audit->id)
            ->where('assessment_year', $request->assessment_year)
            ->first();

        if ($existingAudit) {
            Toastr::error('There is already a Audit entry for this TIN and Assessment Year.', 'danger');
            return back();
        }

        // Update the Audit record with new data
        $audit->update([
            'assessment_year' => $request->assessment_year,
            'audit_date' => Carbon::createFromFormat('d-m-Y', $request->audit_date)->toDateString(),
            'main_income' => $request->main_income,
            'main_tax' => $request->main_tax,
            'expire_date' => Carbon::createFromFormat('d-m-Y', $request->expire_date)->toDateString(),
            'disposal_date' => $request->disposal_date ? Carbon::createFromFormat('d-m-Y', $request->disposal_date)->toDateString() : null,
            'assessed_income' => $request->assessed_income,
            'demand' => $request->demand,
        ]);

        // Redirect back with a success message
        Toastr::success('Audit Updated Successfully', 'Success');
        return redirect()->route('circle.audit.index')->with('success', 'Audit record updated successfully.');
    }



    // Remove the specified Audit from storage
    // public function destroy(Audit $Audit)
    // {
    //     $Audit->delete();
    //     return redirect()->route('Audits.index')->with('success', 'Audit deleted successfully.');
    // }
}

