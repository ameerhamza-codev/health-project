<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use App\User;
use Illuminate\Support\Str;
use App\CountryCode;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    public function index()
    {
       $users = User::all();
       $roles = Role::all();
       $code = CountryCode::all();
       
         return view('doctor.dashboard.edit', compact('users', 'roles', 'code'));
    }
    public function store(Request $request)
    {
       
      
        $user = new User();
        $user->name = $request->name;
        $user->phone =  $request->code.$request->phone;
        $user->save();
        $user->roles()->sync($request->role);
        
        return redirect()->back()->with('message', 'User Updated Successfully');
    }
}
