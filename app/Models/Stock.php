<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Collection;
use App\Models\Advance;
use App\Models\Retarn;
use App\Models\Reopen;
use App\Models\Audit;

class Stock extends Model
{
    use HasFactory;

    public function retarns()
    {
        return $this->hasMany(Retarn::class, 'tin', 'tin'); // Assuming 'tin' is the foreign key
    }

    public function reopens()
    {
        return $this->hasMany(Reopen::class, 'tin', 'tin'); // Assuming 'tin' is the foreign key
    }

    public function audits()
    {
        return $this->hasMany(Audit::class, 'tin', 'tin'); // Assuming 'tin' is the foreign key
    }

    public function collections()
    {
        return $this->hasMany(Collection::class, 'tin', 'tin');
    }

    public function advnaces()
    {
        return $this->hasMany(Advance::class, 'tin', 'tin');
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
