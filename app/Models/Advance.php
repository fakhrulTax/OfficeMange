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

    protected $fillable = [
        'tin',
         'advance_assessment_year', 
         'return_submitted_assessment_year', 
         'income', 
         'tax'
        ];
}
