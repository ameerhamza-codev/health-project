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
    <div id="containerbar">

        <!-- Modal -->
        <div class="modal fade" id="theModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-center" role="document">
                <div class="modal-content" style="text-align: center; background-color: #F2F5FA;">
                    <br>

                    <h5 style="text-align: center;">Please Fill This Form</h5>
                   
                    <br>
                    <div class="card-body">
                    <form action="{{ route('patient.store') }}" method="POST">
                        @csrf
                        <div class="input-group">
                       
                            <input type="text" class="form-control" placeholder="First Name" name="fname" required />
                            <span class="input-group-addon"></span>
                            <input type="text" class="form-control" placeholder="Last Name" name="lname" required/>
                        </div>
                        <br>
                        <div class="input-group">
                            <input type="text" id="autoclose-date" name="dob" class="datepicker-here form-control" required placeholder="Date of Birth" aria-describedby="basic-addon3" />
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon3"><i class="feather icon-calendar"></i></span>
                            </div>
                        </div>
                        <br>
                        <div class="form-group mb-0">
                            <input type="email"  required class="form-control" name="email" name="inputEmail" id="inputEmail" placeholder="Email">
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-4">
                                <select class="select2-single form-control" required name="code">
                                    <optgroup>
                                        @foreach($code as $code)
                                        <option value="{{$code->country_code}}">{{$code->country_name}} +{{$code->country_code}}</option>
                                        @endforeach
                                    </optgroup>

                                </select>
                            </div>
                            <div class="col-lg-8">
                                <input type="tel" class="form-control" required name="phone" placeholder="Phone" />
                            </div>
                        </div>

                        <br>
                        <div class="form-group">
                            <textarea class="form-control" required name="address" id="inputTextarea" rows="3" placeholder="Adress"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer" style="background-color: #F2F5FA;">
                       <button type="submit" class="btn btn-primary btn-lg btn-block font-18">Proceed</button>

                    </div>

                    </form>

                </div>
            </div>
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

<script type="text/javascript">
    $(window).on('load', function() {
        $('#theModal').modal('show');

    });
    $('#theModal').modal({
        backdrop: 'static',
        keyboard: false
    });
</script>

</html>