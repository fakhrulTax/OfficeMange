<?php

namespace App\Http\Controllers;


use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\Upazila;
use Toastr;

class OrganizationController extends Controller
{
    public function index()
    {
        $organizations = Organization::orderBy('name', 'ASC')->get();

        return view('commissioner.tds.organization',[
            'title' => 'TDS | Organization', 
            'organizations' => $organizations
        ]);
    }

  

    public function store(Request $request)
    {
        
        $request->validate([
            'name' => 'required|unique:organizations,name',
            'is_govt' => 'required|boolean',
        ]);

        $organization = Organization::create([
            'name' => $request->input('name'),
            'is_govt' => $request->input('is_govt'),
        ]);

        if( Auth::user()->user_role == 'circle' )
        {
            $request->validate([
                'upazila_search' => 'required',
            ]);

             // Sync the selected upazilas with the organization
            $organization->upazilas()->sync($request->input('upazila_search'));

            Toastr::success('Organization Added Successful', 'success');
            return redirect()->route('circle.tds.upazila.organization');
        }       

        Toastr::success('Organization Added Successful', 'success');
        return redirect()->route('commissioner.tds.organization.index');
    }

    public function edit($id)
    {

        $organization = Organization::findOrFail($id);
        $organizations = Organization::orderBy('name', 'ASC')->get();
        return view('commissioner.tds.organization',[
            'title' => 'TDS | Organization', 
            'updateOrganization' => $organization,
            'organizations' => $organizations,
            'updateType' => 'edit'
        ]);
    }

    public function update(Request $request, Organization $organization)
    {

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('organizations')->ignore($organization->id)->where(function ($query) use ($request) {
                    return $query->where('is_govt', $request->input('is_govt'));
                }),
            ],
            'is_govt' => 'required|boolean',
        ]);

        // Update the organization details
        $organization->update([
            'name' => $request->input('name'),
            'is_govt' => $request->input('is_govt'),
        ]);

        
        Toastr::success('Organization Update Successful', 'success');
        return redirect()->route('commissioner.tds.organization.index');
    }

}
