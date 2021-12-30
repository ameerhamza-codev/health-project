<!DOCTYPE html>
<html lang="en">
<?php

use GuzzleHttp\Client;

function getIp3()
{
    foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
        if (array_key_exists($key, $_SERVER) === true) {
            foreach (explode(',', $_SERVER[$key]) as $ip) {
                $ip = trim($ip); // just to be safe
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                    return $ip;
                }
            }
        }
    }
    return request()->ip(); // it will return server ip when no client ip found
}

$client = new Client();
$res = $client->get('http://ip-api.com/json/' . getIP3());

$response = $res->getBody();
$response = json_decode($response->getContents());
//dd($response->countryCode);
if ($response->countryCode == 'FR') {
    Session::put('app_locale', 'fr');
    App::setLocale('fr');
} else {
    Session::put('app_locale', 'en');
    App::setLocale('en');
}
?>


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
   
    </style>
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/flag-icon.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/files.css') }}" rel="stylesheet" type="text/css">
    <!-- End CSS -->
</head>

<body class="vertical-layout">
    <!-- Start Infobar Setting Sidebar -->

    <div class="infobar-settings-sidebar-overlay"></div>
    <!-- End Infobar Setting Sidebar -->
    <!-- Start Containerbar -->
    <div id="containerbar">

        <!-- Modal -->
        <div class="modal fade" id="theModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-center" role="document">
                <div class="modal-content" style="text-align: center; background-color: #F2F5FA;">
                    <br>
                    @if(session('error'))
                    <div class="alert alert-warning" role="alert">
                        {{ session('error') }}
                    </div>
                    @endif
                    <h5 style="text-align: center;">{{__('Add Images')}}</h5>

                    <br>
                    <form action="{{ route('patient.upload') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <ul class="nav nav-pills justify-content-center custom-tab-button mb-3" id="pills-tab-button" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="pills-home-tab-button" data-toggle="pill" href="#pills-home-button" role="tab" aria-controls="pills-home-button" aria-selected="true"><span class="tab-btn-icon"></span>{{__('Test')}}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-profile-tab-button" data-toggle="pill" href="#pills-profile-button" role="tab" aria-controls="pills-profile-button" aria-selected="false"><span class="tab-btn-icon"></span>{{__('ID Card')}}</a>
                                </li>

                            </ul>


                            <div class="tab-content" id="pills-tabContent-button" style="text-align: center;">
                                <div class="tab-pane fade show active" id="pills-home-button" role="tabpanel" aria-labelledby="pills-home-tab-button">


                                    <div class="form-group files color">
                                        <label>{{__('Upload Your File')}} </label>
                                        <input type="file" name="Test" class="form-control" multiple="">
                                    </div>


                                </div>
                                <div class="tab-pane fade" id="pills-profile-button" role="tabpanel" aria-labelledby="pills-profile-tab-button">
                                    <h6>{{__('Front')}}</h6>
                                    <div class="form-group files color">
                                        <label>{{__('Upload Your File')}}</label>
                                        <input type="file" name="IDFront" class="form-control"  multiple="">
                                    </div>
                                    <br>
                                    <h6>{{__('Back')}}</h6>
                                    <div class="form-group files color">
                                        <label>{{__('Upload Your File')}}</label>
                                        <input type="file" name="IDBack" class="form-control" multiple="">
                                    </div>
                                </div>

                            </div>

                        </div>
                        <!-- <div class="sweet-alert">
                        <button type="button" class="btn btn-primary" id="sa-success">Submit</button>
                    </div> -->
                        <div class="px-5">
                        <button type="submit" onclick="upload_click" id="upload_btn_save" data-toggle="modal" data-target=".bd-example-modal-sm" class="btn btn-primary btn-sm">{{__('Submit')}}</button>
                     </div>
                    </form>
                    <br>
                </div>



            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-sm" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content" align="center" style="margin-left:10px;margin-right:10px;background:#fff;">
                <span style="color:#000;padding-top:20px;padding-bottom:20px;">Uploading.....</span>
                <!-- <button class="btn btn-primary" type="button" disabled>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    <span>Uploading....</span> class="sr-only" -->
                </button>
            </div>
        </div>
    </div>




    <!-- End Containerbar -->
    <!-- Start JS -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    
    <script src="{{ asset('assets/js/custom/custom-form-inputmask.js') }}"></script>

    @yield('script')
    <!-- Core JS -->
    <script src="{{ asset('assets/js/core.js') }}"></script>
    <!-- End JS -->
</body>

<script type="text/javascript">
    $(window).on('load', function() {
        $('#theModal').modal('show');
        
    });
    $('#theModal').modal({
        backdrop: 'static',
        keyboard: false
    });
</script>


<script>
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	
	
    
	function upload_click(){
		document.getElementById("upload_btn_save").innerHTML = "Uploading files.......";
	}
	
    function upload() {

        document.getElementById("upload_btn_save").innerHTML = "Uploading.......";
        $.ajax({
            url: "{{ route('patient.upload') }}",
            type: "POST",
            data: {
                _token: CSRF_TOKEN,
                file0: $('#file0').files,
            },
            dataType: 'JSON',
        });

    }
</script>

</html>