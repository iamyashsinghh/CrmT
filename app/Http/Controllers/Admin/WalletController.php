<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class WalletController extends Controller
{

    public function index()
    {
        $page_heading = 'Wallets';
        $users = User::where('role_id', 8)->get();
        // return $users;
        return view('admin.wallets.index', compact('page_heading', 'users'));
    }

    public function ajax()
    {
        $wallets = Wallet::with(['user:id,f_name,l_name'])->get();

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
            'user_id' => 'required',
            'amount' => 'required|numeric',
            'payment_proof' => 'required|file',
            'payment_type' => 'required|string',
        ]);

        $auth_user = Auth::guard('Admin')->user();

        $user = User::where('id', $request->user_id)->first();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found.'], 404);
        }

        if ($user->wallet < $request->amount) {
            return response()->json(['success' => false, 'message' => 'Insufficient wallet balance.'], 400);
        }

        $user->wallet -= $request->amount;

        $wallet = new Wallet();
        $wallet->user_id = $request->user_id;
        $wallet->paid_by = $auth_user->id;
        $wallet->ammount = $request->amount;
        $wallet->payment_type = $request->payment_type;
        $wallet->msg = $request->msg;

        if ($request->hasFile('payment_proof')) {
            $wallet->payment_proof = $request->file('payment_proof')->store('payment_proofs', 'public');
        }

        $wallet->save();
        $user->save();

        return response()->json(['success' => true, 'message' => 'Wallet entry created successfully!']);
    }
}
