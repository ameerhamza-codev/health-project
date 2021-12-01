<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use App\User;
use Illuminate\Support\Str;
use App\CountryCode;
use Illuminate\Support\Facades\Hash;
use App\passwrod_user;

class SettingsController extends Controller
{
    public function index()
    {
       $users = User::all();
       $pass=passwrod_user::all();
       $roles = Role::all();
       $code = CountryCode::all();
       
         return view('doctor.dashboard.edit', compact('users', 'roles', 'code','pass'));
    }
    public function store(Request $request)
    {
        $password=str_random(8);
        
      
        $user = new User();

        $user->name = $request->name;
        $user->password=Hash::make($password);
        $user->phone =  $request->code.$request->phone;
        $user->save();
        $user->roles()->sync($request->role);
       
        $pass=new passwrod_user();
        $pass->user_id=$user->id;
        $pass->password=$password;
        $pass->save();
        return redirect()->back()->with('message', 'User Updated Successfully');
    }
}
