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


        return $this->belongsToMany(Upazila::class, 'organization_upazilas');

    }

    //get all govt. or non govt. organization
    public static function getOrganizationIdsByType($is_govt = null)
    {
        $organizationIds = self::where('is_govt', $is_govt)->pluck('id')->toArray();;
        return $organizationIds;
    }

}
