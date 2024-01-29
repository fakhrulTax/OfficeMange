<?php
// app/Helpers/MyHelper.php

namespace App\Helpers;
use App\Models\Stock;
use App\Models\Arrear;

class MyHelper
{
    //Assessment Year Format
    public static function assessment_year_format( $number )
    {
         return substr($number,0,4).'-'.substr($number,4,8);

    }

    //Short Name
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

    public static function moneyFormatBD($num) {
        
        if( $num < 1 )
        {
            return 0;
        }

        $explrestunits = "" ;

        if(strlen($num)>3) {
            $lastthree = substr($num, strlen($num)-3, strlen($num));
            $restunits = substr($num, 0, strlen($num)-3); // extracts the last three digits
            $restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
            $expunit = str_split($restunits, 2);
           
            for($i=0; $i<sizeof($expunit); $i++) {
                // creates each of the 2's group and adds a comma to the end
                if($i==0) {
                    $explrestunits .= (int)$expunit[$i].","; // if is first value , convert into integer
                } else {
                    $explrestunits .= $expunit[$i].",";
                }
            }

            $thecash = $explrestunits.$lastthree;
        } else {
            $thecash = $num;
        }
        return $thecash; // writes the final format where $currency is the currency symbol.
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
