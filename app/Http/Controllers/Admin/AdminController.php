<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cases;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard(){

        $main_claim_cases = Cases::where('is_post_1', 0)
        ->where(['forward_status' => 0, 'forward_status_remark'=> null])
        ->count();
        $main_claim_cases_query = Cases::where('is_post_1', 0)
        ->where(['status' => 'Query'])
        ->count();
        $main_claim_cases_investigation = Cases::where('is_post_1', 0)
        ->where(['status' => 'Investigation'])
        ->count();
        $main_claim_cases_reject = Cases::where('is_post_1', 0)
        ->where(['status' => 'Reject'])
        ->count();
        $main_claim_cases_underprocess = Cases::where('is_post_1', 0)
        ->where(['status' => 'UnderProcess'])
        ->count();
        $main_claim_cases_approved = Cases::where('is_post_1', 0)
        ->where(['status' => 'Approved'])
        ->count();
        $main_claim_cases_paid = Cases::where('is_post_1', 0)
        ->where(['status' => 'Paid'])
        ->count();


        $post_claim_cases = Cases::where('is_post_1', 1)
        ->count();
        $post_claim_cases_query = Cases::where('is_post_1', 1)
        ->where(['post_status' => 'Query'])
        ->count();
        $post_claim_cases_investigation = Cases::where('is_post_1', 1)
        ->where(['post_status' => 'Investigation'])
        ->count();
        $post_claim_cases_reject = Cases::where('is_post_1', 1)
        ->where(['post_status' => 'Reject'])
        ->count();
        $post_claim_cases_underprocess = Cases::where('is_post_1', 1)
        ->where(['post_status' => 'UnderProcess'])
        ->count();
        $post_claim_cases_approved = Cases::where('is_post_1', 1)
        ->where(['post_status' => 'Approved'])
        ->count();
        $post_claim_cases_paid = Cases::where('is_post_1', 1)
        ->where(['post_status' => 'Paid'])
        ->count();


        $post_two_claim_cases = Cases::where('is_post_2', 1)
        ->count();
        $post_two_claim_cases_query = Cases::where('is_post_2', 1)
        ->where(['post_two_status' => 'Query'])
        ->count();
        $post_two_claim_cases_investigation = Cases::where('is_post_2', 1)
        ->where(['post_two_status' => 'Investigation'])
        ->count();
        $post_two_claim_cases_reject = Cases::where('is_post_2', 1)
        ->where(['post_two_status' => 'Reject'])
        ->count();
        $post_two_claim_cases_underprocess = Cases::where('is_post_2', 1)
        ->where(['post_two_status' => 'UnderProcess'])
        ->count();
        $post_two_claim_cases_approved = Cases::where('is_post_2', 1)
        ->where(['post_two_status' => 'Approved'])
        ->count();
        $post_two_claim_cases_paid = Cases::where('is_post_2', 1)
        ->where(['post_two_status' => 'Paid'])
        ->count();

        return view('admin.dashboard', compact(
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
