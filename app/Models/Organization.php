<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'is_govt'
    ];

    function upazilas(){
        return $this->belongsToMany(Upazila::class, 'organization_id');
    }
}