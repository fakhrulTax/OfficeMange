<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Stock;

class Collection extends Model
{
    use HasFactory;

    public function stock()
    {
        return $this->belongsTo(Stock::class, 'tin', 'tin');
    }


    //Arrear Collection By TIN and Assessment Year
    public static function getArrearByTINAssessmentYear($tin, $assessment_year)
    {
        $sum = self::where('tin', $tin)->where('assessment_year', $assessment_year)->sum('amount');
        return $sum;
    }

    //Advance Collection By circle and Assessment Year
    public static function advanceCollectionByCircles($circles = null, $assessment_year)
    {
        if($circles)
        {
            $sum = self::whereIn('circle', $circles)->where('assessment_year', $assessment_year)->sum('amount');

        }else
        {
            $sum = self::where('assessment_year', $assessment_year)->sum('amount');
        }
        return $sum;
    }

    // Advance Collection By circle and Assessment Year
    public static function advanceTaxPaidTaxPayers($circles = null, $assessment_year)
    {
        $query = self::select('tin'); // Select 'tin' as it's in the GROUP BY clause

        if ($circles) {
            // If circles are provided, filter by circles
            $query->whereIn('circle', $circles);
        }

        // Filter by assessment year in both cases
        $query->where('assessment_year', $assessment_year);

        // Group by 'tin'
        $taxpayers = $query->groupBy('tin')->get();

        return $taxpayers;
    }



    //Get Advance By TIN and Assessment Year
    public static function getAdvanceByAssessmentYear($tin, $assessment_year)
    {
        $advanceCollection = self::orderBy('pay_date', 'ASC')
                            ->where('type', 'advance')
                            ->where('assessment_year', $assessment_year)
                            ->where('tin', $tin)
                            ->get();
        if( $advanceCollection )
        {
            return $advanceCollection;
        }

        return null;
                        
    }

    protected $fillable = [
        'type',
        'tin',
        'assessment_year',
        'pay_date',
        'amount',
        'challan_no',
        'challan_date',
        'circle',
    ];

}
