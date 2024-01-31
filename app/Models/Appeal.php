<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Stock;

class Appeal extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'tin',
        'appeal_order',
        'appeal_order_date',
        'appeal_disposal_date',
        'assessment_year',
        'main_income',
        'main_tax',
        'revise_income',
        'revise_tax',
        'circle',
    ];

    public function stock()
    {
        return $this->belongsTo(Stock::class, 'tin', 'tin');
    }
}
