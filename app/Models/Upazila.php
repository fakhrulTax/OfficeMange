<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upazila extends Model
{
    use HasFactory;
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
}
