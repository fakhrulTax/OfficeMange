<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Upazila;

class Organization extends Model
{
    use HasFactory;
<<<<<<< HEAD
=======
    protected $fillable = [
        'name',
        'is_govt'
    ];

    function upazilas(){
        return $this->belongsToMany(Upazila::class, 'organization_id');
    }
>>>>>>> 239c739c5132ff513620b798e676f8ad6aa3740e
}
