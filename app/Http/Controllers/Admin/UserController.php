<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function clients()
    {
        $users = User::where('role', 'client')->get();
        return view('admin.users.clients', compact('users'));
    }
    public function freelancers()
    {
        $users = User::where('role', 'freelancer')->get();
        return view('admin.users.freelancers', compact('users'));
    }
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }
    public function ban($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'banned';
        $user->save();
        return back()->with('success', 'User banned successfully');
    }
    public function unban($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'active';
        $user->save();
        return back()->with('success', 'User Unbanned successfully');
    }
    public function deleteUser($id)
    {
        User::findOrFail($id)->delete();
        return back()->with('success', 'User Deleted successfully');
    }
}
