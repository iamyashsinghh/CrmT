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
    public function index()
    {
        $page_heading = 'Cases';
        return view('postsales.case.index', compact('page_heading'));
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
        ])
            ->with(['user:id,name'])
            ->where('assign_member_id', $auth_user->id);

        return dataTables()->of($cases)
            ->addColumn('created_by', function ($case) {
                return $case->user ? $case->user->name : 'N/A';
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
            'patient_details_form' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);
        $case = Cases::findOrFail($id);
        $case->claim_no = $request->claim_no;
        $case->status = $request->status;
        $case->approved_amt = $request->approved_amt;

        if ($request->hasFile('patient_details_form')) {
            $case->patient_details_form = $request->file('patient_details_form')->store('attachments', 'public');
        }
        $case->save();
        return response()->json([
            'success' => true,
            'message' => 'Case updated successfully!',
        ]);
    }

    public function query_add(Request $request)
    {
        // Validate the request
        $request->validate([
            'query' => 'required|string',
            'case_id' => 'required|integer', // Validate case_id as it is an integer field
            'query_pdf' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048', // Limit file types and size
        ]);

        // Get the authenticated user
        $auth_user = Auth::guard('PostSales')->user();

        // Create a new instance of the Query model
        $query = new Query();
        $query->case_id = $request->input('case_id'); // Use input() to retrieve specific value safely
        $query->created_by = $auth_user->id;
        $query->query = $request->input('query'); // Use input() to safely retrieve the value

        // Handle file upload
        if ($request->hasFile('query_pdf')) {
            // Store the file and assign the path to the query_pdf field
            $filePath = $request->file('query_pdf')->store('attachments', 'public');
            $query->query_pdf = $filePath; // Save the path to the database
        }

        // Save the query and handle the response
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


}
