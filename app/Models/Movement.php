<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Stock;

class Movement extends Model
{
    use HasFactory;

    protected $fillable = [
        'tin',
        'move_date',
        'office_name',
        'receive_date',
        'assessment_year',
        'circle',
    ];

    public function stock()
    {
        return $this->belongsTo(Stock::class, 'tin', 'tin');
    }
}
