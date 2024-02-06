<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organization;

class OrganizationController extends Controller
{
    public function organizations(){

       //retrive relationship data from Organizaion table using privot table
       $orgs = Organization::all()->load('upazilas');

        return view('commissioner.tds.index', compact('orgs'));
    }
}
