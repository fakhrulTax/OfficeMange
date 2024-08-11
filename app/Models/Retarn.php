<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Stock;

class Retarn extends Model
{
    use HasFactory;

    protected $fillable = [
        'register','return_submission_date','register_serial','tin', 'name',
        'assessment_year','source_of_income','income',
        'income_of_poultry_fisheries','income_of_remittance',
        'tax_of_schedule_one','special_tax','special_invest',
        'source_tax','advance_tax','retarn_tax','late_fee',
        'sercharge','total_tax','liabilities',
        'net_asset','comments','circle',
    ];

    public function stock(){

        return $this->belongsTo(Stock::class, 'tin', 'tin');
    }

}
