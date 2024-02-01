<?php

namespace App\Http\Controllers;
use App\Models\SMSModel;
use Toastr;

use Illuminate\Http\Request;

class SMSController extends Controller
{
    public function index(){

        $smsInfo = SMSModel::all();
        return view('commissioner.sms.index', compact('smsInfo'));
    }


    public function delete($id){

        $smsInfo = SMSModel::find($id);
        $smsInfo->delete();
        Toastr::success('SMS deleted successfully', 'Success');
        return redirect()->back();
    }
}
