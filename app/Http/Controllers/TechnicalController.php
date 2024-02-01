<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\MyHelper;
use App\Models\Arrear;

class TechnicalController extends Controller
{
    public function index()
    {
        return view('technical.dashboard');
    }

    public function TechnicalArrear($circle){

        $arrears = Arrear::with('stock')->latest()->get()->groupBy('tin');
        if($circle != 'all'){
            $arrears = Arrear::with('stock')->where('circle', $circle)->latest()->get()->groupBy('tin');
        }

        $result = MyHelper::calculateArrearSum('all');

        $GrandArrear = $result['GrandArrear'];
        $TotalDisputedArrear = $result['TotalDisputedArrear'];
        $TotalUndisputedArrear = $result['TotalUndisputedArrear'];

       

        return view ('technical.arrear.index', compact('GrandArrear', 'TotalDisputedArrear', 'TotalUndisputedArrear', 'arrears', 'circle' ));




       
    }


    public function TechnicalArrearSort(Request $request ) {
        $circle = $request->circle;
        if( $circle == 'all'){
            $arrears = Arrear::with('stock')->latest()->get()->groupBy('tin');
            $result = MyHelper::calculateArrearSum('all');
        }else{
            $arrears = Arrear::with('stock')->where('circle', $circle)->latest()->get()->groupBy('tin');
            $result = MyHelper::calculateArrearSum($circle);
        }

        $GrandArrear = $result['GrandArrear'];
        $TotalDisputedArrear = $result['TotalDisputedArrear'];
        $TotalUndisputedArrear = $result['TotalUndisputedArrear'];

       

        return view ('technical.arrear.index', compact('GrandArrear', 'TotalDisputedArrear', 'TotalUndisputedArrear', 'arrears', 'circle' ));
    }
}
