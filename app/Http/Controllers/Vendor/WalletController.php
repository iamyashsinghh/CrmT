<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    public function index()
    {
        $page_heading = 'Wallets';
        return view('vendor.wallets.index', compact('page_heading'));
    }

    public function ajax()
    {
        $auth_user = Auth::guard('Vendor')->user();
        $wallets = Wallet::where('user_id', $auth_user->id)->get();

        return datatables()->of($wallets)
            ->make(true);
    }
}
