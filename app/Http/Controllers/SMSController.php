<?php

namespace App\Http\Controllers;

use Illuminate\Support\ServiceProvider;
use CurlHandle;
use GuzzleHttp\Handler\CurlHandler;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Exception;
use Twilio\Rest\Client;

class SMSController extends Controller
{


    public function sendSMS($phone,$url,$date)

    {
        $receiverNumber = "+".$phone;
        $message = "Your Appointment URL is ".$url." and Date is ".$date;
        try {
  
            $account_sid = getenv("TWILIO_SID");
            $auth_token = getenv("TWILIO_TOKEN");
            $twilio_number = getenv("TWILIO_FROM");
  
            $client = new Client($account_sid, $auth_token);
            $client->messages->create($receiverNumber, [
                'from' => $twilio_number, 
                'body' => $message]);
  
           return 1;
        } catch (Exception $e) {
            return 0;
            //return redirect()->back()->with('meeting-error', "SMS did not go through, check if you put a Valid number");
        }
    }
}
