<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tds_collection;
use App\Models\Zilla;
use App\Models\Upazila;
use App\Models\Organization;
use App\Models\Organization_upazila;
use Illuminate\Support\Facades\DB;
use App\Helpers\MyHelper;
use Carbon\Carbon;
use Auth;
use Toastr;

class TdsController extends Controller
{
    //TDS Report For Range
    public function tdsRangeReport()
    {
        $assessment_year = config('settings.assessment_year_commissioner');
        $monthRange = MyHelper::dateRangeAssessmentYear($assessment_year);
        $circles = Myhelper::ranges( 'range-' . Auth::user()->range );

        //Circle Data
         $circleDatas = Tds_collection::getAssessmentYearCollectionByCircle($monthRange, $circles);

        //Upazila Data
        $upazilaIds = Tds_collection::whereIn('circle', $circles)->distinct()->pluck('upazila_id')->toArray();       
        $upazilaData = count($upazilaIds) ? Tds_Collection::getAssessmentYearCollectionByUpazila($upazilaIds, $monthRange, $circles) : [];
        
        //Organization Data
        $orgIds = Tds_collection::whereIn('circle', $circles)->distinct()->pluck('organization_id')->toArray();
        $orgDatas = count($orgIds) ? Tds_collection::getAssessmentYearCollectionByOrganization($orgIds, $monthRange, $circles) : [];
      
        return view('range.tds.report', [
            'title' => 'TDS Report',
            'monthRange' => $monthRange,
            'circleDatas' => $circleDatas,
            'upazilaData' => $upazilaData,
            'orgDatas' => $orgDatas,
        ]);
    }

        //Report from all org based on one upazila on single circle
    public function tdsReportbyOrgDistUpazila( $upazilaId )
    {    
        $assessment_year = config('settings.assessment_year_commissioner');           
        $monthRange = MyHelper::dateRangeAssessmentYear($assessment_year); 

        $upazila = Upazila::find($upazilaId);
        $orgIds = $upazila->organizations->pluck('id')->toArray();

        $orgDatas = count($orgIds) ? Tds_Collection::getAssessmentYearCollectionByAllOrganizationInUpazila($upazilaId, $orgIds, null, $monthRange) : [];
        
        return view('range.tds.organization_by_upazila_by_distict', [
            'title' => 'TDS Report',
            'monthRange' => $monthRange,
            'upazila' => $upazila,
            'orgDatas' => $orgDatas,
        ]);
    }

    //Report from all org based on one upazila on single circle
    public function tdsReportbyOrgUpazila ( $upazilaId, $givenCircle = null )
    {      
        if( !$givenCircle && Auth::user()->user_role == 'circle' )
        {
            $assessment_year = config('settings.assessment_year_'.Auth::user()->circle);
            $circle = Auth::user()->circle;
        }else
        {
            $assessment_year = config('settings.assessment_year_commissioner');                      
            $circle = $givenCircle; 
        }
       
       $monthRange = MyHelper::dateRangeAssessmentYear($assessment_year); 

       $upazila = Upazila::find($upazilaId);
       $orgIds = $upazila->organizations->pluck('id')->toArray();

       $orgDatas = count($orgIds) ? Tds_Collection::getAssessmentYearCollectionByAllOrganizationInUpazila($upazilaId, $orgIds, [ $circle ], $monthRange) : [];

       return view('circle.tds.organization_by_upazila_report', [
        'title' => 'TDS Report',
        'monthRange' => $monthRange,
        'upazila' => $upazila,
        'orgDatas' => $orgDatas,
         ]);
    }

    //TDS Report From Circle
    public function tdsReport($givenCircle = null)
    {        

        if( !$givenCircle && Auth::user()->user_role == 'circle' )
        {
            $assessment_year = config('settings.assessment_year_'.Auth::user()->circle);
            $circle = Auth::user()->circle;
        }else
        {
            $assessment_year = config('settings.assessment_year_commissioner');                      
            $circle = $givenCircle; 
        }
        
        $monthRange = MyHelper::dateRangeAssessmentYear($assessment_year);

        //Circle Data
        $circleData = Tds_collection::getAssessmentYearCollectionByCircle($monthRange, [$circle]);

        //Upazila Data
        $upazilaIds = Tds_collection::where('circle', $circle)->distinct()->pluck('upazila_id')->toArray();    
        $upazilaData = count($upazilaIds) ? Tds_Collection::getAssessmentYearCollectionByUpazila($upazilaIds, $monthRange, [$circle]) : [];
        
        //Organization Data
        $orgIds = Tds_collection::where('circle', $circle)->distinct()->pluck('organization_id')->toArray();
        $orgDatas = count($orgIds) ? Tds_collection::getAssessmentYearCollectionByOrganization($orgIds, $monthRange, [$circle]) : [];
      
        //dd($circleData);
        return view('circle.tds.report', [
            'title' => 'TDS Report',
            'monthRange' => $monthRange,
            'circleData' => $circleData,
            'upazilaData' => $upazilaData,
            'orgDatas' => $orgDatas,
            'circle' => $circle,
        ]);
    }

    public function index(){

        $zillas = Zilla::orderBy('name')->get();

        $tdses = Tds_collection::where('circle', Auth::user()->circle)
        ->with('upazila', 'organization')
        ->latest()
        ->paginate(100);    
     
        return view ('circle.tds.index', compact('tdses', 'zillas'));

    }


    public function create(){
       
        $zillas = Zilla::orderBy('name')->get();  

        $selectedDistictId = config('settings.distict_' . Auth::user()->circle);
        $selectedUpazilaIds = json_decode(config('settings.upazila_id_' . Auth::user()->circle));
        if(!$selectedUpazilaIds)
        {
            $selectedUpazilaIds = [];
        }
        $selectedUpazilas = Upazila::whereIn('id', $selectedUpazilaIds)->orderBy('name', 'ASC')->get();

        return view('circle.tds.create', [
            'zillas' => $zillas,
            'selectedDistictId' => $selectedDistictId,
            'selectedUpazilas' => $selectedUpazilas,
        ]);
    }


    public function store(Request $request){

        $request->validate([
            'collection_month' => 'required|date_format:m-Y',
            'upazila_id' => 'required',
            'organization_id' => 'required',
            'tds' => 'required',
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

       // Date Format
        $carbonDate = Carbon::createFromFormat('m-Y', $request->collection_month);
        $formatedDate = $carbonDate->format('Y-m');

        $tds = Tds_collection::create([
           
            'collection_month' => $formatedDate,
            'upazila_id' => $request->upazila_id,
            'organization_id' => $request->organization_id,
            'tds' => $request->tds,
            'bill' => $request->bill,
            'circle' => Auth::user()->circle,
            'comments' => $request->comments
        ]);

        Toastr::success('TDS Added Successfully', 'Success');

        return redirect()->route('circle.tds.create.upazila', [$request->zilla_id, $request->upazila_id]);
    }

    //Create By Upazila
    public function createByUpazila($zilla_id, $upazila_id){
       

        $selectedDistict = Zilla::find($zilla_id);
        $selectedUpazila = Upazila::find($upazila_id);
        $organizations = $selectedUpazila->organizations->sortBy('name');

        $tdses = Tds_collection::where('upazila_id', $upazila_id)->where('circle', Auth::user()->circle)->orderBy('created_at', 'DESC')->paginate(50);

        return view('circle.tds.create_by_upazila', [
            'selectedDistict' => $selectedDistict,
            'selectedUpazila' => $selectedUpazila,
            'organizations' => $organizations,
            'tdses' => $tdses,
        ]);
    }



    public function edit($id){
        $editTds = Tds_collection::find($id)->load('upazila','organization');

        $tds = Tds_collection::where('circle', Auth::user()->circle)->get()->load('upazila','organization');
        $zillas = Zilla::orderBy('name')->get();;
        $updateType = 'edit';
        
        $clickedRoute = request()->input('clicked_route');

        return view('circle.tds.create', compact('tds', 'editTds', 'updateType','zillas', 'clickedRoute'));
    }


    public function update(Request $request, $id){
        

        $validate = $request->validate([
            'collection_month' => 'required|date_format:m-Y',
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

        // Date Format
        $carbonDate = Carbon::createFromFormat('m-Y', $request->collection_month);
        $formatedDate = $carbonDate->format('Y-m');

        $tds->update([
            'collection_month' => $formatedDate,
            'tds' => $request->tds,
            'bill' => $request->bill,
            'comments' => $request->comments
        ]);
        Toastr::success('TDS Updated Successfully', 'Success');

        if(  $request->clicked_route == 'circle.tds.create.upazila' )
        {
                        
            return redirect()->route('circle.tds.create.upazila', [$request->zilla_id, $request->upazila_id]);
        }

        return redirect()->route('circle.tds.index');
    }




    public function tdsSearch(Request $request){
        $zillas = Zilla::orderBy('name')->get();
        
        $tdses = Tds_collection::query();
    
        if(!empty($request->upazila_search)){
            $tdses = $tdses->where('upazila_id', $request->upazila_search);
        }
       
        if(!empty($request->organization_search)){
            $tdses = $tdses->where('organization_id', $request->organization_search);
        }
        if(!empty($request->start_month)){

            $tdses = $tdses->whereBetween('collection_month', [$request->start_month, $request->end_month]);
        }
    
        $tdses = $tdses->where('circle', Auth::user()->circle)
            ->with('upazila', 'organization')
            ->paginate(100);        
    
        return view ('circle.tds.index', compact('tdses', 'zillas'));
    }
    








    public function destroy($id){

        $tds = Tds_collection::find($id);
        $tds::destroy($id);
        Toastr::success('TDS Deleted Successfully');
        return redirect()->back()->with('success', 'TDS Deleted Successfully');
    }






    public function upazilaList($zilla){

        $upazilla = Upazila::where('zilla_id', $zilla)->orderBy('name')->get();

        return response()->json([
            'upazilla' => $upazilla
        ]);
    }


    public function ogranizationList($upazilla){
        $organization = Upazila::where('id', $upazilla)->orderBy('name')->get()->load('organizations');
        
        return response ()->json([
            'organization' => $organization
        ]);

    }



    //Commission TDS
    public function commissionTdsIndex(){
        $zillas = Zilla::orderBy('name')->get();

        $tdsList = Tds_collection::orderBy('circle', 'ASC')->with('upazila', 'organization')

        ->paginate(100);
     
        return view ('commissioner.tds.index', compact('tdsList', 'zillas'));
    }


    public function commissionTdsSearch(Request $request){


        $zillas = Zilla::orderBy('name')->get();
        
        $tdsList = Tds_collection::query();

        if( !empty($request->zilla_search) && empty($request->upazila_search)){
            $upzila = Upazila::where('zilla_id', $request->zilla_search)->orderBy('name')->get();

            $tdsList = $tdsList->whereIn('upazila_id', $upzila->pluck('id'));

        }

       
    
        if(!empty($request->upazila_search)){
            $tdsList = $tdsList->where('upazila_id', $request->upazila_search);
        }
       
        if(!empty($request->organization_search)){
            $tdsList = $tdsList->where('organization_id', $request->organization_search);
        }
        if(!empty($request->circle)){
            $tdsList = $tdsList->where('circle', $request->circle);
        }

        if(!empty($request->start_month)){

            $tdsList = $tdsList->whereBetween('collection_month', [$request->start_month, $request->end_month]);
        }
    
        $tdsList = $tdsList->where('circle', Auth::user()->circle)
            ->with('upazila', 'organization')
            ->paginate(100);        
    
        return view ('commissioner.tds.index', compact('tdsList', 'zillas'));
        
    }

    //Commissioner Tds Report
    public function collectionIndex()
    {
        //Settings
        $assessment_year = config('settings.assessment_year_commissioner');
        $monthRange = MyHelper::dateRangeAssessmentYear($assessment_year);

        //Get Govt or Non Govt Organization
        $govtOrganizationIds = Organization::getOrganizationIdsByType(true);         
        $nonGovtOrganizationIds = Organization::getOrganizationIdsByType(false); 
        
        //Get Total Govt. or Non Govt Org
        $toatalGovtTDS = Tds_collection::totalCollectionByOrg( $assessment_year, $govtOrganizationIds);
        $toatalNonGovtTDS = Tds_collection::totalCollectionByOrg( $assessment_year, $nonGovtOrganizationIds); 
        
        //Circle Data
        $circleData = Tds_collection::getAssessmentYearCollectionByCircle($monthRange);

        //dd($circleData);

        //Zillas
        $zillas = Zilla::orderBy('name')->get();

         //Organization Data
         $orgIds = array_merge($govtOrganizationIds, $nonGovtOrganizationIds);         
         $orgDatas = count($orgIds) ? Tds_collection::getAssessmentYearCollectionByOrganization($orgIds, $monthRange, $circles = null) : [];
         
         //dd($orgDatas);

        return view('commissioner.tds.collection_index', [
            'title' => 'TDS Report',
            'monthRange' => $monthRange,
            'govtOrgNumber' => count($govtOrganizationIds), 
            'nonGovtOrgNumber' => count($nonGovtOrganizationIds), 
            'toatalGovtTDS' => $toatalGovtTDS,
            'toatalNonGovtTDS' => $toatalNonGovtTDS,
            'circleData' => $circleData,
            'zillas' => $zillas,
            'orgDatas' => $orgDatas 
        ]);
    }

    public function collectionZilla($zillaId)
    {
        $zilla = Zilla::find($zillaId);
        $upazilas = $zilla->upazilas;    
        $upazilaIds = $upazilas->pluck('id')->toArray();   
       
        return view('commissioner.tds.collection_zilla', [
            'title' => 'TDS '. ucfirst($zilla->name),
            'zilla' => $zilla,
            'upazilaIds' => $upazilaIds,
        ]);
    }
    
   
    
    
    
    

}
