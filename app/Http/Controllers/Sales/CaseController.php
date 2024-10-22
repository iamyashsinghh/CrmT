<?php

namespace App\Http\Controllers\Sales;

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
        return view('sales.case.index', compact('page_heading'));
    }

    public function ajax_list(Request $request)
    {
        $auth_user = Auth::guard('Sales')->user();
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
                return '<a href="' . route('sales.case.show', $case->id) . '" class="btn btn-info">View</a>';
            })
            ->make(true);
    }

    public function show($id)
    {
        $case = Cases::findOrFail($id);
        $tpa_roles = User::where('role_id', 8)->get();
        return view('sales.case.show', compact('case', 'tpa_roles'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'doa' => 'required|date',
            'doa_time' => 'required',
            'dod' => 'required|date',
            'dod_time' => 'required',
            'hospital' => 'nullable',
            'diagnosis' => 'nullable',
        ]);

        $case = Cases::findOrFail($id);

        $case->doa = $request->doa;
        $case->doa_time = $request->doa_time;
        $case->dod = $request->dod;
        $case->dod_time = $request->dod_time;
        $case->hospital = $request->hospital;
        $case->diagnosis = $request->diagnosis;

        if($case->save()){
            $doctor_users = User::where('role_id', 3)->get();

            // Find the next available  member with is_next = true
            $next_member_assign = $doctor_users->where('is_next', true)->first();

            // If no member is marked as next, restart and assign the first one
            if (!$next_member_assign) {
                $next_member_assign = $doctor_users->first(); // Get the first member
            }

            // Assign this member to the case
            $case->doctor_assigned = "$next_member_assign->f_name $next_member_assign->f_name";
            $case->assign_member_id = $next_member_assign->id;
            $case->save();

            // Reset is_next for all members
            User::where('role_id', 3)->update(['is_next' => false]);

            // Set is_next to true for the next  member in the list
            $next_member_index = $doctor_users->search($next_member_assign); // Get the index of the current member
            $next_member_index = ($next_member_index + 1) % $doctor_users->count(); // Move to the next member or reset to the first one
            $next_user = $doctor_users->get($next_member_index); // Get the next  member
            $next_user->is_next = true;
            $next_user->save(); // Save the is_next flag
        }

        return response()->json([
            'success' => true,
            'message' => 'Case updated successfully!',
        ]);
    }
}
