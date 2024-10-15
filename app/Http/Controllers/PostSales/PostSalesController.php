<?php

namespace App\Http\Controllers\PostSales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostSalesController extends Controller
{
    public function dashboard(){
        return view('postsales.dashboard');
    }
}
