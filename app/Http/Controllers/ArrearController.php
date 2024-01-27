<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArrearController extends Controller
{
    public function index()
    {
        $arrears = Arrear::all();
        return view('circle.arrear.index', compact('arrears'));
    }
}
