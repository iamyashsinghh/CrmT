<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $page_heading = 'Users List';
        $roles = Role::all();
        return view('admin.users.index', compact('page_heading', 'roles'));
    }

    public function getUsers(Request $request)
    {
        $users = User::with('get_role')
            ->select(['id', 'profile_image', 'f_name', 'l_name', 'email', 'role_id', 'created_at']);

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
        $validate = Validator::make($request->all(), [
            'f_name' => 'required|string|min:3|max:255',
            'l_name' => 'required|string|min:3|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($id)->whereNull('deleted_at')
            ],
            'role_id' => 'required|exists:roles,id',
            'password' => $id ? 'nullable|min:6' : 'required|min:6',
            'commission_main' => 'required_if:role_id,8,10|nullable|numeric|min:0|max:100',
            'commission_first' => 'required_if:role_id,8|nullable|numeric|min:0|max:100',
            'commission_second' => 'required_if:role_id,8|nullable|numeric|min:0|max:100',
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }

        $softDeletedUser = User::withTrashed()->where('email', $request->email)->first();

        if ($softDeletedUser && $softDeletedUser->trashed()) {
            $softDeletedUser->restore();
            $softDeletedUser->update([
                'f_name' => $request->f_name,
                'l_name' => $request->l_name,
                'role_id' => $request->role_id,
            ]);

            if ($request->role_id == 10 || $request->role_id == 8) {
                $softDeletedUser->update([
                    'commission_main' => $request->commission_main,
                    // Only update v_password if it's not empty
                    'v_password' => !empty($request->v_password) ? Hash::make($request->v_password) : $softDeletedUser->v_password,
                ]);
            }
            if ($request->role_id == 8) {
                $softDeletedUser->update([
                    'commission_first' => $request->commission_first,
                    'commission_second' => $request->commission_second,
                ]);
            }

            if ($request->filled('password')) {
                $softDeletedUser->update(['password' => bcrypt($request->password)]);
            }

            return redirect()->route('admin.users.index')->with('status', [
                'alert_type' => 'success',
                'message' => 'User restored and updated successfully!',
            ]);
        }

        if ($id) {
            $user = User::findOrFail($id);
            $user->update([
                'f_name' => $request->f_name,
                'l_name' => $request->l_name,
                'email' => $request->email,
                'role_id' => $request->role_id,
            ]);

            if ($request->role_id == 10 || $request->role_id == 8) {
                $user->update([
                    'commission_main' => $request->commission_main,
                    // Only update v_password if it's not empty
                    'v_password' => !empty($request->v_password) ? Hash::make($request->v_password) : $user->v_password,
                ]);
            }
            if ($request->role_id == 8) {
                $user->update([
                    'commission_first' => $request->commission_first,
                    'commission_second' => $request->commission_second,
                ]);
            }

            if ($request->filled('password')) {
                $user->update(['password' => bcrypt($request->password)]);
            }

            $message = 'User updated successfully!';
        } else {
            $user = User::create([
                'f_name' => $request->f_name,
                'l_name' => $request->l_name,
                'email' => $request->email,
                'role_id' => $request->role_id,
                'password' => bcrypt($request->password),
            ]);

            if ($request->role_id == 10 || $request->role_id == 8) {
                $user->update([
                    'commission_main' => $request->commission_main,
                    // Only update v_password if it's not empty
                    'v_password' => !empty($request->v_password) ? Hash::make($request->v_password) : null,
                ]);
            }
            if ($request->role_id == 8) {
                $user->update([
                    'commission_first' => $request->commission_first,
                    'commission_second' => $request->commission_second,
                ]);
            }

            $message = 'User created successfully!';
        }

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
