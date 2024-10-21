<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\VendorsWallet;
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
        $wallets = VendorsWallet::where('user_id', $auth_user->id)->with(['user:id,f_name,l_name'])->get();

        return datatables()->of($wallets)
            ->addColumn('paid_by_name', function ($wallet) {
                $paidByUser = User::find($wallet->paid_by);
                return $paidByUser ? $paidByUser->f_name : 'N/A';
            })
            ->addColumn('actions', function ($wallet) {
                return '<button class="btn btn-sm btn-danger delete-wallet" data-id="' . $wallet->id . '">Delete</button>';
            })
            ->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'payment_proof' => 'required|file',
            'payment_type' => 'required|string',
        ]);

        $auth_user = Auth::guard('Vendor')->user();

        $wallet = new VendorsWallet();
        $wallet->user_id = $auth_user->id;
        $wallet->paid_by = $auth_user->id;
        $wallet->ammount = $request->amount;
        $wallet->payment_type = $request->payment_type;
        $wallet->msg = $request->msg;
        $wallet->is_approved = 0;

        if ($request->hasFile('payment_proof')) {
            $wallet->payment_proof = $request->file('payment_proof')->store('payment_proofs', 'public');
        }

        $wallet->save();

        return response()->json(['success' => true, 'message' => 'Wallet entry created successfully!']);
    }

}
