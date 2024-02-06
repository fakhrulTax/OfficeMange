<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Tds_collection extends Model
{
    use HasFactory;
    protected $fillable = [
        'collection_month',
        'upazila_id',
        'organization_id',
        'tds',
        'comments',
    ];
}
