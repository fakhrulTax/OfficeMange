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
    public function checkArrear($tin, $assessment_year)
    {
        $arrear = Arrear::where('tin',$tin)
                ->where('assessment_year',$assessment_year)
                ->get();
        if(count($arrear))
        {
            return $arrear;
        }
        return false;
    }

}
