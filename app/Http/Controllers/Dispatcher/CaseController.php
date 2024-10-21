<?php

namespace App\Http\Controllers\Dispatcher;

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
        return view('dispatcher.case.index', compact('page_heading'));
    }

    public function ajax_list(Request $request)
    {
        $auth_user = Auth::guard('Dispatcher')->user();
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
                return '<a href="' . route('dispatcher.case.show', $case->id) . '" class="btn btn-info">View</a>';
            })
            ->make(true);
    }

    public function show($id)
    {
        $case = Cases::findOrFail($id);
        $tpa_roles = User::where('role_id', 8)->get();
        return view('dispatcher.case.show', compact('case', 'tpa_roles'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'pre_courier_no' => 'required|string',
            'pre_courier_date' => 'required|date',
            'pre_dispatch_pdf_attachment' => 'required|file|mimes:jpg,jpeg,png,pdf,xls,webp,xlsx,docx,doc|max:15360',
        ]);

        $case = Cases::findOrFail($id);

        $case->pre_courier_no = $request->pre_courier_no;
        $case->pre_courier_date = $request->pre_courier_date;

        if ($request->hasFile('pre_dispatch_pdf_attachment')) {
            $case->pre_dispatch_pdf_attachment = $request->file('pre_dispatch_pdf_attachment')->store('attachments', 'public');
        }


        if($case->save()){
            $postsales = User::where('role_id', 9)->get();

            // Find the next available  member with is_next = true
            $next_member_assign = $postsales->where('is_next', true)->first();

            // If no member is marked as next, restart and assign the first one
            if (!$next_member_assign) {
                $next_member_assign = $postsales->first(); // Get the first member
            }

            $case->assign_member_id = $next_member_assign->id;
            $case->save();

            // Reset is_next for all members
            User::where('role_id', 9)->update(['is_next' => false]);

            // Set is_next to true for the next  member in the list
            $next_member_index = $postsales->search($next_member_assign); // Get the index of the current member
            $next_member_index = ($next_member_index + 1) % $postsales->count(); // Move to the next member or reset to the first one
            $next_user = $postsales->get($next_member_index); // Get the next  member
            $next_user->is_next = true;
            $next_user->save(); // Save the is_next flag
        }

        // return redirect()->route('dispatcher.case.index');
        return response()->json([
            'success' => true,
            'message' => 'Case updated successfully!',
        ]);
    }
}
