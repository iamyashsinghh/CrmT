<?php

namespace App\Http\Controllers\PostSales;

use App\Http\Controllers\Controller;
use App\Models\Cases;
use App\Models\Query;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CaseController extends Controller
{
    public function index($dashboard_filters = null)
    {
        $page_heading = 'Cases';
        $filter_params = "";
        if ($dashboard_filters !== null) {
            $filter_params = ['dashboard_filters' => $dashboard_filters];
            $page_heading = ucwords(str_replace("_", " ", $dashboard_filters));
        }
        return view('postsales.case.index', compact('page_heading', 'filter_params'));
    }

    public function ajax_list(Request $request)
    {
        $auth_user = Auth::guard('PostSales')->user();
        $cases = Cases::select([
            'cases.id',
            'cases.case_code',
            'cases.name',
            'cases.age',
            'cases.member_id',
            'cases.corp',
            'cases.relation',
            'cases.gender',
            'cases.doa',
            'cases.dod',
            'cases.created_by'
        ])
            ->with(['user:id,f_name'])
            ->where(function ($query) use ($auth_user) {
                $query->where('assign_member_id', $auth_user->id)
                      ->orWhere('assign_member_post_sales', $auth_user->id);
            });

            if ($request->dashboard_filters != null) {

                if ($request->dashboard_filters == "main_claim_cases") {
                    $cases->where('is_post_1', 0);
                }elseif ($request->dashboard_filters == "main_claim_cases_query") {
                    $cases->where('is_post_1', 0)->where(['status' => 'Query']);
                }elseif ($request->dashboard_filters == "main_claim_cases_investigation") {
                    $cases->where('is_post_1', 0)->where(['status' => 'Investigation']);
                }elseif ($request->dashboard_filters == "main_claim_cases_reject") {
                    $cases->where('is_post_1', 0)->where(['status' => 'Reject']);
                }elseif ($request->dashboard_filters == "main_claim_cases_underprocess") {
                    $cases->where('is_post_1', 0)->where(['status' => 'UnderProcess']);
                }elseif ($request->dashboard_filters == "main_claim_cases_approved") {
                    $cases->where('is_post_1', 0)->where(['status' => 'Approved']);
                }elseif ($request->dashboard_filters == "main_claim_cases_paid") {
                    $cases->where('is_post_1', 0)->where(['status' => 'Paid']);

                }elseif ($request->dashboard_filters == "post_claim_cases") {
                    $cases->where('is_post_1', 1);
                }elseif ($request->dashboard_filters == "post_claim_cases_query") {
                    $cases->where('is_post_1', 1)->where(['post_status' => 'Query']);
                }elseif ($request->dashboard_filters == "post_claim_cases_investigation") {
                    $cases->where('is_post_1', 1)->where(['post_status' => 'Investigation']);
                }elseif ($request->dashboard_filters == "post_claim_cases_reject") {
                    $cases->where('is_post_1', 1)->where(['post_status' => 'Reject']);
                }elseif ($request->dashboard_filters == "post_claim_cases_underprocess") {
                    $cases->where('is_post_1', 1)->where(['post_status' => 'UnderProcess']);
                }elseif ($request->dashboard_filters == "post_claim_cases_approved") {
                    $cases->where('is_post_1', 1)->where(['post_status' => 'Approved']);
                }elseif ($request->dashboard_filters == "post_claim_cases_paid") {
                    $cases->where('is_post_1', 1)->where(['post_status' => 'Paid']);

                }elseif ($request->dashboard_filters == "post_two_claim_cases") {
                    $cases->where('is_post_2', 1);
                }elseif ($request->dashboard_filters == "post_two_claim_cases_query") {
                    $cases->where('is_post_2', 1)->where(['post_two_status' => 'Query']);
                }elseif ($request->dashboard_filters == "post_two_claim_cases_investigation") {
                    $cases->where('is_post_2', 1)->where(['post_two_status' => 'Investigation']);
                }elseif ($request->dashboard_filters == "post_two_claim_cases_reject") {
                    $cases->where('is_post_2', 1)->where(['post_two_status' => 'Reject']);
                }elseif ($request->dashboard_filters == "post_two_claim_cases_underprocess") {
                    $cases->where('is_post_2', 1)->where(['post_two_status' => 'UnderProcess']);
                }elseif ($request->dashboard_filters == "post_two_claim_cases_approved") {
                    $cases->where('is_post_2', 1)->where(['post_two_status' => 'Approved']);
                }elseif ($request->dashboard_filters == "post_two_claim_cases_paid") {
                    $cases->where('is_post_2', 1)->where(['post_two_status' => 'Paid']);
                }
            }

        return dataTables()->of($cases)
            ->addColumn('created_by', function ($case) {
                return $case->user ? $case->user->f_name : 'N/A';
            })
            ->addColumn('actions', function ($case) {
                return '<a href="' . route('postsales.case.show', $case->id) . '" class="btn btn-info">View</a>';
            })
            ->make(true);
    }

    public function show($id)
    {
        $case = Cases::findOrFail($id);
        $tpa_roles = User::where('role_id', 8)->get();
        return view('postsales.case.show', compact('case', 'tpa_roles'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'claim_no' => 'required|string',
            'approved_amt' => 'required|string',
            'status' => 'nullable|string',
            'patient_details_form' => 'nullable|file|mimes:jpg,jpeg,png,pdf,xls,webp,xlsx,docx,doc|max:2048',
        ]);
        $case = Cases::findOrFail($id);
        $case->claim_no = $request->claim_no;
        $case->status = $request->status;
        $case->approved_amt = $request->approved_amt;

        $get_the_tpa_commission_type = $case->tpa_type;
        $tpa1 = $case->tpa_allot_after_claim_no_received;
        $tpa2 = $case->tpa_allot_after_claim_no_received_two;
        $no_commission_tpa = $case->no_commission_tpa ?? [];

        if ($request->status == 'Investigation') {
            if ($get_the_tpa_commission_type === 'direct') {
                if (!in_array($tpa1, $no_commission_tpa)) {
                    $no_commission_tpa[] = $tpa1;
                }
            } elseif ($get_the_tpa_commission_type === 'first') {
                if (!in_array($tpa1, $no_commission_tpa)) {
                    $no_commission_tpa[] = $tpa1;
                }
                if (!in_array($tpa2, $no_commission_tpa)) {
                    $no_commission_tpa[] = $tpa2;
                }
            }
        }
        $case->no_commission_tpa = $no_commission_tpa;

        if ($request->status == 'Paid') {
            $approvedAmt = $request->approved_amt;

            $mainVendorUser = User::where('id', $case->created_by)->first();
            if ($mainVendorUser) {
                $commissionMain = ($mainVendorUser->commission_main / 100) * $approvedAmt;
                $case->commission_vendor = $commissionMain;
                $mainVendorUser->wallet -= $commissionMain;
                $mainVendorUser->save();
            }

            if ($get_the_tpa_commission_type === 'direct') {
                $mainTpaUser = User::where('id', $case->tpa_allot_after_claim_no_received)->first();
                if ($mainTpaUser  && !in_array($tpa1, $no_commission_tpa)) {
                    $commissionMain = ($mainTpaUser->commission_main / 100) * $approvedAmt;
                    $case->commission_main_tpa = $commissionMain;
                    $mainTpaUser->wallet += $commissionMain;
                    $mainTpaUser->save();
                } else {
                    $case->commission_main_tpa = 0;
                }
            } elseif ($get_the_tpa_commission_type === 'first') {
                $firstTpaUser = User::where('id', $tpa1)->first();
                $secondTpaUser = User::where('id', $tpa2)->first();

                if ($firstTpaUser && !in_array($tpa1, $no_commission_tpa)) {
                    $commissionFirst = ($firstTpaUser->commission_first / 100) * $approvedAmt;
                    $case->commission_first_tpa = $commissionFirst;
                    $firstTpaUser->wallet += $commissionFirst;
                    $firstTpaUser->save();
                } else {
                    $case->commission_first_tpa = 0;
                }

                if ($secondTpaUser && !in_array($tpa2, $no_commission_tpa)) {
                    $commissionSecond = ($secondTpaUser->commission_second / 100) * $approvedAmt;
                    $case->commission_second_tpa = $commissionSecond;
                    $secondTpaUser->wallet += $commissionSecond;
                    $secondTpaUser->save();
                } else {
                    $case->commission_second_tpa = 0;
                }
            }
        }
        if ($request->hasFile('patient_details_form')) {
            $case->patient_details_form = $request->file('patient_details_form')->store('attachments', 'public');
        }
        $case->save();
        return response()->json([
            'success' => true,
            'message' => 'Case updated successfully!',
        ]);
    }

    public function update_files(Request $request, $id)
    {
        $request->validate([
            'patient_details_form' => 'nullable|file|mimes:jpg,jpeg,png,pdf,xls,webp,xlsx,docx,doc|max:15360',
            'icp_attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,xls,webp,xlsx,docx,doc|max:15360',
            'medicine_vitals_attached' => 'nullable|file|mimes:jpg,jpeg,png,pdf,xls,webp,xlsx,docx,doc|max:15360',
            'medicine_detail' => 'nullable|file|mimes:jpg,jpeg,png,pdf,xls,webp,xlsx,docx,doc|max:15360',
            'aadhar_attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,xls,webp,xlsx,docx,doc|max:15360',
            'aadhar_attachment_2' => 'nullable|file|mimes:jpg,jpeg,png,pdf,xls,webp,xlsx,docx,doc|max:15360',
            'pan_card' => 'nullable|file|mimes:jpg,jpeg,png,pdf,xls,webp,xlsx,docx,doc|max:15360',
            'cancelled_cheque' => 'nullable|file|mimes:jpg,jpeg,png,pdf,xls,webp,xlsx,docx,doc|max:15360',
            'policy' => 'nullable|file|mimes:jpg,jpeg,png,pdf,xls,webp,xlsx,docx,doc|max:15360',
            'bill_attachment_1' => 'nullable|file|mimes:jpg,jpeg,png,pdf,xls,webp,xlsx,docx,doc|max:15360',
            'discharge_summary_attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,xls,webp,xlsx,docx,doc|max:15360',
        ]);
        $case = Cases::findOrFail($id);

        if ($request->hasFile('patient_details_form')) {
            $case->patient_details_form = $request->file('patient_details_form')->store('attachments', 'public');
        }
        if ($request->hasFile('icp_attachment')) {
            $case->icp_attachment = $request->file('icp_attachment')->store('attachments', 'public');
        }
        if ($request->hasFile('medicine_vitals_attached')) {
            $case->medicine_vitals_attached = $request->file('medicine_vitals_attached')->store('attachments', 'public');
        }
        if ($request->hasFile('medicine_detail')) {
            $case->medicine_detail = $request->file('medicine_detail')->store('attachments', 'public');
        }
        if ($request->hasFile('aadhar_attachment')) {
            $case->aadhar_attachment = $request->file('aadhar_attachment')->store('attachments', 'public');
        }
        if ($request->hasFile('aadhar_attachment_2')) {
            $case->aadhar_attachment_2 = $request->file('aadhar_attachment_2')->store('attachments', 'public');
        }
        if ($request->hasFile('pan_card')) {
            $case->pan_card = $request->file('pan_card')->store('attachments', 'public');
        }
        if ($request->hasFile('cancelled_cheque')) {
            $case->cancelled_cheque = $request->file('cancelled_cheque')->store('attachments', 'public');
        }
        if ($request->hasFile('policy')) {
            $case->policy = $request->file('policy')->store('attachments', 'public');
        }
        if ($request->hasFile('bill_attachment_1')) {
            $case->bill_attachment_1 = $request->file('bill_attachment_1')->store('attachments', 'public');
        }
        if ($request->hasFile('discharge_summary_attachment')) {
            $case->discharge_summary_attachment = $request->file('discharge_summary_attachment')->store('attachments', 'public');
        }

        $case->save();
        return response()->json([
            'success' => true,
            'message' => 'Case files updated successfully!',
        ]);
    }

    public function query_add(Request $request)
    {
        $request->validate([
            'query' => 'required|string',
            'case_id' => 'required|integer',
            'query_pdf' => 'nullable|file|mimes:jpg,jpeg,png,pdf,xls,webp,xlsx,docx,doc|max:2048',
        ]);

        $auth_user = Auth::guard('PostSales')->user();

        $query = new Query();
        $query->case_id = $request->input('case_id');
        $query->created_by = $auth_user->id;
        $query->query = $request->input('query');

        if ($request->hasFile('query_pdf')) {
            $filePath = $request->file('query_pdf')->store('attachments', 'public');
            $query->query_pdf = $filePath;
        }

        try {
            $query->save();
            session()->flash('status', [
                'success' => true,
                'alert_type' => 'success',
                'message' => "Query Created.",
            ]);
        } catch (\Exception $e) {
            session()->flash('status', [
                'success' => false,
                'alert_type' => 'error',
                'message' => "Internal server error occurred.",
            ]);
        }

        return redirect()->back();
    }


    public function update_post_one(Request $request, $id)
    {
        $request->validate([
            'post_claim_no' => 'required|string',
            'post_ammount' => 'required|string',
            'post_status' => 'nullable|string',
            'post_patient_details_form' => 'nullable|file|mimes:jpg,jpeg,png,pdf,xls,webp,xlsx,docx,doc|max:2048',
        ]);
        $case = Cases::findOrFail($id);
        $case->post_claim_no = $request->post_claim_no;
        $case->post_ammount = $request->post_ammount;
        $case->post_status = $request->post_status;

        $get_the_tpa_commission_type = $case->tpa_type;
        $tpa1 = $case->tpa_allot_after_claim_no_received;
        $tpa2 = $case->tpa_allot_after_claim_no_received_two;
        $post_no_commission_tpa = $case->post_no_commission_tpa ?? [];

        if ($request->post_status == 'Investigation') {
            if ($get_the_tpa_commission_type === 'direct') {
                if (!in_array($tpa1, $post_no_commission_tpa)) {
                    $post_no_commission_tpa[] = $tpa1;
                }
            } elseif ($get_the_tpa_commission_type === 'first') {
                if (!in_array($tpa1, $post_no_commission_tpa)) {
                    $post_no_commission_tpa[] = $tpa1;
                }
                if (!in_array($tpa2, $post_no_commission_tpa)) {
                    $post_no_commission_tpa[] = $tpa2;
                }
            }
        }
        $case->post_no_commission_tpa = $post_no_commission_tpa;

        if ($request->post_status == 'Paid') {
            $approvedAmt = $request->post_ammount;

            $mainVendorUser = User::where('id', $case->created_by)->first();
            if ($mainVendorUser) {
                $commissionMain = ($mainVendorUser->commission_main / 100) * $approvedAmt;
                $case->commission_vendor = $commissionMain;
                $mainVendorUser->wallet -= $commissionMain;
                $mainVendorUser->save();
            }

            if ($get_the_tpa_commission_type === 'direct') {
                $mainTpaUser = User::where('id', $case->tpa_allot_after_claim_no_received)->first();
                if ($mainTpaUser  && !in_array($tpa1, $post_no_commission_tpa)) {
                    $commissionMain = ($mainTpaUser->commission_main / 100) * $approvedAmt;
                    $case->commission_main_tpa = $commissionMain;
                    $mainTpaUser->wallet += $commissionMain;
                    $mainTpaUser->save();
                } else {
                    $case->commission_main_tpa = 0;
                }
            } elseif ($get_the_tpa_commission_type === 'first') {
                $firstTpaUser = User::where('id', $tpa1)->first();
                $secondTpaUser = User::where('id', $tpa2)->first();

                if ($firstTpaUser && !in_array($tpa1, $post_no_commission_tpa)) {
                    $commissionFirst = ($firstTpaUser->commission_first / 100) * $approvedAmt;
                    $case->commission_first_tpa = $commissionFirst;
                    $firstTpaUser->wallet += $commissionFirst;
                    $firstTpaUser->save();
                } else {
                    $case->commission_first_tpa = 0;
                }

                if ($secondTpaUser && !in_array($tpa2, $post_no_commission_tpa)) {
                    $commissionSecond = ($secondTpaUser->commission_second / 100) * $approvedAmt;
                    $case->commission_second_tpa = $commissionSecond;
                    $secondTpaUser->wallet += $commissionSecond;
                    $secondTpaUser->save();
                } else {
                    $case->commission_second_tpa = 0;
                }
            }
        }
        if ($request->hasFile('post_patient_details_form')) {
            $case->post_patient_details_form = $request->file('post_patient_details_form')->store('attachments', 'public');
        }
        $case->save();
        return response()->json([
            'success' => true,
            'message' => 'Case updated successfully!',
        ]);
    }
    public function update_post_two(Request $request, $id)
    {
        $request->validate([
            'post_two_claim_no' => 'required|string',
            'post_two_ammount' => 'required|string',
            'post_two_status' => 'nullable|string',
            'post_two_patient_details_form' => 'nullable|file|mimes:jpg,jpeg,png,pdf,xls,webp,xlsx,docx,doc|max:2048',
        ]);
        $case = Cases::findOrFail($id);
        $case->post_two_claim_no = $request->post_two_claim_no;
        $case->post_two_ammount = $request->post_two_ammount;
        $case->post_two_status = $request->post_two_status;

        $get_the_tpa_commission_type = $case->tpa_type;
        $tpa1 = $case->tpa_allot_after_claim_no_received;
        $tpa2 = $case->tpa_allot_after_claim_no_received_two;
        $post_two_no_commission_tpa = $case->post_two_no_commission_tpa ?? [];

        if ($request->post_two_status == 'Investigation') {
            if ($get_the_tpa_commission_type === 'direct') {
                if (!in_array($tpa1, $post_two_no_commission_tpa)) {
                    $post_two_no_commission_tpa[] = $tpa1;
                }
            } elseif ($get_the_tpa_commission_type === 'first') {
                if (!in_array($tpa1, $post_two_no_commission_tpa)) {
                    $post_two_no_commission_tpa[] = $tpa1;
                }
                if (!in_array($tpa2, $post_two_no_commission_tpa)) {
                    $post_two_no_commission_tpa[] = $tpa2;
                }
            }
        }
        $case->post_two_no_commission_tpa = $post_two_no_commission_tpa;

        if ($request->post_two_status == 'Paid') {
            $approvedAmt = $request->post_two_ammount;

            $mainVendorUser = User::where('id', $case->created_by)->first();
            if ($mainVendorUser) {
                $commissionMain = ($mainVendorUser->commission_main / 100) * $approvedAmt;
                $case->commission_vendor = $commissionMain;
                $mainVendorUser->wallet -= $commissionMain;
                $mainVendorUser->save();
            }

            if ($get_the_tpa_commission_type === 'direct') {
                $mainTpaUser = User::where('id', $case->tpa_allot_after_claim_no_received)->first();
                if ($mainTpaUser  && !in_array($tpa1, $post_two_no_commission_tpa)) {
                    $commissionMain = ($mainTpaUser->commission_main / 100) * $approvedAmt;
                    $case->commission_main_tpa = $commissionMain;
                    $mainTpaUser->wallet += $commissionMain;
                    $mainTpaUser->save();
                } else {
                    $case->commission_main_tpa = 0;
                }
            } elseif ($get_the_tpa_commission_type === 'first') {
                $firstTpaUser = User::where('id', $tpa1)->first();
                $secondTpaUser = User::where('id', $tpa2)->first();

                if ($firstTpaUser && !in_array($tpa1, $post_two_no_commission_tpa)) {
                    $commissionFirst = ($firstTpaUser->commission_first / 100) * $approvedAmt;
                    $case->commission_first_tpa = $commissionFirst;
                    $firstTpaUser->wallet += $commissionFirst;
                    $firstTpaUser->save();
                } else {
                    $case->commission_first_tpa = 0;
                }

                if ($secondTpaUser && !in_array($tpa2, $post_two_no_commission_tpa)) {
                    $commissionSecond = ($secondTpaUser->commission_second / 100) * $approvedAmt;
                    $case->commission_second_tpa = $commissionSecond;
                    $secondTpaUser->wallet += $commissionSecond;
                    $secondTpaUser->save();
                } else {
                    $case->commission_second_tpa = 0;
                }
            }
        }
        if ($request->hasFile('post_two_patient_details_form')) {
            $case->post_two_patient_details_form = $request->file('post_two_patient_details_form')->store('attachments', 'public');
        }
        $case->save();
        return response()->json([
            'success' => true,
            'message' => 'Case updated successfully!',
        ]);
    }
}
