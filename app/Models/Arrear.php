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

    //Check Arrear available in database
    public static function checkArrear($tin, $assessment_year)
    {
        $arrear = self::where('tin', $tin)
            ->where('assessment_year', $assessment_year)
            ->get();

        return $arrear->isNotEmpty() ? $arrear : false;
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
