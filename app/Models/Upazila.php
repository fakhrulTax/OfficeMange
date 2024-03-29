<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Zilla;
use App\Models\Organization;


class Upazila extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'zilla_id'

    ];

    public function zilla(){
        return $this->belongsTo(Zilla::class);
    }

    function organizations(){
        return $this->belongsToMany(Organization::class, 'organization_upazilas');
    }

}
