<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TechnicalController extends Controller
{
    public function index()
    {
        return view('technical.dashboard');
    }
}
