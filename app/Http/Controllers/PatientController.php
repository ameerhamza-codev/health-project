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
use App\Events\meeting;

class PatientController extends Controller
{
    public function index()

    {
        $code = CountryCode::all();
        $patients = Patient::all();
        return view('patient.index', compact('code', 'patients'));
    }

    public function store(Request $request)
    {

        
            
        
        $patient = new Patient();
        $patient->first_name = $request->fname;
        $patient->last_name = $request->lname;
        $patient->email = $request->email;
        $patient->phone = $request->code . $request->phone;
        
        if($request->dob ==null){
            $patient->date_of_birth = $request->dob1;
        }
        else{
            $patient->date_of_birth = $request->dob;
        }
        if(strpos($patient->date_of_birth,'/')==true || substr_count($patient->date_of_birth, '.')!=2){
           
            return redirect()->back()->with('error', 'Enter Date of Birth in dd.MM.YY Format');
        }

        $patient->save();
        Session(['patient' => $patient->id]);
        //event(new meeting($patient));
        
        return redirect('/timer');
    }
    public function check(Request $request)
    {
        
        $p =Patient::all();
        $c=$p->count();
        $e=Patient::all()->sortByDesc('id')->first();
        if($request->prev < $c){
            return response()->json(['name' => $e->first_name, 'count' => $c]);
        }
        else{
            return response()->json(['count' => $c]);
        }
    }

    public function get_patient(Request $request)
    {
        $patient = Patient::Where('phone', $request->code.$request->pat)->first();
        
        return response()->json($patient);
    }
    public function get_patient2(Request $request)
    {
        $patient = Patient::Where('id', $request->pat)->first();
        
        return response()->json($patient);
    }


    public function status()
    {
        $patient = Patient::find(Session('patient'));
        
       
        if ($patient->test_status !=null) {
            
            $meet = ZoomMeetings::where('id',$patient->test_status)->first();
            echo ($meet->join_url);
            
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
