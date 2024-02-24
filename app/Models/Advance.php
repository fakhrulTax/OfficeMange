<?php

namespace App\Models;
use App\Models\Stock;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advance extends Model
{
    use HasFactory;

    public function stock()
    {
        return $this->belongsTo(Stock::class, 'tin', 'tin');
    }

    //get total taxpayer by circle
    public static function getAdvanceTaxPayersByCircle(array $circles = null, $assessment_year)
    {
        // Retrieve advance tax payers whose 'circle' attribute is in the provided array $circles
        $advanceTaxPayers = self::where('advance_assessment_year', $assessment_year)->whereIn('circle', $circles)->get();
    
        // Return the collection of advance tax payers
        return $advanceTaxPayers;
    }
    

    protected $fillable = [
        'tin',
         'advance_assessment_year', 
         'return_submitted_assessment_year', 
         'income', 
         'tax'
        ];
}
