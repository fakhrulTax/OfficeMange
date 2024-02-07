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
        'bill',
        'circle',
        'comments',
    ];

    public function upazila(){
        return $this->belongsTo(Upazila::class, 'upazila_id');
    }

    public function organization(){
        return $this->belongsTo(Organization::class, 'organization_id');
    }
}
