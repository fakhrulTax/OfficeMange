<?php
// app/Helpers/MyHelper.php

namespace App\Helpers;
use App\Models\Stock;
use App\Models\Arrear;
use Illuminate\Support\Facades\Auth;

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

        $user = Auth::user();
    
        if($user->user_role == 'range' && $circle == 'all') {
            $circles = self::rangWiseCircle($user->range); 
    
            $totals = Arrear::whereIn('circle', $circles)
                ->selectRaw('SUM(arrear) as total_arrear, SUM(fine) as total_fine')
                ->first();
    
            $disputed = Arrear::whereIn('circle', $circles)
                ->where('arrear_type', 'disputed')
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
    


    public static function rangWiseCircle($range):array
    {
        $ranges = [
            '1' => [1, 2, 3, 4, 5, 6],
            '2' => [7, 8, 9, 10, 11, 12],
            '3' => [13, 14, 15, 16, 17],
            '4' => [18, 19, 20, 21, 22],
        ];
    
        return $ranges[$range];
      
    }

   
    
    
    
}
