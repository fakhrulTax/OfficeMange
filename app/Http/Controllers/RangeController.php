<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\MyHelper;
use App\Models\Arrear;
use Illuminate\Support\Facades\Auth;
class RangeController extends Controller
{
    public function index()
    {
        return view('range.dashboard');
    }
}
