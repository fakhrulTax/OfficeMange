<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\zilla;
use App\Models\Upazila;
use App\Models\organization;

class ContactPerson extends Model
{
    use HasFactory;

    // Specify the table name if it doesn't follow Laravel's naming convention
    protected $table = 'contact_persons';

    // Define fillable properties
    protected $fillable = [
        'zilla_id',
        'upazila_id',
        'organization_id',
        'name',
        'designation',
        'mobile_number',
        'email',
        'circle',
    ];

    // Define any relationships if needed, such as belongsTo for foreign keys
    public function zilla()
    {
        return $this->belongsTo(Zilla::class);
    }

    public function upazila()
    {
        return $this->belongsTo(Upazila::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
