<?php
// app/Helpers/MyHelper.php

namespace App\Helpers;
use App\Models\Stock;
use App\Models\Arrear;

class MyHelper
{
    public static function sortName($name){
        $sort_name = strtolower($name);
        $sort_name = explode(' ', $sort_name);
        if( $sort_name[0] == 'md' || $sort_name[0] == 'md.' || $sort_name[0] == 'm/s'|| $sort_name[0] == 'm/s-' || $sort_name[0] == 'm/s.' || $sort_name[0] == 'm/s:' || $sort_name[0] == 'ms' || $sort_name[0] == 'mrs,' || $sort_name[0] == 'mst' || $sort_name[0] == 'mst.'|| $sort_name[0] == 'mrs' || $sort_name[0] == 'mosammat' || $sort_name[0] == "messer's"  )
          {
            array_shift( $sort_name);
          }
          $sort_name = implode(' ', $sort_name);
          return $sort_name;
    }
    // Add more helper methods as needed

    public static function tinCheck($tin){

        $existTin = Stock::where('tin', $tin)->first();

        if($existTin){
            return true;
        }else{
            return false;
        }
    }


    public static function calculateArrearSum($circle = null) {
        $query = Arrear::query();
    
        if ($circle !== 'all') {
            $query->where('circle', $circle);
        }
    
        $totals = $query->selectRaw('SUM(arrear) as total_arrear, SUM(fine) as total_fine')
                       ->first();
    
        $disputed = $query->where('arrear_type', 'disputed')
                          ->selectRaw('SUM(arrear) as disputed_arrear, SUM(fine) as disputed_fine')
                          ->first();
    
        $undisputed_arrear = $totals->total_arrear - ($disputed->disputed_arrear ?? 0);
        $undisputed_fine = $totals->total_fine - ($disputed->disputed_fine ?? 0);
    
        return $result = [
            'GrandArrear' => number_format(($totals->total_arrear ?? 0) + ($totals->total_fine ?? 0)),
            'TotalDisputedArrear' => number_format(($disputed->disputed_arrear ?? 0) + ($disputed->disputed_fine ?? 0)),
            'TotalUndisputedArrear' => number_format(($undisputed_arrear ?? 0) + ($undisputed_fine ?? 0)),
        ];
    }
    
}
