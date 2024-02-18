<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Tds_collection extends Model
{
    use HasFactory;
    protected $fillable = [
        'collection_month',
        'upazila_id',
        'organization_id',
        'tds',
        'bill',
        'circle',
        'comments',
    ];

    public function upazila(){
        return $this->belongsTo(Upazila::class, 'upazila_id');
    }

    public function organization(){
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    public static function getAssessmentYearCollectionByCircle(array $monthsOrder)
    {
        // Predefined order of months
        //$monthsOrder = ['July 2023', 'August 2023', 'September 2023', 'October 2023', 'November 2023', 'December 2023', 'January 2024', 'February 2024', 'March 2024', 'April 2024', 'May 2024', 'June 2024'];
    
        // Use Eloquent to group by circle and month and get the sum of amount
        $circleData = Self::select('circle', DB::raw("SUBSTRING(collection_month, 1, 7) as month"), DB::raw('SUM(tds) as total_amount'))
            ->groupBy('circle', 'month')
            ->orderBy('circle')
            ->orderBy(DB::raw("FIELD(month, '" . implode("','", $monthsOrder) . "')"))
            ->get();
    
        // Organize the data into the format you want
        $formattedData = [];
    
        foreach ($circleData as $item) {
            // Map the database month to your predefined format
            $formattedMonth = Self::mapDatabaseMonthToFormat($item->month);
    
            // Only include months in your predefined order
            if (in_array($formattedMonth, $monthsOrder)) {
                $formattedData[$item->circle][$formattedMonth] = $item->total_amount;
            }
        }
    
        // Fill missing months with zero values
        foreach ($formattedData as &$circle) {
            $circle = array_replace(array_fill_keys($monthsOrder, 0), $circle);
        }
    
        return $formattedData;
    }
    
    
    

    public static function getAssessmentYearCollectionByZilla(array $upazilaIds, array $monthsOrder)
    {
        // Use Eloquent to group by upazila and month and get the sum of amount
        $upazilaData = Self::select('upazila_id', DB::raw("SUBSTRING(collection_month, 1, 7) as month"), DB::raw('SUM(tds) as total_amount'))
            ->whereIn('upazila_id', $upazilaIds)
            ->groupBy('upazila_id', 'month')
            ->orderBy('upazila_id')
            ->orderBy(DB::raw("FIELD(month, '" . implode("','", $monthsOrder) . "')"))
            ->get();

        // Organize the data into the format you want
        $formattedData = [];

        foreach ($upazilaData as $item) {
            // Map the database month to your predefined format
            $formattedMonth = Self::mapDatabaseMonthToFormat($item->month);

            // Only include months in your predefined order
            if (in_array($formattedMonth, $monthsOrder)) {
                $formattedData[$item->upazila_id][$formattedMonth] = $item->total_amount;
            }
        }
        
        // Fill missing months with zero values
        foreach ($formattedData as &$upazila) {
            $upazila = array_replace(array_fill_keys($monthsOrder, 0), $upazila);
        }
       
        // Array to store the sum of values for each month
        $monthlySum = [];

        // Loop through each array in $monthlyData
        foreach ($formattedData as $array) {
            // Loop through each month in the array
            foreach ($array as $month => $value) {
                // Initialize the sum for the current month if not set
                $monthlySum[$month] = ($monthlySum[$month] ?? 0) + $value;
            }
        }

        return $monthlySum;
    }


    public static function getAssessmentYearCollectionByUpazila(array $upazilaIds, array $monthsOrder)
    {
        // Use Eloquent to group by upazila and month and get the sum of amount
        $upazilaData = Self::select('upazila_id', DB::raw("SUBSTRING(collection_month, 1, 7) as month"), DB::raw('SUM(tds) as total_amount'))
            ->whereIn('upazila_id', $upazilaIds)
            ->groupBy('upazila_id', 'month')
            ->orderBy('upazila_id')
            ->orderBy(DB::raw("FIELD(month, '" . implode("','", $monthsOrder) . "')"))
            ->get();

        // Organize the data into the format you want
        $formattedData = [];

        foreach ($upazilaData as $item) {
            // Map the database month to your predefined format
            $formattedMonth = Self::mapDatabaseMonthToFormat($item->month);

            // Only include months in your predefined order
            if (in_array($formattedMonth, $monthsOrder)) {
                $formattedData[$item->upazila_id][$formattedMonth] = $item->total_amount;
            }
        }
        
        // Fill missing months with zero values
        foreach ($formattedData as &$upazila) {
            $upazila = array_replace(array_fill_keys($monthsOrder, 0), $upazila);
        }

        return $formattedData;
    }
    

    private static function mapDatabaseMonthToFormat($databaseMonth)
    {
        $dateTime = new \DateTime($databaseMonth);
        return $dateTime->format('F Y');
    }



    



}
