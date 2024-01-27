<?php
// app/Helpers/MyHelper.php

namespace App\Helpers;
use App\Models\Stock;

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
}
