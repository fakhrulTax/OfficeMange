<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reopen extends Model
{
    use HasFactory;

    // Specify the table if it is not the plural form of the model name
    protected $table = 'reopens';

    // Define the fillable fields
    protected $fillable = [
        'tin',
        'assessment_year',
        'reopen_date',
        'main_income',
        'main_tax',
        'expire_date',
        'disposal_date',
        'assessed_income',
        'demand',
        'circle',
    ];

    // Define any relationships if needed
    public function stock()
    {
        return $this->belongsTo(Stock::class, 'tin', 'tin'); // Adjust as necessary based on your foreign key relationships
    }
}

