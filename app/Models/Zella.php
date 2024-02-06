<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Zella extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
    ];

    function upazilas(){
        return $this->hasMany(Upazila::class);
    }
}
