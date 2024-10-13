<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // Display list of users
    public function index()
    {
        $page_heading = 'Users List';
        $roles = Role::all();
        return view('admin.users.index', compact('page_heading', 'roles'));
    }

    // Get users for DataTable (AJAX call)
    public function getUsers(Request $request)
    {
        $users = User::with('get_role') // Ensure that this relationship is correct
            ->select(['id', 'profile_image', 'f_name', 'l_name', 'email', 'role_id', 'created_at']);

        // Apply role filter if a role is selected
        if ($request->has('role') && !empty($request->role)) {
            $users = $users->whereHas('get_role', function ($query) use ($request) {
                $query->where('name', $request->role);
            });
        }

        return datatables()->of($users)
            ->addColumn('action', function ($user) {
                return '<a href="' . route('admin.users.manage', $user->id) . '" class="btn btn-sm btn-primary">Edit</a>
                    <a href="javascript:void(0);" data-id="' . $user->id . '" class="btn btn-sm btn-danger delete-btn">Delete</a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }


    public function manage($id = null)
    {
        $roles = Role::select('id', 'name')->get();
        $user = null;

        if ($id) {
            $user = User::findOrFail($id);
        }

        return view('admin.users.manage', compact('user', 'roles'));
    }

    public function manage_process(Request $request, $id = null)
{
    // Validation rules
    $validate = Validator::make($request->all(), [
        'f_name' => 'required|string|min:3|max:255',
        'l_name' => 'required|string|min:3|max:255',
        'email' => [
            'required',
            'email',
            Rule::unique('users')->ignore($id)->whereNull('deleted_at') // Ignore soft-deleted users
        ],
        'role_id' => 'required|exists:roles,id', // Role must be valid
        'password' => $id ? 'nullable|min:6' : 'required|min:6', // Password required for new user, optional for updates
    ]);

    // Check validation errors
    if ($validate->fails()) {
        return redirect()->back()->withErrors($validate)->withInput();
    }

    // Handle soft-deleted user with the same email
    $softDeletedUser = User::withTrashed()->where('email', $request->email)->first();

    if ($softDeletedUser && $softDeletedUser->trashed()) {
        // Restore the soft-deleted user instead of creating a new one
        $softDeletedUser->restore();
        $softDeletedUser->update([
            'f_name' => $request->f_name,
            'l_name' => $request->l_name,
            'role_id' => $request->role_id,
        ]);

        // Only update password if provided
        if ($request->filled('password')) {
            $softDeletedUser->update(['password' => bcrypt($request->password)]);
        }

        // Return success message for restored user
        return redirect()->route('admin.users.index')->with('status', [
            'alert_type' => 'success',
            'message' => 'User restored and updated successfully!',
        ]);
    }

    // Update existing user
    if ($id) {
        $user = User::findOrFail($id);
        $user->update([
            'f_name' => $request->f_name,
            'l_name' => $request->l_name,
            'email' => $request->email,
            'role_id' => $request->role_id, // Assign new role if updated
        ]);

        // Only update password if provided
        if ($request->filled('password')) {
            $user->update(['password' => bcrypt($request->password)]);
        }

        // Return success message for update
        $message = 'User updated successfully!';
    } else {
        // Create new user
        $user = User::create([
            'f_name' => $request->f_name,
            'l_name' => $request->l_name,
            'email' => $request->email,
            'role_id' => $request->role_id, // Assign role to new user
            'password' => bcrypt($request->password),
        ]);

        // Return success message for creation
        $message = 'User created successfully!';
    }

    // Redirect to users list with success message
    return redirect()->route('admin.users.index')->with('status', [
        'alert_type' => 'success',
        'message' => $message,
    ]);
}



    // Delete user
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return response()->json(['status' => 'success', 'message' => 'User deleted successfully!']);
    }
}
