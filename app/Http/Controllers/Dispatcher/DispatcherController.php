<?php

namespace App\Http\Controllers\Dispatcher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DispatcherController extends Controller
{
    public function dashboard(){
        return view('dispatcher.dashboard');
    }
}
