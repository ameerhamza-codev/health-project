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
<<<<<<< HEAD
<<<<<<< HEAD
use Illuminate\Support\Facades\Http;
=======
>>>>>>> aff83c06c46b2a2c50b6b97843d87d96a2c57f13
=======
>>>>>>> aff83c06c46b2a2c50b6b97843d87d96a2c57f13

class MeetingController extends Controller
{

    public function index($room)
    {
<<<<<<< HEAD
<<<<<<< HEAD
        /*$twilioAccountSid = getenv('TWILIO_ACCOUNT_SID');
        $twilioToken      = getenv("TWILIO_AUTH_TOKEN");
        $twilioApiKey     = getenv('TWILIO_API_KEY');
        $twilioApiSecret  = getenv('TWILIO_API_KEY_SECRET');*/

        $roomName = substr($room, 0, 25);
        $room_me = substr($room, 0, 25);
        //dd($room_me);
        $patient = \App\Patient::where("room", $room)->first();
        if (!$patient) {
            abort(404);
        }
        //($patient);
        // An identifier for your app - can be anything you'd like
        $identity = self::slugify($patient->first_name . " " . $patient->last_name);

        $method = "POST";
        $endpoint = "";
        $data = [];
        $headers = [];

        $endpoint = 'https://api.daily.co/v1/' . "rooms";

        $headers = array_merge($headers, [
            'Authorization' => 'Bearer ' . "6294b5815005bd3d5e31cc50dc37e4cd5577ba91d9b9b29c1e3f24aa045738ae",
        ]);
        // room genrate
        /*$room_data = Http::withHeaders($headers)->{$method}($endpoint, [
		   
		]);*/
        /*$headr = array();
			$headr[] = 'Content-length: 0';
			$headr[] = 'Content-type: application/json';
			$headr[] = 'Authorization: Bearer '."36dfed9d3789c6d4bfa91db38f6d5d95d6dd9d52e6cbc84098597e9287ead48f";					
	 	    
			$curl = curl_init();
			//curl_setopt($curl, CURLOPT_HEADER, true);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl, CURLOPT_HTTPHEADER, $headr);

		    curl_setopt_array($curl, array(
			CURLOPT_URL => $endpoint,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_TIMEOUT => 30000,
			
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => json_encode(
			),
			
		));
		$rooms_data = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);*/
        $url = $endpoint; //"https://api.daily.co/v1/meeting-tokens";
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $headers = array(
            "Content-Type: application/json",
            "Authorization: Bearer 6294b5815005bd3d5e31cc50dc37e4cd5577ba91d9b9b29c1e3f24aa045738ae",
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $data = json_encode([
            "name" =>  $roomName,
            "privacy" => "public",
            "properties" => [
                "autojoin" => true,
                "enable_chat" => true,
                "start_audio_off" => false,
                "start_video_off" => true,
            ]
        ]);

        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $rooms_data = json_decode(curl_exec($curl), true);
        curl_close($curl);


        //dd($response);
        $url = "https://api.daily.co/v1/meeting-tokens";
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $headers = array(
            "Content-Type: application/json",
            "Authorization: Bearer 6294b5815005bd3d5e31cc50dc37e4cd5577ba91d9b9b29c1e3f24aa045738ae",
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $data = json_encode([
            "properties" => [
                "room_name" => $roomName,
                "enable_screenshare" => true,
                "enable_recording" => "local",
                "user_name" => $patient->first_name . " " . $patient->last_name,
                "user_id" => $patient->id,
                "close_tab_on_exit" => true,
                "redirect_on_meeting_exit" => "https://amiens.cc/upload"
            ]
        ]);

        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $token = json_decode(curl_exec($curl), true);
        curl_close($curl);
        //var_dump($resp);
        //dd($token);
        // Create access token, which we will serialize and send to the client
        /*$token = new AccessToken(
=======
=======
>>>>>>> aff83c06c46b2a2c50b6b97843d87d96a2c57f13
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
<<<<<<< HEAD
>>>>>>> aff83c06c46b2a2c50b6b97843d87d96a2c57f13
=======
>>>>>>> aff83c06c46b2a2c50b6b97843d87d96a2c57f13
            $twilioAccountSid,
            $twilioApiKey,
            $twilioApiSecret,
            3600,
            $identity
<<<<<<< HEAD
<<<<<<< HEAD
        );*/

        // Create Video grant
        /*$videoGrant = new VideoGrant();
=======
=======
>>>>>>> aff83c06c46b2a2c50b6b97843d87d96a2c57f13
        );

        // Create Video grant
        $videoGrant = new VideoGrant();
<<<<<<< HEAD
>>>>>>> aff83c06c46b2a2c50b6b97843d87d96a2c57f13
=======
>>>>>>> aff83c06c46b2a2c50b6b97843d87d96a2c57f13
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

<<<<<<< HEAD
<<<<<<< HEAD
        $chatTokenString = $token->toJWT();*/
        $isPatient = true;
        $tokenstring = $token['token'];
        //dd($tokenstring);
        $chatTokenString = "";
        return view('meeting.join', compact('tokenstring', 'room_me', 'room', 'chatTokenString', 'identity', 'isPatient'));
    }



    public function host($room)
    {
        if (!\Auth::check()) {
=======
=======
>>>>>>> aff83c06c46b2a2c50b6b97843d87d96a2c57f13
        $chatTokenString = $token->toJWT();
        $isPatient = true;

        return view('meeting.join', compact('tokenstring', 'room', 'chatTokenString', 'identity','isPatient'));
    }

    public function host($room)
    {
        if(!\Auth::check()){
<<<<<<< HEAD
>>>>>>> aff83c06c46b2a2c50b6b97843d87d96a2c57f13
=======
>>>>>>> aff83c06c46b2a2c50b6b97843d87d96a2c57f13
            return abort(404);
        }



<<<<<<< HEAD
<<<<<<< HEAD
        /* $twilioAccountSid = getenv('TWILIO_ACCOUNT_SID');
        $twilioToken      = getenv("TWILIO_AUTH_TOKEN");
        $twilioApiKey     = getenv('TWILIO_API_KEY');
        $twilioApiSecret  = getenv('TWILIO_API_KEY_SECRET');*/

        $roomName = substr($room, 0, 25);
        $room_me = substr($room, 0, 25);
=======
=======
>>>>>>> aff83c06c46b2a2c50b6b97843d87d96a2c57f13
        $twilioAccountSid = getenv('TWILIO_ACCOUNT_SID');
        $twilioToken      = getenv("TWILIO_AUTH_TOKEN");
        $twilioApiKey     = getenv('TWILIO_API_KEY');
        $twilioApiSecret  = getenv('TWILIO_API_KEY_SECRET');

        $roomName = $room;
<<<<<<< HEAD
>>>>>>> aff83c06c46b2a2c50b6b97843d87d96a2c57f13
=======
>>>>>>> aff83c06c46b2a2c50b6b97843d87d96a2c57f13

        // An identifier for your app - can be anything you'd like
        $identity = self::slugify(auth()->user()->name);

<<<<<<< HEAD
<<<<<<< HEAD
        $url = "https://api.daily.co/v1/meeting-tokens";
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $headers = array(
            "Content-Type: application/json",
            "Authorization: Bearer 6294b5815005bd3d5e31cc50dc37e4cd5577ba91d9b9b29c1e3f24aa045738ae",
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $data = json_encode([
            "properties" => [
                "room_name" => $roomName,
                "enable_screenshare" => false,
                "enable_recording" => false,
                "user_name" => "Doctor",
                "close_tab_on_exit" => true,
                "redirect_on_meeting_exit" => "https://amiens.cc/upload"
            ]
        ]);

        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $token = json_decode(curl_exec($curl), true);
        curl_close($curl);

        // Create access token, which we will serialize and send to the client
        /*$token = new AccessToken(
=======
        // Create access token, which we will serialize and send to the client
        $token = new AccessToken(
>>>>>>> aff83c06c46b2a2c50b6b97843d87d96a2c57f13
=======
        // Create access token, which we will serialize and send to the client
        $token = new AccessToken(
>>>>>>> aff83c06c46b2a2c50b6b97843d87d96a2c57f13
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

<<<<<<< HEAD
<<<<<<< HEAD
        $chatTokenString = $token->toJWT();*/
        $isPatient = false;
        $tokenstring = $token['token'];
        //dd($tokenstring);
        $chatTokenString = "";
        return view('meeting.join', compact('tokenstring', 'room_me', 'room', 'chatTokenString', 'identity', 'isPatient'));
    }

    public static function slugify($text, string $divider = '-')
    {
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
=======
=======
>>>>>>> aff83c06c46b2a2c50b6b97843d87d96a2c57f13
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
<<<<<<< HEAD
>>>>>>> aff83c06c46b2a2c50b6b97843d87d96a2c57f13
=======
>>>>>>> aff83c06c46b2a2c50b6b97843d87d96a2c57f13
    }

    public function saveRecords(Request $request)
    {
        $room = $request->get("room");
<<<<<<< HEAD
<<<<<<< HEAD
        $patient = \App\Patient::where("room", $room)->first();
=======
        $patient = \App\Patient::where("room",$room)->first();
>>>>>>> aff83c06c46b2a2c50b6b97843d87d96a2c57f13
=======
        $patient = \App\Patient::where("room",$room)->first();
>>>>>>> aff83c06c46b2a2c50b6b97843d87d96a2c57f13

        $validator = Validator::make($request->all(), [
            'file'    => 'required|mimes:jpg,jpeg,png',
        ]);

        if ($validator->fails()) {
<<<<<<< HEAD
<<<<<<< HEAD
            return response()->json(["code" => 500, "message" => "Please attach correct file"]);
        }


        if ($patient) {
            $field = $request->get("field");
            $file  = $request->file('file');
            if ($field == 'front') {
                Storage::putFileAs('public/images/' . $patient->id, $file, 'front.jpg');
=======
=======
>>>>>>> aff83c06c46b2a2c50b6b97843d87d96a2c57f13
            return response()->json(["code" => 500 , "message" => "Please attach correct file"]);
        }
             

        if($patient) {
            $field = $request->get("field");
            $file  = $request->file('file');
            if($field == 'front') {
                Storage::putFileAs('public/images/' .$patient->id, $file, 'front.jpg');
<<<<<<< HEAD
>>>>>>> aff83c06c46b2a2c50b6b97843d87d96a2c57f13
=======
>>>>>>> aff83c06c46b2a2c50b6b97843d87d96a2c57f13
                $patient->ID_front = Storage::url('app/public/images/' . $patient->id . '/front.jpg');
                $patient->save();
            }

<<<<<<< HEAD
<<<<<<< HEAD
            if ($field == 'back') {
                Storage::putFileAs('public/images/' . $patient->id, $file, 'back.jpg');
=======
            if($field == 'back') {
                Storage::putFileAs('public/images/' .$patient->id, $file, 'back.jpg');
>>>>>>> aff83c06c46b2a2c50b6b97843d87d96a2c57f13
=======
            if($field == 'back') {
                Storage::putFileAs('public/images/' .$patient->id, $file, 'back.jpg');
>>>>>>> aff83c06c46b2a2c50b6b97843d87d96a2c57f13
                $patient->ID_back = Storage::url('app/public/images/' . $patient->id . '/back.jpg');
                $patient->save();
            }

<<<<<<< HEAD
<<<<<<< HEAD
            if ($field == 'result') {
                Storage::putFileAs('public/images/' . $patient->id, $file, 'test.jpg');
=======
            if($field == 'result') {
                Storage::putFileAs('public/images/' .$patient->id, $file, 'test.jpg');
>>>>>>> aff83c06c46b2a2c50b6b97843d87d96a2c57f13
=======
            if($field == 'result') {
                Storage::putFileAs('public/images/' .$patient->id, $file, 'test.jpg');
>>>>>>> aff83c06c46b2a2c50b6b97843d87d96a2c57f13
                $patient->test = Storage::url('app/public/images/' . $patient->id . '/test.jpg');
                $patient->save();
            }

<<<<<<< HEAD
<<<<<<< HEAD
            return response()->json(["code" => 200, "message" => "Image updated successfully in your records."]);
=======
            return response()->json(["code" => 200,"message" => "Image updated successfully in your records."]);
>>>>>>> aff83c06c46b2a2c50b6b97843d87d96a2c57f13
=======
            return response()->json(["code" => 200,"message" => "Image updated successfully in your records."]);
>>>>>>> aff83c06c46b2a2c50b6b97843d87d96a2c57f13
        }

        return response()->json(["code" => 500, "message" => "Oops, something went wrong"]);
    }

    public function end()
    {
<<<<<<< HEAD
<<<<<<< HEAD
        return redirect('/upload');
        //return view("meeting.end");
    }

    public function enddoctorside(Request $request, $room)
    {
        if (!\Auth::check()) {
            return abort(404);
        }

        $patient = \App\Patient::where("room", $room)->first();
=======
=======
>>>>>>> aff83c06c46b2a2c50b6b97843d87d96a2c57f13
        return view("meeting.end");
    }

    public function enddoctorside(Request $request , $room)
    {
        if(!\Auth::check()){
            return abort(404);
        }

        $patient = \App\Patient::where("room",$room)->first();
<<<<<<< HEAD
>>>>>>> aff83c06c46b2a2c50b6b97843d87d96a2c57f13
=======
>>>>>>> aff83c06c46b2a2c50b6b97843d87d96a2c57f13
        $patient->test_status = $room;
        $patient->performed_by = auth()->user()->name;
        $patient->save();

        return redirect('/');
    }
}
