<?php

namespace App\Http\Controllers;

use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\ChatGrant;
use Twilio\Jwt\Grants\VideoGrant;
use Twilio\Rest\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Session\Session;

class MeetingController extends Controller
{

    public function index($room)
    {
        $twilioAccountSid = getenv('TWILIO_ACCOUNT_SID');
        $twilioToken      = getenv("TWILIO_AUTH_TOKEN");
        $twilioApiKey     = getenv('TWILIO_API_KEY');
        $twilioApiSecret  = getenv('TWILIO_API_KEY_SECRET');

        $roomName = $room;
        $patient = \App\Patient::where("room",$roomName)->first();
        if(!$patient) {
            abort(404);
        }

        // An identifier for your app - can be anything you'd like
        $identity = self::slugify($patient->first_name." ".$patient->last_name);

        // Create access token, which we will serialize and send to the client
        $token = new AccessToken(
            $twilioAccountSid,
            $twilioApiKey,
            $twilioApiSecret,
            3600,
            $identity
        );

        // Create Video grant
        $videoGrant = new VideoGrant();
        $videoGrant->setRoom($roomName);

        // Add grant to token
        $token->addGrant($videoGrant);

        // render token to string
        $tokenstring = $token->toJWT();

        // started for chat token
        $twilio = new Client($twilioAccountSid, $twilioToken);


        try {
            $conversation = $twilio->conversations->v1->conversations($roomName)->fetch();
        } catch (\Twilio\Exceptions\RestException $e) {
            if ($e->getCode() == 20404) {
                $conversation = $twilio->conversations->v1->conversations->create([
                    "friendlyName" => $roomName,
                    "uniqueName"   => $roomName,
                ]);
            }
        }


        if ($conversation) {
            try {
                $cie = $twilio->conversations
                    ->v1
                    ->conversations($conversation->sid)
                    ->participants
                    ->create([
                        "identity"   => $identity,
                        "attributes" => json_encode([
                            "name" => $identity,
                        ]),
                    ]);
            } catch (\Twilio\Exceptions\RestException $e) {
                if ($e->getCode() == 20404) {
                    $conversation = $twilio->conversations->v1->conversations->create([
                        "friendlyName" => $roomName,
                        "uniqueName"   => $roomName,
                    ]);
                }
            }
        }

        $serviceSid = getenv('TWILIO_CON_SID');
        // Create Chat grant
        $chatGrant = new ChatGrant();
        $chatGrant->setServiceSid($serviceSid);

        // Add grant to token
        $token->addGrant($chatGrant);

        $chatTokenString = $token->toJWT();
        $isPatient = true;

        return view('meeting.join', compact('tokenstring', 'room', 'chatTokenString', 'identity','isPatient'));
    }

    public function host($room)
    {
        if(!\Auth::check()){
            return abort(404);
        }



        $twilioAccountSid = getenv('TWILIO_ACCOUNT_SID');
        $twilioToken      = getenv("TWILIO_AUTH_TOKEN");
        $twilioApiKey     = getenv('TWILIO_API_KEY');
        $twilioApiSecret  = getenv('TWILIO_API_KEY_SECRET');

        $roomName = $room;

        // An identifier for your app - can be anything you'd like
        $identity = self::slugify(auth()->user()->name);

        // Create access token, which we will serialize and send to the client
        $token = new AccessToken(
            $twilioAccountSid,
            $twilioApiKey,
            $twilioApiSecret,
            3600,
            $identity
        );

        // Create Video grant
        $videoGrant = new VideoGrant();
        $videoGrant->setRoom($roomName);

        // Add grant to token
        $token->addGrant($videoGrant);

        // render token to string
        $tokenstring = $token->toJWT();

        // started for chat token
        $twilio = new Client($twilioAccountSid, $twilioToken);

        try {
            $conversation = $twilio->conversations->v1->conversations($roomName)->fetch();
        } catch (\Twilio\Exceptions\RestException $e) {
            if ($e->getCode() == 20404) {
                $conversation = $twilio->conversations->v1->conversations->create([
                    "friendlyName" => $roomName,
                    "uniqueName"   => $roomName,
                ]);
            }
        }

        if ($conversation) {
            try {
                $cie = $twilio->conversations
                    ->v1
                    ->conversations($conversation->sid)
                    ->participants
                    ->create([
                        "identity"   => $identity,
                        "attributes" => json_encode([
                            "name" => $identity,
                        ]),
                    ]);
            } catch (\Twilio\Exceptions\RestException $e) {
                if ($e->getCode() == 20404) {
                    $conversation = $twilio->conversations->v1->conversations->create([
                        "friendlyName" => $roomName,
                        "uniqueName"   => $roomName,
                    ]);
                }
            }
        }

        $serviceSid = getenv('TWILIO_CON_SID');
        // Create Chat grant
        $chatGrant = new ChatGrant();
        $chatGrant->setServiceSid($serviceSid);

        // Add grant to token
        $token->addGrant($chatGrant);

        $chatTokenString = $token->toJWT();
        $isPatient = false;
        return view('meeting.join', compact('tokenstring', 'room', 'chatTokenString', 'identity','isPatient'));
    }

    public static function slugify($text, string $divider = '-') {
      // replace non letter or digits by divider
      $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

      // transliterate
      $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

      // remove unwanted characters
      $text = preg_replace('~[^-\w]+~', '', $text);

      // trim
      $text = trim($text, $divider);

      // remove duplicate divider
      $text = preg_replace('~-+~', $divider, $text);

      // lowercase
      $text = strtolower($text);

      if (empty($text)) {
        return 'n-a';
      }

      return $text;
    }

    public function saveRecords(Request $request)
    {
        $room = $request->get("room");
        $patient = \App\Patient::where("room",$room)->first();

        $validator = Validator::make($request->all(), [
            'file'    => 'required|mimes:jpg,jpeg,png',
        ]);

        if ($validator->fails()) {
            return response()->json(["code" => 500 , "message" => "Please attach correct file"]);
        }
             

        if($patient) {
            $field = $request->get("field");
            $file  = $request->file('file');
            if($field == 'front') {
                Storage::putFileAs('public/images/' .$patient->id, $file, 'front.jpg');
                $patient->ID_front = Storage::url('app/public/images/' . $patient->id . '/front.jpg');
                $patient->save();
            }

            if($field == 'back') {
                Storage::putFileAs('public/images/' .$patient->id, $file, 'back.jpg');
                $patient->ID_back = Storage::url('app/public/images/' . $patient->id . '/back.jpg');
                $patient->save();
            }

            if($field == 'result') {
                Storage::putFileAs('public/images/' .$patient->id, $file, 'test.jpg');
                $patient->test = Storage::url('app/public/images/' . $patient->id . '/test.jpg');
                $patient->save();
            }

            return response()->json(["code" => 200,"message" => "Image updated successfully in your records."]);
        }

        return response()->json(["code" => 500, "message" => "Oops, something went wrong"]);
    }

    public function end()
    {
        return view("meeting.end");
    }

    public function enddoctorside(Request $request , $room)
    {
        if(!\Auth::check()){
            return abort(404);
        }

        $patient = \App\Patient::where("room",$room)->first();
        $patient->test_status = $room;
        $patient->performed_by = auth()->user()->name;
        $patient->save();

        return redirect('/');
    }
}
