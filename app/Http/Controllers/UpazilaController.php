<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Zilla;
use App\Models\Upazila;
use App\Models\Organization;
use Toastr;

class UpazilaController extends Controller
{
    public function index()
    {
        $zillas = Zilla::orderBy('name', 'ASC')->get();

        return view('commissioner.tds.upazila',[
            'title' => 'TDS | Upazila', 
            'zillas' => $zillas
        ]);
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string',
            'zilla_id' => 'required|exists:zillas,id',
        ]);

        // Create a new Upazila instance
        $upazila = Upazila::create([
            'name' => $request->input('name'),
            'zilla_id' => $request->input('zilla_id'),
        ]);

        Toastr::success('Upazila Added Successful', 'success');
        return redirect()->route('commissioner.tds.upazila.index');
    }

    public function edit($id)
    {
        $upazila = Upazila::findOrFail($id);
        $zillas = Zilla::orderBy('name', 'ASC')->get();

        return view('commissioner.tds.upazila',[
            'title' => 'TDS | Upazila',
            'updateType' => 'edit',
            'updateUpazila' => $upazila, 
            'zillas' => $zillas
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'zilla_id' => 'required|exists:zillas,id',
        ]);

        $upazila = Upazila::findOrFail($id);
        $upazila->update($request->all());

        Toastr::success('Upazila Update Successful', 'success');
        return redirect()->route('commissioner.tds.upazila.index');
    }

    //UPazila and Organization Relation
    public function upazilaOrganization()
    {        
        $zillas = Zilla::orderBy('name', 'ASC')->get();
        $organizations = Organization::orderBy('name', 'ASC')->get();

        if( Auth::user()->user_role == 'circle' )
        {
            return view('circle.tds.upazila_organization',[
                'title' => 'TDS | Upazila & Organization', 
                'zillas' => $zillas, 
                'organizations' => $organizations,                
            ]);
        }

        return view('commissioner.tds.upazila_organization',[
            'title' => 'TDS | Upazila & Organization', 
            'zillas' => $zillas, 
            'organizations' => $organizations,
            
        ]);
    }

    public function upazilaOrganizationWithOrg($upazilaId)
    {
        $selectedUpazila = Upazila::findOrFail($upazilaId);
        $zillas = Zilla::orderBy('name', 'ASC')->get();
        $organizations = Organization::orderBy('name', 'ASC')->get();

        if( Auth::user()->user_role == 'circle' )
        {
            return view('circle.tds.upazila_organization', [
                'title' => 'TDS | Upazila & Organization',
                'zillas' => $zillas,
                'organizations' => $organizations,
                'selectedUpazila' => $selectedUpazila,
            ]);
        }
        
        return view('commissioner.tds.upazila_organization', [
            'title' => 'TDS | Upazila & Organization',
            'zillas' => $zillas,
            'organizations' => $organizations,
            'selectedUpazila' => $selectedUpazila,
        ]);
    }

    public function removeOrganization($upazilaId, $organizationId)
    {   
        $upazila = Upazila::findOrFail($upazilaId);
        $upazila->organizations()->detach($organizationId);

        Toastr::success('Organization Removed From Upazila', 'success');
        return redirect()->back();
    }


    
    public function addSelectedOrganizations(Request $request, $upazilaId)
    {
        // Validate the incoming request data
        $request->validate([
            'selected_organizations' => 'required|array',
            'selected_organizations.*' => 'exists:organizations,id',
        ]);
    
        // Get the selected Upazila
        $upazila = Upazila::findOrFail($upazilaId);
    
        // Handle the selected organizations and save them
        $selectedOrganizationIds = $request->input('selected_organizations');
    
        // Filter out organizations that are already related to the Upazila
        $newOrganizationIds = array_diff($selectedOrganizationIds, $upazila->organizations->pluck('id')->toArray());
    
        // Attach the selected organizations to the Upazila only if they are not already related
        if (!empty($newOrganizationIds)) {
            $upazila->organizations()->attach($newOrganizationIds);
            Toastr::success('Selected organizations added successfully', 'success');
        } else {
            Toastr::info('Selected organizations were already related', 'info');
        }
    
        return redirect()->back();
    }
    


    
}
