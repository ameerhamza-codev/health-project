<!DOCTYPE html>


<?php

use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Request;
use GuzzleHttp\Client;

<<<<<<< HEAD
<<<<<<< HEAD
function getIp(){
    foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
        if (array_key_exists($key, $_SERVER) === true){
            foreach (explode(',', $_SERVER[$key]) as $ip){
                $ip = trim($ip); // just to be safe
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                    return $ip;
                }
            }
        }
    }
    return request()->ip(); // it will return server ip when no client ip found
}


$client=new Client();
$res = $client->get('http://ip-api.com/json/'.getIP());
=======

$client=new Client();
$res = $client->get('http://ip-api.com/json/');
>>>>>>> aff83c06c46b2a2c50b6b97843d87d96a2c57f13
=======

$client=new Client();
$res = $client->get('http://ip-api.com/json/');
>>>>>>> aff83c06c46b2a2c50b6b97843d87d96a2c57f13

$response=$res->getBody();
$response=json_decode($response->getContents());
//dd($response->countryCode);
if($response->countryCode=='FR'){
<<<<<<< HEAD
<<<<<<< HEAD
    Session::put('app_locale', 'fr');
    App::setLocale('fr');}
else{
    Session::put('app_locale', 'en');
=======
    App::setLocale('fr');}
else{
>>>>>>> aff83c06c46b2a2c50b6b97843d87d96a2c57f13
=======
    App::setLocale('fr');}
else{
>>>>>>> aff83c06c46b2a2c50b6b97843d87d96a2c57f13
    App::setLocale('en');
}

?>
<html lang="en">

<head>
 
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Orbiter is a bootstrap minimal & clean admin template">
    <meta name="keywords" content="admin, admin panel, admin template, admin dashboard, responsive, bootstrap 4, ui kits, ecommerce, web app, crm, cms, html, sass support, scss">
    <meta name="author" content="Themesbox">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> @yield('title') </title>
    <!-- Fevicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
    <!-- Start CSS -->
    @yield('style')
    <link href="{{ asset('assets/plugins/switchery/switchery.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/flag-icon.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css">
    <!-- End CSS -->
</head>

<body class="vertical-layout">
    <!-- Start Infobar Setting Sidebar -->

    <div class="infobar-settings-sidebar-overlay"></div>
    <!-- End Infobar Setting Sidebar -->
    <!-- Start Containerbar -->
    <div id="containerbar">
        <!-- Start Leftbar -->
        @include('layouts.leftbar')
        <!-- End Leftbar -->
        <!-- Start Rightbar -->
        @include('layouts.rightbar')
        @yield('content')
        <!-- End Rightbar -->
    </div>
    <!-- End Containerbar -->
    <!-- Start JS -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/modernizr.min.js') }}"></script>
    <script src="{{ asset('assets/js/detect.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('assets/js/vertical-menu.js') }}"></script>
    <script src="{{ asset('assets/plugins/switchery/switchery.min.js') }}"></script>
    @yield('script')
    <!-- Core JS -->
    <script src="{{ asset('assets/js/core.js') }}"></script>
    <!-- End JS -->
</body>

</html>


<script>
    $countw = 0;
    $counts = 0;
    setInterval(function() {


        $.ajax({
            type: "get",
            url: "{{ route('meet-notification') }}",
            data: {
                '_token': $('input[name=_token]').val(),

            },

        }).done(function(data) {

            if (data.status == "found") {

               


            } else {

            }


        });
    }, 40000);


    // $prev = 0;
    // $c = 0;

    // setInterval(function() {

    //     $.ajax({
    //         type: "post",
    //         url: "{{ route('checkno') }}",
    //         data: {
    //             '_token': $('input[name=_token]').val(),
    //             'prev': $prev,

    //         },

    //     }).done(function(data) {
    //         if (data.count > $prev && $c != 0) {

    //             showNotification((data.name + " is waiting for appointment"), 'New Patient Registered');


    //         }
    //         $c++;
    //         $prev = data.count;

    //     });
    // }, 1000);


    // function showNotification($name, $message) {

    //     const notification = new Notification($message, {
    //         body: $name,
    //     })
    //     notification.onclick = (e) => {
    //         window.location.href = "{{env('APP_URL')}}/notif";
    //     };
    // }
    // console.log(Notification.permission);
    // if (Notification.permission === "granted") {

    // } else if (Notification.permission !== "denied") {
    //     Notification.requestPermission().then(permission => {
    //         console.log(permission);
    //     });
    // }
<<<<<<< HEAD
<!-- start webpushr tracking code --> 
<script>(function(w,d, s, id) {if(typeof(w.webpushr)!=='undefined') return;w.webpushr=w.webpushr||function(){(w.webpushr.q=w.webpushr.q||[]).push(arguments)};var js, fjs = d.getElementsByTagName(s)[0];js = d.createElement(s); js.id = id;js.async=1;js.src = "https://cdn.webpushr.com/app.min.js";
fjs.parentNode.appendChild(js);}(window,document, 'script', 'webpushr-jssdk'));
webpushr('setup',{'key':'BDTxtEtyHjkCN0TDSBfKDEdAd8phIPQ448JDIikAvNyF6uBBJCzJkVGpz2KTOXAteNQL6OQ8AFl4gtz2JWTsT5M' });</script>
<!-- end webpushr tracking code -->
=======
</script>
<<<<<<< HEAD
<!-- start webpushr code --> <script>(function(w,d, s, id) {if(typeof(w.webpushr)!=='undefined') return;w.webpushr=w.webpushr||function(){(w.webpushr.q=w.webpushr.q||[]).push(arguments)};var js, fjs = d.getElementsByTagName(s)[0];js = d.createElement(s); js.id = id;js.async=1;js.src = "https://cdn.webpushr.com/app.min.js";fjs.parentNode.appendChild(js);}(window,document, 'script', 'webpushr-jssdk'));webpushr('setup',{'key':'BC_ywiCMO_pRO4Xcn0Kdq7jcgA5NyfyghI-QcvRdg4G4zyUCZ4RyvunsXF2NCR_QuWjb6kCn5tXBObXPgtbSf7o' });</script><!-- end webpushr code -->
>>>>>>> aff83c06c46b2a2c50b6b97843d87d96a2c57f13
=======
<!-- start webpushr code --> <script>(function(w,d, s, id) {if(typeof(w.webpushr)!=='undefined') return;w.webpushr=w.webpushr||function(){(w.webpushr.q=w.webpushr.q||[]).push(arguments)};var js, fjs = d.getElementsByTagName(s)[0];js = d.createElement(s); js.id = id;js.async=1;js.src = "https://cdn.webpushr.com/app.min.js";fjs.parentNode.appendChild(js);}(window,document, 'script', 'webpushr-jssdk'));webpushr('setup',{'key':'BC_ywiCMO_pRO4Xcn0Kdq7jcgA5NyfyghI-QcvRdg4G4zyUCZ4RyvunsXF2NCR_QuWjb6kCn5tXBObXPgtbSf7o' });</script><!-- end webpushr code -->
>>>>>>> aff83c06c46b2a2c50b6b97843d87d96a2c57f13
