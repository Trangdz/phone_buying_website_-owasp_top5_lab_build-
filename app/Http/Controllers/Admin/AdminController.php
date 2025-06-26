<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Hash;
use function Laravel\Prompts\password;

// This controller have purpose to manage admin's profile

class AdminController extends Controller
{
    public function index()
    {
        return 'Admin';
    }

    public function profile()
    {
        $pageTitle = "Profile";
        $id = Auth::user()->id;
        $user = User::find($id);
        return view('admin.auth.profile.show', compact('pageTitle', 'user'));
    }

    public function changePassword()
    {

        return view('admin.auth.passwords.change');
    }

    public function postChangePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8|confirmed',  // `confirmed` để yêu cầu trường `new_password_confirmation`
        ]);
    
        // Kiểm tra mật khẩu cũ
        if (!Hash::check($request->old_password, auth()->user()->password)) {
            return redirect()->route('admin.auth.change-password')->with('error', 'Mật khẩu hiện tại không đúng.');
        }
    
        // Cập nhật mật khẩu mới
        auth()->user()->update([
            'password' => Hash::make($request->new_password),
        ]);
    
        return redirect()->route('admin.auth.change-password')->with('success', 'Mật khẩu đã được cập nhật.');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        // $user->update([
        //     'name'  => $request->name,
        //     'email' => $request->email,
        // ]);

        //Demo Mass asignment
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return redirect()->back()->with('success', 'Cập nhật thành công!');
    }
}
