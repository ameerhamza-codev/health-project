<!DOCTYPE html>
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
    $prev=0;
    $c=0;
    setInterval(function() {
        
        $.ajax({
            type: "post",
            url: "{{ route('checkno') }}",
            data: {
                '_token': $('input[name=_token]').val(),
                'prev': $prev,
                
            },

        }).done(function(data){
            if(data.count > $prev && $c!=0){
                
            showNotification(data.name);
            

            }
            $c++;
        $prev=data.count;
        
        });
    }, 1000);


    function showNotification($name) {
        
        const notification = new Notification("New Patient", {
            body: $name + " has requested a test",
        })
        notification.onclick = (e) => {
            window.location.href = "{{env('APP_URL')}}/notif";
        };
    }
    console.log(Notification.permission);
    if (Notification.permission === "granted") {
       
    } else if (Notification.permission !== "denied") {
        Notification.requestPermission().then(permission => {
            console.log(permission);
        });
    }
</script>