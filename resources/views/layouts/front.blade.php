<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    
    <title>{{env("APP_NAME")}}</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/assets/front/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/assets/front/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="/assets/front/css/style.css">
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5.9.3/dist/min/dropzone.min.css" type="text/css" />
    <!--[if lt IE 9]>
		<script src="/assets/front/js/html5shiv.min.js"></script>
		<script src="/assets/front/js/respond.min.js"></script>
	<![endif]-->
</head>

<body>
    <div class="main-wrapper">
        @yield('content')
    </div>
    <div class="sidebar-overlay" data-reff=""></div>
    <script src="/assets/front/js/jquery-3.2.1.min.js"></script>
	<script src="/assets/front/js/popper.min.js"></script>
    <script src="/assets/front/js/bootstrap.min.js"></script>
    <script src="/assets/front/js/jquery.slimscroll.js"></script>
    <script src="/assets/front/js/app.js"></script>

    @yield('js-footer')
</body>
</html>