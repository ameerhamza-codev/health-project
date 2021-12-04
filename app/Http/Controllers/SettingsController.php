<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use App\User;
use Illuminate\Support\Str;
use App\CountryCode;
use Illuminate\Support\Facades\Hash;
use App\passwrod_user;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function index()
    {
        $users = User::all()->sortByDesc('id');

        $pass = passwrod_user::all();
        $roles = Role::all();
        $code = CountryCode::all();

        if (Auth::check()) {
            return view('doctor.dashboard.edit', compact('users', 'roles', 'code', 'pass'));
        } else {
            return view('doctor.login');
        }
    }
    public function store(Request $request)
    {

        if (User::where('phone', $request->code . $request->phone)->exists()) {
            return redirect()->back()->with('error', 'Phone already exists');
        } else {
            $user = new User();
            $password = str_random(8);
            $user->name = $request->name;
            $user->password = Hash::make($password);

            $user->phone =  $request->code . $request->phone;
            $user->save();
            $user->roles()->sync($request->role);

            $pass = new passwrod_user();
            $pass->user_id = $user->id;
            $pass->password = $password;
            $pass->save();
            return redirect()->back()->with('success', 'User added successfully');
        }
    }

    public function update(Request $request)
    {
        $user = User::find($request->id);


        if ($request->delete == "1") {
            $user->delete();
            return redirect()->back()->with('success', 'User deleted successfully');
        } else {
            if (User::where('phone', $request->code . $request->phone)->exists()) {
                return redirect()->back()->with('error', 'Phone already exists');
            } else {
                $user->name = $request->name;
                $user->phone =  $request->phone;
                $user->save();
                $user->roles()->sync($request->role);
                return redirect()->back()->with('success', 'User updated successfully');
            }
        }
    }
}
