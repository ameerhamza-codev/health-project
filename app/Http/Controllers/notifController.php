<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class notifController extends Controller
{
    public function createnotif($title, $message)
    {
        $end_point = 'https://api.webpushr.com/v1/notification/send/all';

        
        $http_header = array( 
            "Content-Type: Application/Json", 
            "webpushrKey: ".env('WEBPUSHR_KEY'),
            "webpushrAuthToken: ".env('WEBPUSHR_AUTH_TOKEN')
        );
        $req_data = array(
            'title' 		=> $title, //required
            'message' 		=> $message, //required
            'target_url'	=> env('APP_URL'), //required
        
            //following parameters are optional
            //'name'		=> 'Test campaign',
            //'icon'		=> 'https://cdn.webpushr.com/siteassets/wSxoND3TTb.png',
            //'image'		=> 'https://cdn.webpushr.com/siteassets/aRB18p3VAZ.jpeg',
            'auto_hide'	=> 1,
            //'expire_push'	=> '5m',
            
           
            // 'action_buttons'=> array(	
            //     array('title'=> 'Open', 'url' => $url),
            // )
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
        curl_setopt($ch, CURLOPT_URL, $end_point );
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($req_data) );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $response = curl_exec($ch);
      
    }

    public function createnotifurl($title, $message,$url)
    {
        $end_point = 'https://api.webpushr.com/v1/notification/send/all';

        
        $http_header = array( 
            "Content-Type: Application/Json", 
            "webpushrKey: ".env('WEBPUSHR_KEY'),
            "webpushrAuthToken: ".env('WEBPUSHR_AUTH_TOKEN')
        );
        $req_data = array(
            'title' 		=> $title, //required
            'message' 		=> $message, //required
            'target_url'	=> env('APP_URL'), //required
        
            //following parameters are optional
            //'name'		=> 'Test campaign',
            //'icon'		=> 'https://cdn.webpushr.com/siteassets/wSxoND3TTb.png',
            //'image'		=> 'https://cdn.webpushr.com/siteassets/aRB18p3VAZ.jpeg',
            'auto_hide'	=> 1,
            //'expire_push'	=> '5m',
            
           
            'action_buttons'=> array(	
                array('title'=> 'Open', 'url' => $url),
            )
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
        curl_setopt($ch, CURLOPT_URL, $end_point );
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($req_data) );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $response = curl_exec($ch);
      
    }

    public function createnotifdate($title, $message, $time)
    {   
       
        $end_point = 'https://api.webpushr.com/v1/notification/send/all';

        
        $http_header = array( 
            "Content-Type: Application/Json", 
            "webpushrKey: ".env('WEBPUSHR_KEY'),
            "webpushrAuthToken: ".env('WEBPUSHR_AUTH_TOKEN')
        );
        $req_data = array(
            'title' 		=> $title, //required
            'message' 		=> $message, //required
            'target_url'	=> env('APP_URL'), //required
        
            //following parameters are optional
            //'name'		=> 'Test campaign',
            //'icon'		=> 'https://cdn.webpushr.com/siteassets/wSxoND3TTb.png',
            //'image'		=> 'https://cdn.webpushr.com/siteassets/aRB18p3VAZ.jpeg',
            'auto_hide'	=> 1,
            //'expire_push'	=> '5m',
            
            'send_at'=> $time." +05:00"
            // 'action_buttons'=> array(	
            //     array('title'=> 'Open', 'url' => $url),
            // )
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
        curl_setopt($ch, CURLOPT_URL, $end_point );
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($req_data) );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $response = curl_exec($ch);
       
    }
}
