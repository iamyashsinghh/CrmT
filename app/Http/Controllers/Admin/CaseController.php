<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cases;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CaseController extends Controller
{
    public function index()
    {
        $page_heading = 'Cases';
        return view('admin.case.index', compact('page_heading'));
    }

    public function store(Request $request)
    {
        $auth_user = Auth::guard('Admin')->user();

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
            'aadhar_attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'pan_card' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'cancelled_cheque' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'policy' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $validated['created_by'] = $auth_user->id;

        $case = Cases::create($validated);
        $case->case_code = "case_000$case->id";


        if ($request->hasFile('aadhar_attachment')) {
            $case->aadhar_attachment = $request->file('aadhar_attachment')->store('attachments', 'public');
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


    public function ajax_list(Request $request)
    {
        $auth_user = Auth::guard('Admin')->user();
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
        ])
            ->with(['user:id,name']);

        return dataTables()->of($cases)
            ->addColumn('created_by', function ($case) {
                return $case->user ? $case->user->name : 'N/A';
            })
            ->addColumn('actions', function ($case) {
                return '<a href="' . route('admin.case.show', $case->id) . '" class="btn btn-info">View</a>';
            })
            ->make(true);
    }

    public function show($id)
    {
        $case = Cases::findOrFail($id);
        $tpa_roles = User::where('role_id', 8)->get();
        return view('admin.case.show', compact('case', 'tpa_roles'));
    }

    public function cases_status_update($case_id, $status) {
        $case = Cases::findOrFail($case_id);

        // Update the forward status
        $case->forward_status = $status;

        // If status is 1 (forward status), assign a sales member
        if ($status == 1) {
            // Fetch all sales members with role_id = 2
            $sales_users = User::where('role_id', 2)->get();

            // Find the next available sales member with is_next = true
            $next_sales_member = $sales_users->where('is_next', true)->first();

            // If no member is marked as next, restart and assign the first one
            if (!$next_sales_member) {
                $next_sales_member = $sales_users->first(); // Get the first member
            }

            // Assign this member to the case
            $case->assign_member_id = $next_sales_member->id;
            $case->save();

            // Reset is_next for all members
            User::where('role_id', 2)->update(['is_next' => false]);

            // Set is_next to true for the next sales member in the list
            $next_member_index = $sales_users->search($next_sales_member); // Get the index of the current member
            $next_member_index = ($next_member_index + 1) % $sales_users->count(); // Move to the next member or reset to the first one
            $next_sales_user = $sales_users->get($next_member_index); // Get the next sales member
            $next_sales_user->is_next = true;
            $next_sales_user->save(); // Save the is_next flag
        }
        $case->save();
        session()->flash('status', ['success' => true, 'alert_type' => 'success', 'message' => "Status updated."]);

        return redirect()->back();
    }

    public function cases_status_remark(Request $request) {
        $case = Cases::findOrFail($request->id);
        $case->forward_status = 2;
        $case->forward_status_remark = $request->remark;
        $case->save();
        session()->flash('status', ['success' => true, 'alert_type' => 'success', 'message' => "Status updated."]);
        return redirect()->back();
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
            'dod' => 'required|date',
            'dod_time' => 'required',
            'sum_insured' => 'nullable',
            'bill_range' => 'nullable',
            'past_hospital' => 'nullable',
            'past_diagnosis' => 'nullable',
            'tpa' => 'nullable',
            'tpa_allot_after_claim_no_received' => 'nullable',
            'claim_no' => 'nullable',
            'aadhar_attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'pan_card' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'cancelled_cheque' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'policy' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
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

        $case->sum_insured = $request->sum_insured;
        $case->bill_range = $request->bill_range;
        $case->past_hospital = $request->past_hospital;
        $case->past_diagnosis = $request->past_diagnosis;
        $case->tpa = $request->tpa;
        $case->tpa_allot_after_claim_no_received = $request->tpa_allot_after_claim_no_received;
        $case->claim_no = $request->claim_no;

        if ($request->hasFile('aadhar_attachment')) {
            $case->aadhar_attachment = $request->file('aadhar_attachment')->store('attachments', 'public');
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
}
