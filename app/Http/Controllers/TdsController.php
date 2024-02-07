<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tds_collection;
use App\Models\Zilla;
use App\Models\Upazila;
use App\Models\Organization_upazila;
use Auth;
use Toastr;

class TdsController extends Controller
{
    public function index(){
        $zillas = Zilla::all();
        $tds = Tds_collection::where('circle', Auth::user()->circle)->get()->load('upazila','organization');
     
        return view ('circle.tds.index', compact('tds', 'zillas'));
    }


    public function store(Request $request){

        $request->validate([
            'collection_month' => 'required',
            'upazila_id' => 'required',
            'organization_id' => 'required',
            'tds' => 'required',
            'bill' => 'required',
        ]);

       //check exists for same month and upazila and organization

       $check = Tds_collection::where('collection_month', $request->collection_month)
       ->where('upazila_id', $request->upazila_id)
       ->where('organization_id', $request->organization_id)
       ->first();

       if($check){
        Toastr::error('TDS Already Added', 'Error');
        return redirect()->back();
       }

        $tds = Tds_collection::create([
           
            'collection_month' => $request->collection_month,
            'upazila_id' => $request->upazila_id,
            'organization_id' => $request->organization_id,
            'tds' => $request->tds,
            'bill' => $request->bill,
            'circle' => Auth::user()->circle,
            'comments' => $request->comments
        ]);

        Toastr::success('TDS Added Successfully', 'Success');

        return redirect()->back()->with('success', 'TDS Added Successfully');
    }



    public function edit($id){
        $editTds = Tds_collection::find($id)->load('upazila','organization');

        $tds = Tds_collection::where('circle', Auth::user()->circle)->get()->load('upazila','organization');

        $updateType = 'edit';
  
        return view('circle.tds.index', compact('tds', 'editTds', 'updateType'));
    }



    public function update(Request $request, $id){

        

        $validate = $request->validate([
            'collection_month' => 'required',
            'bill' => 'required',
            'tds' => 'required',
        ]);

        $tds = Tds_collection::find($id);
        //check exists for same month and upazila and organization
        $check = Tds_collection::where('collection_month', $request->collection_month)
        ->where('upazila_id',  $tds->upazila_id)
        ->where('organization_id',$tds->organization_id)
        ->where('id', '!=', $id)
        ->first();

        if($check){
            Toastr::error('TDS Already Added', 'Error');
            return redirect()->back();
        }

        
        $tds->update($validate);
        Toastr::success('TDS Updated Successfully', 'Success');
        return redirect()->route('circle.tds.index');
    }




    public function tdsSearch(Request $request){
        $zillas = Zilla::all();
        

        $tds = Tds_collection::query();

      

        if(!empty($request->upazila_search)){
            $tds = $tds->where('upazila_id', $request->upazila_search);
        }
       
        if(!empty($request->organization_search)){
            $tds = $tds->where('organization_id', $request->organization_search);
        }
        if(!empty($request->collection_month)){
            $tds = $tds->where('collection_month', $request->collection_month);
        }


        $tds = $tds->where('circle', Auth::user()->circle)
        ->with('upazila', 'organization')->get();


        
     
        return view ('circle.tds.index', compact('tds', 'zillas'));
    }








    public function destroy($id){

        $tds = Tds_collection::find($id);
        $tds::destroy($id);
        Toastr::success('TDS Deleted Successfully');
        return redirect()->back()->with('success', 'TDS Deleted Successfully');
    }










    public function upazilaList($zilla){

        $upazilla = Upazila::where('zilla_id', $zilla)->get();

        return response()->json([
            'upazilla' => $upazilla
        ]);
    }


    public function ogranizationList($upazilla){
        $organization = Upazila::where('id', $upazilla)->get()->load('organizations');
        
        return response ()->json([
            'organization' => $organization
        ]);

    }
}
