<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Collection;
use App\Models\Arrear;
use Toastr;


class CollectionController extends Controller
{

    //Search
    //Search
    public function search(Request $request)
    {
        $collections = Collection::query();
        if(!empty($request->type))
        {
            $collections = $collections->where('type', '=', $request->type);
        }

        if(!empty($request->tin))
        {
            $collections = $collections->where('tin', '=', $request->tin);
        }

        if(!empty($request->from_date) && !empty($request->to_date))
        {
            $from_date = date('Y-m-d', strtotime($request->from_date));
            $to_date = date('Y-m-d', strtotime($request->to_date));            
            $collections = $collections->whereBetween('pay_date',[$from_date, $to_date]);
        }
        
        $collections = $collections->where('circle', Auth::user()->circle);
        $collections = $collections->paginate(100);

        return view('circle.Collection.index',[
            'title' => 'Collection|Search', 
            'collections' => $collections,
            'search' => $request
        ]);
    }


    public function index()
    {
        $collections = Collection::orderBy('id', 'DESC')
                        ->where('circle', Auth::user()->circle)
                        ->paginate(100);
                        
        return view('circle.collection.index',[
            'title' => 'Collection|All Collection', 
            'collections' => $collections
        ]);
    }

    public function create()
    {
        return view('circle.Collection.create',['title' => 'Collection|Add a Collection']);
    }

    //Store Collection
    public function store(Request $request)
    {        
        $request->validate([
            'type' => 'required',
            'tin' => 'required|digits:12',
            'pay_date' => 'required|date',
            'assessment_year' => 'required|digits:8',
            'challan_no' => 'required',
            'challan_date' => 'required',
        ]);

        //Check The Arrear is availavle in Arrear Table

        $arrear = Arrear::checkArrear($request->tin, $request->assessment_year);

        if (!$arrear) {
            Toastr::error('There is no arrear for this TIN and Assessment Year', 'danger');
            return back()->withInput();
        }

        //  //Check The Advance is availavle in Advance Table
        // if( $request->type == 'advance' )
        // {
        //     $a = new Advance();
        //     if( !$a->getAdvance($request->tin) )
        //     {
        //         Toastr::error('There is no advance for this TIN', 'danger');
        //         return back();
        //     }            
        // }

        //Store The Datta
        Collection::create([
            'type' => $request->type,
            'tin' => $request->tin,
            'assessment_year' => $request->assessment_year,
            'pay_date' => date('Y-m-d',strtotime($request->pay_date)),
            'amount' => $request->amount,
            'challan_no' => $request->challan_no,
            'challan_date' =>  date('Y-m-d',strtotime($request->challan_date)),
            'circle' => Auth::user()->circle,

        ]);

        Toastr::success('Collection Added Successful', 'success');
        return redirect()->route('circle.collection.index');
    } 

    //Collection Edit
    public function edit($id)
    {
        $collection = Collection::find($id);
        return view('circle.collection.edit',[
            'title' => 'Collection|Edit a Collection',
            'collection' => $collection
        ]);
    }

    //Collection Update
    public function update(Request $request){
        
        $request->validate([
            'type' => 'required',
            'tin' => 'required|digits:12',
            'pay_date' => 'required|date',
            'assessment_year' => 'required|digits:8',
            'challan_no' => 'required',
            'challan_date' => 'required',
        ]);

        //Check The Arrear is availavle in Arrear Table

        $arrear = Arrear::checkArrear($request->tin, $request->assessment_year);

        if (!$arrear) {
            Toastr::error('There is no arrear for this TIN and Assessment Year', 'danger');
            return back()->withInput();
        }

        Collection::where('id', $request->id)->update([
            'type' => $request->type,
            'tin' => $request->tin,
            'assessment_year' => $request->assessment_year,
            'pay_date' => date('Y-m-d',strtotime($request->pay_date)),
            'amount' => $request->amount,
            'challan_no' => $request->challan_no,
            'challan_date' =>  date('Y-m-d',strtotime($request->challan_date)),
            'circle' => Auth::user()->circle,

        ]);

        Toastr::success('Collection Update Successful', 'success');
        return redirect()->route('circle.collection.index');       

    }




}
