<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\MyHelper;

class TechnicalController extends Controller
{
    public function index()
    {
        return view('technical.dashboard');
    }

    public function TechnicalArrear(){
        $result = MyHelper::calculateArrearSum('all');

        $GrandArrear = $result['GrandArrear'];
        $TotalDisputedArrear = $result['TotalDisputedArrear'];
        $TotalUndisputedArrear = $result['TotalUndisputedArrear'];

        return view ('technical.arrear.index', compact('GrandArrear', 'TotalDisputedArrear', 'TotalUndisputedArrear'));
    }


    public function TechnicalArrearSort($circle){
        $result = MyHelper::calculateArrearSum($circle);
        
        return response ()->json($result, 200);
    }
}
