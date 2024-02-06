<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Zilla;
use App\Models\Organization;

class Upazila extends Model
{
    use HasFactory;
<<<<<<< HEAD
=======
    protected $fillable = [
        'name',
        'zilla_id'

    ];

    public function Zilla(){
        return $this->belongsTo(Zilla::class);
    }

    function Organization(){
        return $this->belongsToMany(Organization::class, 'organization_upazilas');
    }
>>>>>>> 239c739c5132ff513620b798e676f8ad6aa3740e
}
