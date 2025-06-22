<?php

namespace App\Http\Controllers\User;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        return 'User';
    }

    public function profile(){
        $pageTitle="Profile";
        $id=Auth::user()->id;
        $user=User::find($id);
        return view('auth.profile.show',compact('pageTitle','user'));
    }

    public function changePassword(){
        
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
    $user->name=$request->name;
    $user->email=$request->email;
    $user->save();

    return redirect()->back()->with('success', 'Cập nhật thành công!');
}

    
}
