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
use App\Patient;
use Carbon\Carbon;
use App\Http\Controllers\ZoomController;
use GuzzleHttp\Promise\Create;
use App\ZoomMeetings;
use Illuminate\Support\Facades\Redirect;
use GuzzleHttp\Client;

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

    public function generateCSV(Request $request){
        
        $user = Patient::find($request->id);
        $user->test_no ='1';
        $user->result=$request->test_status;
        $user->csv_date=Carbon::now();
        $user->save();
        if($request->submit == "Save"){
            return redirect()->back();
         
        }else{
        $data = [];
        $data[] = array('First Name','Last Name','Date of Birth', 'Email','Phone','Test No','Test Status','CSV Date','Performed By');
        
        $data[] = array($user->first_name, $user->last_name, $user->date_of_birth,$user->email, $user->phone, $user->test_no, $user->test_status, $user->csv_date,$user->performed_by);
        
        $fileName = $user->first_name.'.csv';
        $filePath = public_path($fileName);
        $file = fopen($filePath, 'w');
        foreach ($data as $line) {
            fputcsv($file, $line);
        }
        fclose($file);
        return response()->download($filePath);
    }
    }

    public function bulkCSV(){

        $data = [];
        $data[] = array('First Name','Last Name','Date of Birth', 'Email','Phone','Test No','Test Status','CSV Date','Performed By');
        $users = Patient::all()->sortByDesc('id');
        foreach($users as $user){
            $data[] = array($user->first_name, $user->last_name, $user->date_of_birth,$user->email, $user->phone, $user->test_no, $user->test_status, $user->csv_date,$user->performed_by );
        }
        $fileName = 'Patients.csv';
        $filePath = public_path($fileName);
        $file = fopen($filePath, 'w');
        foreach ($data as $line) {
            fputcsv($file, $line);
        }
        fclose($file);
        
        return response()->download($filePath);
    }

    public function set(Request $request){
        $meeting=new ZoomMeetings();
        
        $meeting->start_time=Carbon::now();
        
        $user = Patient::find($request->id);
        $meeting->phone=$user->phone;
        $meeting->topic="Doctor Appointment";
      
        $mm= new ZoomController();
        $res=$mm->create([ 'topic'      => "Doctor Appointment",
        'start_time' => Carbon::now(),
        'host_video' => 1,
        'participant_video' => 1,]);        
        
        $join_url=$res['data']['join_url'];
        $join_url=str_replace("/j/","/wc/join/  ",$join_url);

        $meeting->url=$join_url;
        $meeting->start_url=$res['data']['start_url'];
        $meeting->save();
        $user->test_status=$meeting->id;
        $user->performed_by=auth()->user()->name;
      
        $user->save();
        return Redirect::away($res['data']['start_url']);
    }
}
