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
       $users = User::all();
       $pass=passwrod_user::all();
       $roles = Role::all();
       $code = CountryCode::all();

       if (Auth::check()) {
         return view('doctor.dashboard.edit', compact('users', 'roles', 'code','pass'));
       }
       else{
           return view('doctor.login');
       }
    }
    public function store(Request $request)
    {

        if(User::where('phone', $request->code.$request->phone)->exists()){
            return redirect()->back()->with('error', 'Phone already exists');
        }
        else{
            $user = new User();
            $password=str_random(8);
            $user->name = $request->name;
            $user->password=Hash::make($password);
    
            $user->phone =  $request->code.$request->phone;
            $user->save();
            $user->roles()->sync($request->role);
           
            $pass=new passwrod_user();
            $pass->user_id=$user->id;
            $pass->password=$password;
            $pass->save();
            return redirect()->back()->with('success', 'User added successfully');
        }

       
    }
}
