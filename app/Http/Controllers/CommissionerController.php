<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommissionerController extends Controller
{
    public function index()
    {
        return view('commissioner.dashboard');
    }
}
