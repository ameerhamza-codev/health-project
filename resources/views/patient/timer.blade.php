<!DOCTYPE html>
<html lang="en">

<?php

use App\Patient;
use Illuminate\Console\Scheduling\Schedule;


function schedule(Schedule $schedule)
{
    $schedule->call(function () {

        $patient = Patient::where('id', '1')->first();
        dd($patient);
    })->everyFiveSeconds();
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
    <style>
        .datepicker {
            z-index: 99999 !important;
        }
    </style>
    <link href="{{ asset('assets/plugins/datepicker/datepicker.min.css') }}" rel="stylesheet" type="text/css">
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

    <div id="containerbar px-5" style="text-align: center;">
        <br><br><br><br><br>

        <div class="card-body">

            <!-- <div class="grid-example">
                            <div class="row justify-content-md-center ">
                           
                                <div class="shadow col col-md-auto col-sm-1" style="text-align: center;">
                                <h1 style="font-size: 50px;"><p id="demo"></p></h1>
                                </div>
                              </div>
                             
                        </div> -->
        </div>


        <h3>Please Wait</h3>
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only"></span>


        </div>
        <br>
        <br>
        <br>
        <a id="meet" target="_blank" style="display: none;" class="btn btn-primary mx-5"> Join Meet </a>
        <h1 id="tab" style="display: none;">DONOT CLOSE THIS TAB</h1>



    </div>
    <!-- End Containerbar -->
    <!-- Start JS -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/modernizr.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datepicker/datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-clockpicker.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/datepicker/i18n/datepicker.en.js') }}"></script>
    <script src="{{ asset('assets/js/custom/custom-form-datepicker.js') }}"></script>
    <script src="{{ asset('assets/js/detect.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('assets/js/vertical-menu.js') }}"></script>
    <script src="{{ asset('assets/plugins/switchery/switchery.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-inputmask/jquery.inputmask.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom/custom-form-inputmask.js') }}"></script>
    @yield('script')
    <!-- Core JS -->
    <script src="{{ asset('assets/js/core.js') }}"></script>
    <!-- End JS -->
</body>

<script>
    // Set the date we're counting down to
    var countDownDate = new Date("Jan 5, 2022 15:37:25").getTime();

    // Update the count down every 1 second
    // s

    // setTimeout(function () {
    //        window.location.href = "upload"; //will redirect to your blog page (an ex: blog.html)
    //     }, 5000); //will call the function after 2 secs.
</script>
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
    function sleep(time) {
        return new Promise((resolve) => setTimeout(resolve, time));
    }

    function getCount() {

        $.ajax({
                type: "GET",
                url: "{{ route('get_status') }}"
            })
            .done(function(data) {
                console.log(data);
                if (data != 'null') {
                    document.getElementById("meet").style.display = "block";
                    document.getElementById("tab").style.display = "block";
                    $('#meet').attr('href', data);
                    sleep(10000).then(() => {

                        window.location.href = "upload";
                    });

                }

                setTimeout(getCount, 1000);
            });
    }
    getCount()
</script>

</html>