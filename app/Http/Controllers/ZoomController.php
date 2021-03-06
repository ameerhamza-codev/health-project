<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use App\ZoomMeetings;
use App\Http\Controllers\SMSController;
use Illuminate\Support\Facades\Auth;
use PhpParser\NodeVisitor\FirstFindingVisitor;
use Twilio\Page;
use App\Http\Controllers\notifController;
use DateTime;
use DateTimeZone;

class ZoomController extends Controller
{

    public $client;
    public $jwt;
    public $headers;
    const MEETING_TYPE_INSTANT = 1;
    const MEETING_TYPE_SCHEDULE = 2;
    const MEETING_TYPE_RECURRING = 3;
    const MEETING_TYPE_FIXED_RECURRING_FIXED = 8;


    public function __construct()
    {
        $this->client = new Client();
        $this->jwt = $this->generateZoomToken();
        $this->headers = [
            'Authorization' => 'Bearer ' . $this->jwt,
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
        ];
    }

    public function generateZoomToken()
    {
        $key = env('ZOOM_API_KEY', '');
        $secret = env('ZOOM_API_SECRET', '');
        $payload = [
            'iss' => $key,
            'exp' => strtotime('+1 minute'),
        ];

        return \Firebase\JWT\JWT::encode($payload, $secret, 'HS256');
    }

    public function retrieveZoomUrl()
    {
        return env('ZOOM_API_URL', '');
    }

    public function toZoomTimeFormat(string $dateTime)
    {
        try {
            $date = new \DateTime($dateTime);

            return $date->format('Y-m-d\TH:i:s');
        } catch (\Exception $e) {
            Log::error('ZoomJWT->toZoomTimeFormat : ' . $e->getMessage());

            return '';
        }
    }


    public function create($data)
    {
        $path = 'users/me/meetings';
        $url = $this->retrieveZoomUrl();

        $body = [
            'headers' => $this->headers,
            'body'    => json_encode([
                'topic'      => $data['topic'],
                'type'       => self::MEETING_TYPE_SCHEDULE,
                'start_time' => $this->toZoomTimeFormat($data['start_time']),
                'agenda'     => (!empty($data['agenda'])) ? $data['agenda'] : null,
                'timezone'     => 'Asia/Karachi',
                'settings'   => [
                    'host_video'        => ($data['host_video'] == "1") ? true : false,
                    'participant_video' => ($data['participant_video'] == "1") ? true : false,
                    'waiting_room'      => true,
                ],
            ]),
        ];

        $response =  $this->client->post($url . $path, $body);

        return [
            'success' => $response->getStatusCode() === 201,
            'data'    => json_decode($response->getBody(), true),
        ];
    }

    public function index()
    {
        return view('zoom.index');
    }

    public function update(Request $request)
    {
        $matchThese = ['start_time' => $request->time, 'phone' => $request->phone];
        $zoom2 = ZoomMeetings::where($matchThese)->get();
        //$zoom2= ZoomMeetings::where('start_time','=',$request->time)->get();
        if (isset($zoom2[0])) {
            $time=new DateTime($request->time2,new DateTimeZone('Asia/Karachi'));
            //$time->setTimezone(new DateTimeZone('UTC'));
            $time=$time->format('Y-m-d H:i');
            $notif = new notifController();

            $id = ($zoom2[0]->id);
            $upzoom = ZoomMeetings::find($id);
            $upzoom->start_time = $request->time2;
            $upzoom->save();
            $sms = new SMSController();
            $sms->sendSMS($request->phone, env('APP_URL', '') . '/patient-area', $request->time2);
            $notif->createnotif('Meeting Created', $request->code . $request->phone);
            $notif->createnotifdate('Upcomming Meeting', $request->code . $request->phone, $time);

        }
        return redirect()->back();
    }
    public function store(Request $request)
    {

        $sms = new SMSController();
        $notif = new notifController();
        
        $time=new DateTime($request->date,new DateTimeZone('Asia/Karachi'));
        //$time->setTimezone(new DateTimeZone('UTC'));
        $time=$time->format('Y-m-d H:i');
        
        if ($request->send == 'true')   {
            if ($sms->sendSMS($request->code . $request->phone, env('APP_URL', '') . '/patient-area', $request->date) == 1) {
                $notif->createnotif('Meeting Created', $request->code . $request->phone);
                $notif->createnotifdate('Upcomming Meeting', $request->code . $request->phone, $time);


                return redirect()->back()->with('meeting-success', 'Meeting Created Successfully');
            } else {

                $notif->createnotif('SMS not Sent', $request->code . $request->phone);
                $notif->createnotifdate('Upcomming Meeting', $request->code . $request->phone, $time);

               
                return redirect()->back()->with('meeting-error', 'Error in sending SMS');
            }
            
        } elseif ($request->add == 'true') {
            $todate = date('Y-m-d H:i:s');
            $meeting_dates = ZoomMeetings::all();


            foreach ($meeting_dates as $key) {
                if (strtotime($key->start_time) < strtotime($todate)) {

                    ZoomMeetings::find($key->id)->delete();
                }
    }



            $meeting = new ZoomMeetings();
            $meeting->start_time = $request->date;
            $meeting->phone = $request->code . $request->phone;
            $meeting->save();
            if ($sms->sendSMS($request->code . $request->phone, env('APP_URL', '') . '/patient-area', $request->date) == 1) {
                $notif->createnotif('Meeting Created', $request->code . $request->phone);
                $notif->createnotifdate('Upcomming Meeting', $request->code . $request->phone, $time);


                return redirect()->back()->with('meeting-success', 'Meeting Created Successfully');
            } else {

                $notif->createnotif('SMS not Sent', $request->code . $request->phone);
                $notif->createnotifdate('Upcomming Meeting', $request->code . $request->phone, $time);

                return redirect()->back()->with('meeting-error', 'Error in sending SMS');
            }

            //return redirect()->back()->with('meeting-success','Meeting Added to  Successfully');

        }
    }
}
