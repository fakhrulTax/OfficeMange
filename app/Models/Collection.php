<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;

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
