<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Upazila;

class Organization extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'is_govt'
    ];

    function upazilas(){
<<<<<<< HEAD
        return $this->belongsToMany(Upazila::class, 'organization_upazilas', ''); 
=======
        return $this->belongsToMany(Upazila::class, 'organization_upazilas');
>>>>>>> 03f9b9a1bcae3e226ae91c1197f84672d9d9835d
    }
}
