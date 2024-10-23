<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Cases;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorController extends Controller
{
    public function dashboard(){
        $auth_user = Auth::guard('Vendor')->user();

        $main_claim_cases = Cases::where('is_post_1', 0)
        ->where('created_by', $auth_user->id)
        ->count();
        $main_claim_cases_query = Cases::where('is_post_1', 0)
        ->where(['status' => 'Query'])
        ->where('created_by', $auth_user->id)
        ->count();
        $main_claim_cases_investigation = Cases::where('is_post_1', 0)
        ->where(['status' => 'Investigation'])
        ->where('created_by', $auth_user->id)
        ->count();
        $main_claim_cases_reject = Cases::where('is_post_1', 0)
        ->where(['status' => 'Reject'])
        ->where('created_by', $auth_user->id)
        ->count();
        $main_claim_cases_underprocess = Cases::where('is_post_1', 0)
        ->where(['status' => 'UnderProcess'])
        ->where('created_by', $auth_user->id)
        ->count();
        $main_claim_cases_approved = Cases::where('is_post_1', 0)
        ->where(['status' => 'Approved'])
        ->where('created_by', $auth_user->id)
        ->count();
        $main_claim_cases_paid = Cases::where('is_post_1', 0)
        ->where(['status' => 'Paid'])
        ->where('created_by', $auth_user->id)
        ->count();


        $post_claim_cases = Cases::where('is_post_1', 1)
        ->where('created_by', $auth_user->id)
        ->count();
        $post_claim_cases_query = Cases::where('is_post_1', 1)
        ->where(['post_status' => 'Query'])
        ->where('created_by', $auth_user->id)
        ->count();
        $post_claim_cases_investigation = Cases::where('is_post_1', 1)
        ->where(['post_status' => 'Investigation'])
        ->where('created_by', $auth_user->id)
        ->count();
        $post_claim_cases_reject = Cases::where('is_post_1', 1)
        ->where(['post_status' => 'Reject'])
        ->where('created_by', $auth_user->id)
        ->count();
        $post_claim_cases_underprocess = Cases::where('is_post_1', 1)
        ->where(['post_status' => 'UnderProcess'])
        ->where('created_by', $auth_user->id)
        ->count();
        $post_claim_cases_approved = Cases::where('is_post_1', 1)
        ->where(['post_status' => 'Approved'])
        ->where('created_by', $auth_user->id)
        ->count();
        $post_claim_cases_paid = Cases::where('is_post_1', 1)
        ->where(['post_status' => 'Paid'])
        ->where('created_by', $auth_user->id)
        ->count();


        $post_two_claim_cases = Cases::where('is_post_2', 1)
        ->where('created_by', $auth_user->id)
        ->count();
        $post_two_claim_cases_query = Cases::where('is_post_2', 1)
        ->where(['post_two_status' => 'Query'])
        ->where('created_by', $auth_user->id)
        ->count();
        $post_two_claim_cases_investigation = Cases::where('is_post_2', 1)
        ->where(['post_two_status' => 'Investigation'])
        ->where('created_by', $auth_user->id)
        ->count();
        $post_two_claim_cases_reject = Cases::where('is_post_2', 1)
        ->where(['post_two_status' => 'Reject'])
        ->where('created_by', $auth_user->id)
        ->count();
        $post_two_claim_cases_underprocess = Cases::where('is_post_2', 1)
        ->where(['post_two_status' => 'UnderProcess'])
        ->where('created_by', $auth_user->id)
        ->count();
        $post_two_claim_cases_approved = Cases::where('is_post_2', 1)
        ->where(['post_two_status' => 'Approved'])
        ->where('created_by', $auth_user->id)
        ->count();
        $post_two_claim_cases_paid = Cases::where('is_post_2', 1)
        ->where(['post_two_status' => 'Paid'])
        ->where('created_by', $auth_user->id)
        ->count();

        return view('vendor.dashboard', compact(
            'main_claim_cases',
            'main_claim_cases_query',
            'main_claim_cases_investigation',
            'main_claim_cases_reject',
            'main_claim_cases_underprocess',
            'main_claim_cases_approved',
            'main_claim_cases_paid',

            'post_claim_cases',
            'post_claim_cases_query',
            'post_claim_cases_investigation',
            'post_claim_cases_reject',
            'post_claim_cases_underprocess',
            'post_claim_cases_approved',
            'post_claim_cases_paid',

            'post_two_claim_cases',
            'post_two_claim_cases_query',
            'post_two_claim_cases_investigation',
            'post_two_claim_cases_reject',
            'post_two_claim_cases_underprocess',
            'post_two_claim_cases_approved',
            'post_two_claim_cases_paid',
        ));
    }
}
