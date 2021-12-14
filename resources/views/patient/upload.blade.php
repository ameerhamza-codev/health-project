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
                    <h5 style="text-align: center;">Add Images</h5>

                    <br>
                    <form action="{{ route('patient.upload') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <ul class="nav nav-pills justify-content-center custom-tab-button mb-3" id="pills-tab-button" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="pills-home-tab-button" data-toggle="pill" href="#pills-home-button" role="tab" aria-controls="pills-home-button" aria-selected="true"><span class="tab-btn-icon"></span>Test</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-profile-tab-button" data-toggle="pill" href="#pills-profile-button" role="tab" aria-controls="pills-profile-button" aria-selected="false"><span class="tab-btn-icon"></span>ID Card</a>
                                </li>

                            </ul>


                            <div class="tab-content" id="pills-tabContent-button" style="text-align: center;">
                                <div class="tab-pane fade show active" id="pills-home-button" role="tabpanel" aria-labelledby="pills-home-tab-button">


                                    <div class="form-group files color">
                                        <label>Upload Your File </label>
                                        <input type="file" name="Test" class="form-control" multiple="">
                                    </div>


                                </div>
                                <div class="tab-pane fade" id="pills-profile-button" role="tabpanel" aria-labelledby="pills-profile-tab-button">
                                    <h6>Front</h6>
                                    <div class="form-group files color">
                                        <label>Upload Your File </label>
                                        <input type="file" name="IDFront" class="form-control"  multiple="">
                                    </div>
                                    <br>
                                    <h6>Back</h6>
                                    <div class="form-group files color">
                                        <label>Upload Your File </label>
                                        <input type="file" name="IDBack" class="form-control" multiple="">
                                    </div>
                                </div>

                            </div>

                        </div>
                        <!-- <div class="sweet-alert">
                        <button type="button" class="btn btn-primary" id="sa-success">Submit</button>
                    </div> -->
                        <div class="px-5">
                        <button type="submit" data-toggle="modal" data-target=".bd-example-modal-sm" class="btn btn-primary btn-sm">Submit</button>
                     </div>
                    </form>
                    <br>
                </div>



            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <button class="btn btn-primary" type="button" disabled>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    <span class="sr-only">Uploading...</span>
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

    function upload() {

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