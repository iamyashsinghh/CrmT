<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Redirect back with errors if validation fails
        if ($validator->fails()) {
        session()->flash('error', $validator);
            return redirect()->back();
        }

        // Attempt to log the user in
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Authentication passed
            return redirect()->intended('admin/dashboard'); // Redirect to intended route
        }

        // Flash error message to the session if authentication fails
        session()->flash('error', 'Invalid credentials');
        return redirect()->back()->withInput();
    }

    // Handle user logout
    public function logout()
    {
        Auth::logout(); // Log out the user
        return redirect()->route('home'); // Redirect to the login page
    }

    public function update_profile_image($member_id, Request $request)
{
    $validate = Validator::make($request->all(), [
        'profile_image' => 'mimes:jpg,jpeg,png,webp,avif|max:1024',
    ]);

    if ($validate->fails()) {
        return response()->json([
            'success' => false,
            'message' => $validate->errors()->first()
        ]);
    }

    $member = User::find($member_id);
    if (!$member) {
        return response()->json([
            'success' => false,
            'message' => 'User not found.'
        ], 404);
    }

    if ($request->hasFile('profile_image')) {
        $file = $request->file('profile_image');
        $ext = $file->getClientOriginalExtension();
        $sub_str = substr($member->name, 0, 5);
        $file_name = strtolower(str_replace(' ', '_', $sub_str)) . "_profile_" . date('dmyHis') . "." . $ext;
        $path = "memberProfileImages/$file_name";
        Storage::put("public/" . $path, file_get_contents($file));

        $member->profile_image = $path;
        $member->save();

        return response()->json([
            'success' => true,
            'message' => 'Image updated.',
            'profile_image_url' => asset("storage/" . $path)
        ]);
    }

    return response()->json([
        'success' => false,
        'message' => 'Something went wrong. Please try again.'
    ]);
}
}
