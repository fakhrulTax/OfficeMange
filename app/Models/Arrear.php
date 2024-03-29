<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Stock;

class Arrear extends Model
{
    use HasFactory;

    protected $fillable = [
        'arrear_type',
        'tin',
        'demand_create_date',
        'assessment_year',
        'arrear',
        'fine',
        'comments',
        'circle'

    ];


    public function stock(){

        return $this->belongsTo(Stock::class, 'tin', 'tin');
    }

    //Get Sum of Arrear Taxpayer By Circle
    public static function sumArrearTaxPayers( $circle )
    {
        $taxPayers = self::where('circle', $circle)->get()->groupBy('tin');

        return $taxPayers? count($taxPayers): 0;
    }

    //Get Arrear By Type By Circles
    public static function getSumArrearByType($type, array $circles = null)
    {
        if( $circles )
        {
            $arrearSum = self::where('arrear_type', $type)->whereIn('circle', $circles)->sum('arrear');
            $fineSum = self::where('arrear_type', $type)->whereIn('circle', $circles)->sum('fine');
        }else
        {
            $arrearSum = self::where('arrear_type', $type)->sum('arrear');
            $fineSum = self::where('arrear_type', $type)->sum('fine');            
        }       
        
        $sumArrear = $arrearSum + $fineSum;

        return $sumArrear ? $sumArrear: 0;
    }

    //Check Arrear available in database
    public static function checkArrear($tin, $assessment_year)
    {
        $arrear = self::where('tin', $tin)
            ->where('assessment_year', $assessment_year)
            ->get();

        return $arrear->isNotEmpty() ? $arrear : false;
    }

    //Update Arrear Status
    public static function updateStatus($tin, array $assessmentYears, $newStatus)
    {
        // Update status for matching records
        self::where('tin', $tin)
            ->whereIn('assessment_year', $assessmentYears)
            ->update(['arrear_type' => $newStatus]);

        return 'Status updated successfully';
    }

    //Change Arrear Status and Amount
    public static function updateArrearStatusAmountOrFine($tin, $assessmentYear, $newStatus, $newArrear, $newFine)
    {
        // Find the arrear based on TIN and assessment year
        $arrear = self::where('tin', $tin)
            ->where('assessment_year', $assessmentYear)
            ->first();

        // If arrear found, update the status
        if ($arrear) {
            $arrear->arrear_type = $newStatus;

            if($newArrear)
            {
                $arrear->arrear =  $newArrear;
            }

            if( $newFine)
            {
                $arrear->fine =  $newFine;
            }

            
            $arrear->save();

            return true;
        }

        return false; // Arrear not found
    }

}
