<?php

namespace App\Http\Controllers\MedicineVital;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    public function dashboard(){
        return view('medicinevital.dashboard');
    }
}
