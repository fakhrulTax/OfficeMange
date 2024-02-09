<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Upazila;

class Zilla extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    

    public function upazilas(){
        return $this->hasMany(Upazila::class);
    }

    public static function getAllZillas() 
    {
        $disticts = self::orderBy('name', 'ASC')->get();
        return $disticts;
    }
}
