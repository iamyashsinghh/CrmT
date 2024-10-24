<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Cases;
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
        return view('vendor.case.index', compact('page_heading', 'filter_params'));
    }

    public function ajax_list(Request $request)
    {
        $auth_user = Auth::guard('Vendor')->user();

        $cases = Cases::select([
            'id',
            'case_code',
            'name',
            'age',
            'member_id',
            'corp',
            'relation',
            'gender',
            'doa',
            'dod',
        ])->where('created_by', $auth_user->id);
        if ($request->dashboard_filters != null) {

            if ($request->dashboard_filters == "main_claim_cases_query") {
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
            ->addColumn('actions', function ($case) {
                return '<a href="' . route('vendor.case.show', $case->id) . '" class="btn btn-info">View</a>';
            })
            ->make(true);
    }

    public function store(Request $request)
    {
        $auth_user = Auth::guard('Vendor')->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'member_id' => 'required|string|max:255',
            'age' => 'required|integer',
            'gender' => 'required|in:Male,Female,Other',
            'doa' => 'nullable|date',
            'doa_time' => 'nullable|date_format:H:i',
            'dod' => 'nullable|date',
            'dod_time' => 'nullable|date_format:H:i',
            'corp' => 'nullable|string|max:255',
            'relation' => 'nullable|string|max:255',
            'aadhar_attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,xls,webp,xlsx,docx,doc|max:2048',
            'aadhar_attachment_2' => 'nullable|file|mimes:jpg,jpeg,png,pdf,xls,webp,xlsx,docx,doc|max:2048',
            'pan_card' => 'nullable|file|mimes:jpg,jpeg,png,pdf,xls,webp,xlsx,docx,doc|max:2048',
            'cancelled_cheque' => 'nullable|file|mimes:jpg,jpeg,png,pdf,xls,webp,xlsx,docx,doc|max:2048',
            'policy' => 'nullable|file|mimes:jpg,jpeg,png,pdf,xls,webp,xlsx,docx,doc|max:2048',
        ]);

        $validated['created_by'] = $auth_user->id;

        $case = Cases::create($validated);

        $case->case_code = "case_000$case->id";


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

        $case->save();



        return response()->json(['success' => true, 'message' => 'Case created successfully!']);
    }

    public function show($id)
    {
        $case = Cases::findOrFail($id);
        $assign_member = User::where('id', $case->assign_member_id)->first();

        $query_status = '';
        if ($case->forward_status == 0 && $case->forward_status_remark == null) {
            $query_status = 'Pending';
        } else if ($case->forward_status == 1) {
            $user = User::where('id', $case->assign_member_id)->first();
            if ($user->role_id == 2) {
                $query_status = 'Forwarded To Sales Department';
            } elseif ($user->role_id == 3) {
                $query_status = 'Forwarded To Doctor Department';
            } elseif ($user->role_id == 4) {
                $query_status = 'Forwarded To Medical Department';
            } elseif ($user->role_id == 5) {
                $query_status = 'Forwarded To Billing Department';
            } elseif ($user->role_id == 6) {
                $query_status = 'Forwarded To Lab Department';
            } elseif ($user->role_id == 7) {
                $query_status = 'Forwarded To Dispatch Department';
            } elseif ($user->role_id == 9) {
                $query_status = "Case Status: " . ($case->status ?? 'Processing');
            }
        } else if ($case->forward_status == 0 && $case->forward_status_remark !== null) {
            $query_status = "Hold -- Reason: $case->forward_status_remark";
        } elseif ($case->forward_status == 2 && $case->forward_status_remark !== null) {
            $query_status = "Hold -- Reason: $case->forward_status_remark";
        }

        return view('vendor.case.show', compact('case', 'query_status', 'assign_member'));
    }




    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|integer',
            'corp' => 'required|string|max:255',
            'member_id' => 'required|string|max:255',
            'relation' => 'required|string|max:255',
            'gender' => 'required|string',
            'doa' => 'required|date',
            'doa_time' => 'required',
            'tpa' => 'required',
            'dod' => 'required|date',
            'dod_time' => 'required',
            'aadhar_attachment' => 'required|file|mimes:jpg,jpeg,png,pdf,xls,webp,xlsx,docx,doc|max:2048',
            'aadhar_attachment_2' => 'required|file|mimes:jpg,jpeg,png,pdf,xls,webp,xlsx,docx,doc|max:2048',
            'pan_card' => 'required|file|mimes:jpg,jpeg,png,pdf,xls,webp,xlsx,docx,doc|max:2048',
            'cancelled_cheque' => 'required|file|mimes:jpg,jpeg,png,pdf,xls,webp,xlsx,docx,doc|max:2048',
            'policy' => 'required|file|mimes:jpg,jpeg,png,pdf,xls,webp,xlsx,docx,doc|max:2048',
        ]);

        $case = Cases::findOrFail($id);

        $case->name = $request->name;
        $case->age = $request->age;
        $case->corp = $request->corp;
        $case->tpa = $request->tpa;
        $case->relation = $request->relation;
        $case->gender = $request->gender;
        $case->doa = $request->doa;
        $case->doa_time = $request->doa_time;
        $case->dod = $request->dod;
        $case->dod_time = $request->dod_time;

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

        $case->save();

        return response()->json([
            'success' => true,
            'message' => 'Case updated successfully!',
        ]);
    }

    public function should_create_post_1($case_id = 0, $status = 0){
        $case = Cases::findOrFail($case_id);
        if($status == 1){
            $case->is_post_1 = 1;
        }else{
            $case->is_post_1 = 2;
        }
        if($case->save()){
            $doctor_users = User::where('role_id', 3)->get();

            $next_member_assign = $doctor_users->where('is_next', true)->first();

            if (!$next_member_assign) {
                $next_member_assign = $doctor_users->first();
            }

            $case->doctor_assigned = "$next_member_assign->f_name $next_member_assign->f_name";
            $case->assign_member_post = $next_member_assign->id;
            $case->save();

            User::where('role_id', 3)->update(['is_next' => false]);

            $next_member_index = $doctor_users->search($next_member_assign);
            $next_member_index = ($next_member_index + 1) % $doctor_users->count();
            $next_user = $doctor_users->get($next_member_index);
            $next_user->is_next = true;
            $next_user->save();
        }
        return redirect()->back();
    }
    public function should_create_post_2($case_id = 0, $status = 0){
        $case = Cases::findOrFail($case_id);
        if($status == 1){
            $case->is_post_2 = 1;
        }else{
            $case->is_post_2 = 2;
        }
        if($case->save()){
            $doctor_users = User::where('role_id', 3)->get();

            $next_member_assign = $doctor_users->where('is_next', true)->first();

            if (!$next_member_assign) {
                $next_member_assign = $doctor_users->first();
            }

            $case->doctor_assigned = "$next_member_assign->f_name $next_member_assign->f_name";
            $case->assign_member_post = $next_member_assign->id;
            $case->save();

            User::where('role_id', 3)->update(['is_next' => false]);

            $next_member_index = $doctor_users->search($next_member_assign);
            $next_member_index = ($next_member_index + 1) % $doctor_users->count();
            $next_user = $doctor_users->get($next_member_index);
            $next_user->is_next = true;
            $next_user->save();
        }
        return redirect()->back();
    }
}
