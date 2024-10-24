<?php

namespace App\Http\Controllers\Lab;

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
        return view('lab.case.index', compact('page_heading'));
    }

    public function ajax_list(Request $request)
    {
        $auth_user = Auth::guard('Lab')->user();
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
            ->where(function ($query) use ($auth_user) {
                $query->where('assign_member_id', $auth_user->id)
                      ->orWhere('assign_member_post', $auth_user->id);
            });
        return dataTables()->of($cases)
            ->addColumn('created_by', function ($case) {
                return $case->user ? $case->user->name : 'N/A';
            })
            ->addColumn('actions', function ($case) {
                return '<a href="' . route('lab.case.show', $case->id) . '" class="btn btn-info">View</a>';
            })
            ->make(true);
    }

    public function show($id)
    {
        $case = Cases::findOrFail($id);
        $tpa_roles = User::where('role_id', 8)->get();
        return view('lab.case.show', compact('case', 'tpa_roles'));
    }

    public function update(Request $request, $id)
    {
        $case = Cases::findOrFail($id);
        $case->check_box = 1;
        if($case->save()){
            $dispatcher = User::where('role_id', 7)->get();

            // Find the next available  member with is_next = true
            $next_member_assign = $dispatcher->where('is_next', true)->first();

            // If no member is marked as next, restart and assign the first one
            if (!$next_member_assign) {
                $next_member_assign = $dispatcher->first(); // Get the first member
            }

            $case->assign_member_id = $next_member_assign->id;
            $case->save();

            // Reset is_next for all members
            User::where('role_id', 7)->update(['is_next' => false]);

            // Set is_next to true for the next  member in the list
            $next_member_index = $dispatcher->search($next_member_assign); // Get the index of the current member
            $next_member_index = ($next_member_index + 1) % $dispatcher->count(); // Move to the next member or reset to the first one
            $next_user = $dispatcher->get($next_member_index); // Get the next  member
            $next_user->is_next = true;
            $next_user->save(); // Save the is_next flag
        }

        return redirect()->route('lab.case.index');
        // return response()->json([
        //     'success' => true,
        //     'message' => 'Case updated successfully!',
        // ]);
    }
    public function update_post_one(Request $request, $id)
    {
        $case = Cases::findOrFail($id);
        $case->check_box_post = 1;
        if($case->save()){
            $dispatcher = User::where('role_id', 7)->get();

            // Find the next available  member with is_next = true
            $next_member_assign = $dispatcher->where('is_next', true)->first();

            // If no member is marked as next, restart and assign the first one
            if (!$next_member_assign) {
                $next_member_assign = $dispatcher->first(); // Get the first member
            }

            $case->assign_member_post = $next_member_assign->id;
            $case->save();

            // Reset is_next for all members
            User::where('role_id', 7)->update(['is_next' => false]);

            // Set is_next to true for the next  member in the list
            $next_member_index = $dispatcher->search($next_member_assign); // Get the index of the current member
            $next_member_index = ($next_member_index + 1) % $dispatcher->count(); // Move to the next member or reset to the first one
            $next_user = $dispatcher->get($next_member_index); // Get the next  member
            $next_user->is_next = true;
            $next_user->save(); // Save the is_next flag
        }

        return redirect()->route('lab.case.index');
        // return response()->json([
        //     'success' => true,
        //     'message' => 'Case updated successfully!',
        // ]);
    }
    public function update_post_two(Request $request, $id)
    {
        $case = Cases::findOrFail($id);
        $case->check_box_post_two = 1;
        if($case->save()){
            $dispatcher = User::where('role_id', 7)->get();

            // Find the next available  member with is_next = true
            $next_member_assign = $dispatcher->where('is_next', true)->first();

            // If no member is marked as next, restart and assign the first one
            if (!$next_member_assign) {
                $next_member_assign = $dispatcher->first(); // Get the first member
            }

            $case->assign_member_post = $next_member_assign->id;
            $case->save();

            // Reset is_next for all members
            User::where('role_id', 7)->update(['is_next' => false]);

            // Set is_next to true for the next  member in the list
            $next_member_index = $dispatcher->search($next_member_assign); // Get the index of the current member
            $next_member_index = ($next_member_index + 1) % $dispatcher->count(); // Move to the next member or reset to the first one
            $next_user = $dispatcher->get($next_member_index); // Get the next  member
            $next_user->is_next = true;
            $next_user->save(); // Save the is_next flag
        }

        return redirect()->route('lab.case.index');
        // return response()->json([
        //     'success' => true,
        //     'message' => 'Case updated successfully!',
        // ]);
    }
}
