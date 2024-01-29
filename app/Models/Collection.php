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
