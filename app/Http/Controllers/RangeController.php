<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\MyHelper;
use App\Models\Arrear;
use Illuminate\Support\Facades\Auth;
class RangeController extends Controller
{
    public function index()
    {
        return view('range.dashboard');
    }


    public function RangeArrear($circle){

        $circles = MyHelper::rangWiseCircle(Auth::user()->range);

        
        $arrears = Arrear::with('stock')->whereIn('circle', $circles)->latest()->get()->groupBy('tin');
       

        $result = MyHelper::calculateArrearSum($circle);
 

        $GrandArrear = $result['GrandArrear'];
        $TotalDisputedArrear = $result['TotalDisputedArrear'];
        $TotalUndisputedArrear = $result['TotalUndisputedArrear'];

       

        return view ('range.arrear.index', compact('GrandArrear', 'TotalDisputedArrear', 'TotalUndisputedArrear', 'arrears', 'circle' ));

    }


    public function RangeArrearSort(Request $request ) {
        $circle = $request->circle;
        if( $circle == 'all'){

            $circles = MyHelper::rangWiseCircle(Auth::user()->range);

        
            $arrears = Arrear::with('stock')->whereIn('circle', $circles)->latest()->get()->groupBy('tin');

            $result = MyHelper::calculateArrearSum('all');
        }else{
            $arrears = Arrear::with('stock')->where('circle', $circle)->latest()->get()->groupBy('tin');
            $result = MyHelper::calculateArrearSum($circle);
        }

        $GrandArrear = $result['GrandArrear'];
        $TotalDisputedArrear = $result['TotalDisputedArrear'];
        $TotalUndisputedArrear = $result['TotalUndisputedArrear'];

       

        return view ('range.arrear.index', compact('GrandArrear', 'TotalDisputedArrear', 'TotalUndisputedArrear', 'arrears', 'circle' ));
    }
}
