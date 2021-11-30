<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CountryCode;
use App\Patient;
use Illuminate\Support\Facades\Storage;

class PatientController extends Controller
{
    public function index()

    {
        $code=CountryCode::all();
        return view('patient.index',compact('code'));
    }

    public function store(Request $request)
    {
       $patient=new Patient();
         $patient->first_name=$request->fname;
         $patient->last_name=$request->lname;
         $patient->email=$request->email;
         $patient->phone=$request->code.$request->phone;
         $patient->address=$request->address;
         $patient->date_of_birth=$request->dob;
            $patient->save();
            return view('patient.timer');


    }
    public function upload(Request $request)
    {
        
        Storage::disk('public')->put('' $request->file('Test'));
    }
}
