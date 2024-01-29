<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\MyHelper;

class RangeController extends Controller
{
    public function index()
    {
        return view('range.dashboard');
    }


    public function RangeArrear(){
        $result = MyHelper::calculateArrearSum('all');

        $GrandArrear = $result['GrandArrear'];
        $TotalDisputedArrear = $result['TotalDisputedArrear'];
        $TotalUndisputedArrear = $result['TotalUndisputedArrear'];

        return view ('range.arrear.index', compact('GrandArrear', 'TotalDisputedArrear', 'TotalUndisputedArrear'));
    }


    public function RangeArrearSort($circle){
        $result = MyHelper::calculateArrearSum($circle);
        
        return response ()->json($result, 200);
    }
}
