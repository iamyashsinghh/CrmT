<?php

namespace App\Http\Controllers\Vendor;

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
        return view('vendor.case.index', compact('page_heading'));
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
            'aadhar_attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,xls,xlsx,docx,doc|max:2048',
            'pan_card' => 'nullable|file|mimes:jpg,jpeg,png,pdf,xls,xlsx,docx,doc|max:2048',
            'cancelled_cheque' => 'nullable|file|mimes:jpg,jpeg,png,pdf,xls,xlsx,docx,doc|max:2048',
            'policy' => 'nullable|file|mimes:jpg,jpeg,png,pdf,xls,xlsx,docx,doc|max:2048',
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

        return dataTables()->of($cases)
            ->addColumn('actions', function ($case) {
                return '<a href="' . route('vendor.case.show', $case->id) . '" class="btn btn-info">View</a>';
            })
            ->make(true);
    }


    public function show($id)
    {
        $case = Cases::findOrFail($id);

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

        return view('vendor.case.show', compact('case', 'query_status'));
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
            'aadhar_attachment' => 'required|file|mimes:jpg,jpeg,png,pdf,xls,xlsx,docx,doc|max:2048',
            'pan_card' => 'required|file|mimes:jpg,jpeg,png,pdf,xls,xlsx,docx,doc|max:2048',
            'cancelled_cheque' => 'required|file|mimes:jpg,jpeg,png,pdf,xls,xlsx,docx,doc|max:2048',
            'policy' => 'required|file|mimes:jpg,jpeg,png,pdf,xls,xlsx,docx,doc|max:2048',
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
