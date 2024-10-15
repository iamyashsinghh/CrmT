<?php

namespace App\Http\Controllers\MedicineVital;

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
        return view('medicinevital.case.index', compact('page_heading'));
    }

    public function ajax_list(Request $request)
    {
        $auth_user = Auth::guard('MedicineVital')->user();
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
                return '<a href="' . route('medicinevital.case.show', $case->id) . '" class="btn btn-info">View</a>';
            })
            ->make(true);
    }

    public function show($id)
    {
        $case = Cases::findOrFail($id);
        $tpa_roles = User::where('role_id', 8)->get();
        return view('medicinevital.case.show', compact('case', 'tpa_roles'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'medicine_vitals_attached' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'medicine_detail' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $case = Cases::findOrFail($id);

        if ($request->hasFile('medicine_vitals_attached')) {
            $case->medicine_vitals_attached = $request->file('medicine_vitals_attached')->store('attachments', 'public');
        }
        if ($request->hasFile('medicine_detail')) {
            $case->medicine_detail = $request->file('medicine_detail')->store('attachments', 'public');
        }

        $case->save();


        if($case->save()){
            $bill_maker = User::where('role_id', 5)->get();

            // Find the next available  member with is_next = true
            $next_member_assign = $bill_maker->where('is_next', true)->first();

            // If no member is marked as next, restart and assign the first one
            if (!$next_member_assign) {
                $next_member_assign = $bill_maker->first(); // Get the first member
            }

            $case->assign_member_id = $next_member_assign->id;
            $case->save();

            // Reset is_next for all members
            User::where('role_id', 5)->update(['is_next' => false]);

            // Set is_next to true for the next  member in the list
            $next_member_index = $bill_maker->search($next_member_assign); // Get the index of the current member
            $next_member_index = ($next_member_index + 1) % $bill_maker->count(); // Move to the next member or reset to the first one
            $next_user = $bill_maker->get($next_member_index); // Get the next  member
            $next_user->is_next = true;
            $next_user->save(); // Save the is_next flag
        }

        return response()->json([
            'success' => true,
            'message' => 'Case updated successfully!',
        ]);
    }
}
