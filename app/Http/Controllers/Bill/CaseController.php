<?php

namespace App\Http\Controllers\Bill;

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
        return view('bill.case.index', compact('page_heading'));
    }

    public function ajax_list(Request $request)
    {
        $auth_user = Auth::guard('Bill')->user();
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
            ->with(['user:id,name'])
            ->where('assign_member_id', $auth_user->id);

        return dataTables()->of($cases)
            ->addColumn('created_by', function ($case) {
                return $case->user ? $case->user->name : 'N/A';
            })
            ->addColumn('actions', function ($case) {
                return '<a href="' . route('bill.case.show', $case->id) . '" class="btn btn-info">View</a>';
            })
            ->make(true);
    }

    public function show($id)
    {
        $case = Cases::findOrFail($id);
        $tpa_roles = User::where('role_id', 8)->get();
        return view('bill.case.show', compact('case', 'tpa_roles'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'ipd_no_entry' => 'required',
            'bill_attachment_1' => 'required|file|mimes:jpg,jpeg,png,pdf,xls,xlsx,docx,doc|max:2048',
            'discharge_summary_attachment' => 'required|file|mimes:jpg,jpeg,png,pdf,xls,xlsx,docx,doc|max:2048',
        ]);

        $case = Cases::findOrFail($id);
        $case->ipd_no_entry = $request->ipd_no_entry;
        if ($request->hasFile('bill_attachment_1')) {
            $case->bill_attachment_1 = $request->file('bill_attachment_1')->store('attachments', 'public');
        }
        if ($request->hasFile('discharge_summary_attachment')) {
            $case->discharge_summary_attachment = $request->file('discharge_summary_attachment')->store('attachments', 'public');
        }
        $case->save();

        if($case->save()){
            $lab_maker = User::where('role_id', 6)->get();

            // Find the next available  member with is_next = true
            $next_member_assign = $lab_maker->where('is_next', true)->first();

            // If no member is marked as next, restart and assign the first one
            if (!$next_member_assign) {
                $next_member_assign = $lab_maker->first(); // Get the first member
            }

            $case->assign_member_id = $next_member_assign->id;
            $case->save();

            // Reset is_next for all members
            User::where('role_id', 6)->update(['is_next' => false]);

            // Set is_next to true for the next  member in the list
            $next_member_index = $lab_maker->search($next_member_assign); // Get the index of the current member
            $next_member_index = ($next_member_index + 1) % $lab_maker->count(); // Move to the next member or reset to the first one
            $next_user = $lab_maker->get($next_member_index); // Get the next  member
            $next_user->is_next = true;
            $next_user->save(); // Save the is_next flag
        }

        return response()->json([
            'success' => true,
            'message' => 'Case updated successfully!',
        ]);
    }
}
