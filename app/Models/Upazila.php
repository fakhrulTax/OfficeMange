<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upazila extends Model
{
    use HasFactory;
<<<<<<< HEAD
=======
    protected $fillable = [
        'zilla_id',
        'name',
    ];

    function zilla(){
        return $this->belongsTo(Zilla::class, 'zilla_id');
    }

    function organizations(){
        return $this->belongsToMany(Organization::class, 'organization_upazilas');
    }
>>>>>>> 239c739c5132ff513620b798e676f8ad6aa3740e
}
