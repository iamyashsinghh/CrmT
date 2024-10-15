<?php

namespace App\Http\Controllers\Lab;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LabController extends Controller
{
    public function dashboard(){
        return view('lab.dashboard');
    }
}
