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
use phpseclib3\File\ASN1\Maps\Time;

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

            $user->name = $request->name;
            $user->phone =  $request->phone;
            $user->password= Hash::make($request->pass);
            $user->save();
            $user->roles()->sync($request->role);
            $pass = Passwrod_user::where('user_id', $request->id)->update(['password'=> $request->pass]);
            
            return redirect()->back()->with('success', 'User updated successfully');
        }
    }

    public function generateCSV(Request $request)
    {

        $user = Patient::find($request->id);
        $user->test_no = '1';
        $user->result = $request->test_status;
        $user->csv_date = Carbon::now();
        $user->save();
        if ($request->submit == "Save") {
            return redirect()->back();
        } else {
            $data = [];
            $data[] = array(
                "GivenName", "FamilyName", "DateofBirth", "Language", "ManufacturerCode",
                "TypeCode", "SampleDateTime", "TestingCenterOrFacility", "MemberStateofTest"
            );

            $data[] = array($user->first_name, $user->last_name, $user->date_of_birth, 'Fr', '1223', 'LP217198-3', $user->created_at, 'DR NGUIFFO BOYOM', 'CH');

            $fileName = $user->first_name . '.csv';
            $filePath = public_path($fileName);
            $file = fopen($filePath, 'w');
            foreach ($data as $line) {
                fputcsv($file, $line);
            }
            fclose($file);
            return response()->download($filePath);
        }
    }

    public function bulkCSV()
    {

        $data = [];
        $data[] = array(
            "GivenName", "FamilyName", "DateofBirth", "Language", "ManufacturerCode",
            "TypeCode", "SampleDateTime", "TestingCenterOrFacility", "MemberStateofTest"
        );
        $users = Patient::all()->sortByDesc('id');
        foreach ($users as $user) {
            if ($user->result == "Success") {
                $data[] = array($user->first_name, $user->last_name, $user->date_of_birth, 'Fr', '1223', 'LP217198-3', $user->created_at, 'DR NGUIFFO BOYOM', 'CH');
            }
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

    public function set(Request $request)
    {
        $meeting = new ZoomMeetings();

        $meeting->start_time = Carbon::now();

        $user = Patient::find($request->id);
        $meeting->phone = $user->phone;

        $mm = new ZoomController();
        $res = $mm->create([
            'topic'      => "Doctor Appointment",
            'start_time' => Carbon::now(),
            'host_video' => 1,
            'participant_video' => 1,
        ]);

        $join_url = $res['data']['join_url'];
        $join_url = str_replace("/j/", "/wc/join/", $join_url);

        $meeting->join_url = $join_url;
        $meeting->start_url = $res['data']['start_url'];
        $meeting->save();
        $user->test_status = $meeting->id;
        $user->performed_by = auth()->user()->name;

        $user->save();
        return redirect()->back()->with('open', $res['data']['start_url']);
       // return Redirect::away($res['data']['start_url']);
    }

    public function meet_notif()
    {
        date_default_timezone_set("Asia/Karachi");
        $meet = ZoomMeetings::all();
        $d = Carbon::now();
        $d = $d->shiftTimezone('Asia/Karachi');

        $d = substr($d, 0, -3);
        $sms=new SMSController();

        foreach ($meet as $meeting) {

            $time = Carbon::parse($meeting->start_time);
            $time = substr($time, 0, -3);
            if ($time == ($d)) {
                $sms->sendSMS($meeting->phone,env('APP_URL').'/patient-area' ,"Your appointment is scheduled at " . $meeting->start_time);
                
            } else {
            }
        }

        return response()->json(['status' => ($time . " " . $d)]);
    }
}
