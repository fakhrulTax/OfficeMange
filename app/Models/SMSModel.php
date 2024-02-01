<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SMSModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'sms_body',
        'receiver_number',
        'response',
        'sms_type'

    ];

}
