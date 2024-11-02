<?php

namespace App\Http\Controllers;

use App\Models\ContactPerson;
use Illuminate\Http\Request;

use App\Models\Zilla;
use App\Models\Upazila;
use App\Models\Organization;
use App\Models\Organization_upazila;
use Illuminate\Support\Facades\DB;
use App\Helpers\MyHelper;
use Auth;
use Toastr;

class ContactPersonController extends Controller
{
    // Display a listing of contact persons
    public function index()
    {
        $zillas = Zilla::orderBy('name')->get();

        if( Auth::user()->user_role == 'commissioner')
        {
            $circles = $circle = range(1, 22);;
           
        }elseif( Auth::user()->user_role == 'range')
        {
            
            $circles = MyHelper::ranges('range-'.Auth::user()->range);
           
        }else
        {
            $circles = [Auth::user()->circle];
        }

        $persons = ContactPerson::with(['zilla', 'upazila', 'organization'])
                ->whereIn('circle', $circles)
                ->orderBy('id', 'DESC')
                ->paginate(100);

        return view('circle.tds.person.index', [
            'persons' => $persons,
            'zillas' => $zillas,
            'Auth' => new Auth(),
            'circles' => $circles
        ]);
    }

    // Show the form for creating a new contact person
    public function create()
    {
        $zillas = Zilla::orderBy('name')->get();
        $selectedDistictId = config('settings.distict_' . Auth::user()->circle);
        $selectedUpazilaIds = json_decode(config('settings.upazila_id_' . Auth::user()->circle));
        if(!$selectedUpazilaIds)
        {
            $selectedUpazilaIds = [];
        }
        $selectedUpazilas = Upazila::whereIn('id', $selectedUpazilaIds)->orderBy('name', 'ASC')->get();


        return view('circle.tds.person.create', [
            'zillas' => $zillas,
            'selectedDistictId' => $selectedDistictId,
            'selectedUpazilas' => $selectedUpazilas,
        ]);
    }

    // Store a newly created contact person in the database
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'zilla_id' => 'required|exists:zillas,id',
            'upazila_id' => 'required|exists:upazilas,id',
            'organization_id' => 'required|exists:organizations,id',
            'name' => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'mobile_number' => 'required|numeric',
            'email' => 'nullable|email',
        ]);

        $validatedData['circle'] = Auth::user()->circle;

        //check exists for same month and upazila and organization
       $check = ContactPerson::where('zilla_id', $request->zilla_id)
       ->where('upazila_id', $request->upazila_id)
       ->where('organization_id', $request->organization_id)
       ->first();

       if($check){
        Toastr::error('Contact Person Already Added', 'Error');
        return redirect()->back();
       }         
       
        ContactPerson::create($validatedData);

        Toastr::success('Contact Person Added Successfully', 'Success');
        return redirect()->route('circle.tds.contactPerson');
    }

    
    // Show the form for editing the specified contact person
    public function edit(ContactPerson $contactPerson)
    {        
       //dd($contactPerson);
        $zillas = Zilla::orderBy('name')->get();

        $selectedDistictId = config('settings.distict_' . Auth::user()->circle);
        $selectedUpazilaIds = json_decode(config('settings.upazila_id_' . Auth::user()->circle));
        if(!$selectedUpazilaIds)
        {
            $selectedUpazilaIds = [];
        }
        $selectedUpazilas = Upazila::whereIn('id', $selectedUpazilaIds)->orderBy('name', 'ASC')->get();

        $authorities = $contactPerson->upazila->organizations;

        return view('circle.tds.person.edit', [
            'contactPerson' => $contactPerson,
            'zillas' => $zillas,
            'selectedDistictId' => $selectedDistictId,
            'selectedUpazilas' => $selectedUpazilas,
            'authorities' => $authorities
        ]);
    }

    // Update the specified contact person in the database
    public function update(Request $request, ContactPerson $contactPerson)
    {
        $validatedData = $request->validate([
            'zilla_id' => 'required|exists:zillas,id',
            'upazila_id' => 'required|exists:upazilas,id',
            'organization_id' => 'required|exists:organizations,id',
            'name' => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'mobile_number' => 'required|numeric',
            'email' => 'nullable|email',
        ]);

        $validatedData['circle'] = Auth::user()->circle;

        // Check if a ContactPerson already exists with the same zilla, upazila, and organization, but exclude the current record being updated
        $check = ContactPerson::where('zilla_id', $request->zilla_id)
            ->where('upazila_id', $request->upazila_id)
            ->where('organization_id', $request->organization_id)
            ->where('id', '!=', $contactPerson->id)
            ->first();

        if ($check) {
            Toastr::error('Contact Person Already Added', 'Error');
            return redirect()->back();
        }

        // Update the contact person with the validated data
        $contactPerson->update($validatedData);

        Toastr::success('Contact Person Updated Successfully', 'Success');
        return redirect()->route('circle.tds.contactPerson');
    }

    public function search(Request $request)
    {

        if( Auth::user()->user_role == 'commissioner')
        {
            $circles = $circle = range(1, 22);;
           
        }elseif( Auth::user()->user_role == 'range')
        {
            
            $circles = MyHelper::ranges('range-'.Auth::user()->range);
           
        }else
        {
            $circles = [Auth::user()->circle];
        }
        
        $zillas = Zilla::orderBy('name')->get();

        $query = ContactPerson::query();

        // Apply filters based on search inputs      

        if ($request->filled('zilla_id')) {
            $query->where('zilla_id', $request->zilla_id);
        }

        if ($request->filled('upazila_id')) {
            $query->where('upazila_id', $request->upazila_id);
        }

        if ($request->filled('organization_id')) {
            $query->where('organization_id', $request->organization_id);
        }

        if ($request->filled('circle')) {
            $query->where('circle', $request->circle);
        }

        $query->whereIn('circle', $circles);
        $persons = $query->orderBy('id', 'DESC')->paginate(100);

        return view('circle.tds.person.index', [
            'persons' => $persons,
            'zillas' => $zillas,
            'Auth' => new Auth(),
            'circles' => $circles
        ]);
    }


    
}
