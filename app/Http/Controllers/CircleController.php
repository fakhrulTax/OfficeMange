<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CircleController extends Controller
{
    public function index()
    {
        return view('circle.dashboard');
    }
}
