<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'tin',
        'name',
        'sort_name',
        'email',
        'mobile',
        'bangla_name',
        'type',
        'file_in_stock',
        'file_rack',
        'circle',
        'address',
        'last_return'
    ];
}
