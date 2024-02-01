<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Collection;

class Stock extends Model
{
    use HasFactory;

    public function collections()
    {
        return $this->hasMany(Collection::class, 'tin', 'tin');
    }

    //TIN Check
    public static function stockCheck($tin)
    {
        $stock = self::where('tin', '=', $tin)->first();       
        return $stock;
    }


    protected $fillable = [
        'tin',
        'name',
        'sort_name',
        'email',
        'mobile',
        'bangla_name',
        'type',
        'file_in_stock',
        'file_rack',
        'circle',
        'address',
        'last_return'
    ];
}
