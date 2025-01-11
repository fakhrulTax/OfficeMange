<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'issue_date',
        'type',
        'number',
        'total_number',
        'collection',
        'total_collection',
        'circle', 
    ];
}
