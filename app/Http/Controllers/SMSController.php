<?php

namespace App\Http\Controllers;
use App\Models\SMSModel;

use Illuminate\Http\Request;

class SMSController extends Controller
{
    public function index(){

        $smsInfo = SMSModel::all();
        return view('commissioner.sms.index', compact('smsInfo'));
    }
}
