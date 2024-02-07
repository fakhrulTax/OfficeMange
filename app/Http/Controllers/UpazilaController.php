<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Zilla;
use App\Models\Upazila;
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
        dd('go');
        return 'go';
        $zillas = Zilla::orderBy('name', 'ASC')->get();

        return view('commissioner.tds.upazila_organization',[
            'title' => 'TDS | Upazila & Organization', 
            'zillas' => $zillas
        ]);
    }
    
}
