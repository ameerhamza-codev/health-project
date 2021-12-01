<?php

namespace App\Http\Controllers\Auth2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;

class LoginController extends Controller
{
    public function index()
    {
        return view('doctor.login');
    }


    public function checkEmail($email)
    {
        $find1 = strpos($email, '@');
        $find2 = strpos($email, '.');
        return ($find1 !== false && $find2 !== false && $find2 > $find1);
    }
    public function checkPhone($phone)
    {
        return preg_match("/^[0-9]{11}$/", $phone);
    }


    public function authenticate(Request $request)
    {

        if ($this->checkEmail($request->username)) {
            if (Auth::attempt(['email' => $request->username, 'password' => $request->password])) {
                return view('doctor.dashboard.index');
            } else {
                return redirect()->back()->with('error', 'Invalid Email or Password');
            }
        } elseif ($this->checkPhone($request->username)) {
            if (Auth::attempt(['phone' => $request->username, 'password' => $request->password])) {
                return view('doctor.dashboard.index');
            } else {
                return redirect()->back()->with('error', 'Invalid Email or Password');
            }
        } else {
            return redirect()->back()->with('error', 'Enter Valid Email or Phone');
        }
    }
}
