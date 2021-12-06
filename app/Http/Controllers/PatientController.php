<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CountryCode;
use App\Patient;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Session\Session;
use Illuminate\Support\Facades\Validator;
use App\ZoomMeetings;
use Illuminate\Support\Facades\Redirect;

class PatientController extends Controller
{
    public function index()

    {
        $code = CountryCode::all();

        return view('patient.index', compact('code'));
    }

    public function store(Request $request)
    {

        $patient = new Patient();
        $patient->first_name = $request->fname;
        $patient->last_name = $request->lname;
        $patient->email = $request->email;
        $patient->phone = $request->code . $request->phone;
        $patient->address = $request->address;
        $patient->date_of_birth = $request->dob;

        $patient->save();
        Session(['patient' => $patient->id]);
        return view('patient.timer');
    }

    public function status()
    {
        $patient = Patient::find(Session('patient'));
        
       
        if ($patient->test_status !=null) {
            
            $meet = ZoomMeetings::where('id',$patient->test_status)->first();
            echo ($meet->url);
            
        } else {
            echo "null";
        }
        
    }

    public function upload(Request $request)
    {




        if ($request->hasFile('Test') && $request->hasFile('IDBack') && $request->hasFile('IDFront')) {
            $validator = Validator::make($request->all(), [
                'Test' => 'required|mimes:jpg,jpeg,png',
                'IDBack' => 'required|mimes:jpg,jpeg,png',
                'IDFront' => 'required|mimes:jpg,jpeg,png',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->with(['error' => "Please Upload Valid Image Files"])
                    ->withInput();
            } else {
                $test = $request->file('Test');
                $front = $request->file('IDBack');
                $back = $request->file('IDFront');
                Storage::putFileAs('public/images/' . Session('patient'), $test, 'test.jpg');
                Storage::putFileAs('public/images/' . Session('patient'), $front, 'front.jpg');
                Storage::putFileAs('public/images/' . Session('patient'), $back, 'back.jpg');

                $user = Patient::Where('id', Session('patient'))->first();
                $user->test = Storage::url('app/public/images/' . Session('patient') . '/test.jpg');
                $user->ID_front = Storage::url('app/public/images/' . Session('patient') . '/front.jpg');
                $user->ID_back = Storage::url('app/public/images/' . Session('patient') . '/back.jpg');

                $user->save();

                return view('patient.success');
            }
        } else {
            return redirect()->back()->with('error', 'Please Upload All Documents');
        }
    }
}
