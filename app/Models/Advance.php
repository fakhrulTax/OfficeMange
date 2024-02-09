<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advance extends Model
{
    use HasFactory;

    protected $fillable = [
        'tin',
         'advance_assessment_year', 
         'return_submitted_assessment_year', 
         'income', 
         'tax'
        ];
}
