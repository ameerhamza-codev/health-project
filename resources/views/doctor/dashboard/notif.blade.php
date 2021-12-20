@section('title')
Datatable
@endsection
@extends('layouts.main')
@section('style')
<!-- DataTables css -->
<link href="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<!-- Responsive Datatable css -->
<link href="{{ asset('assets/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('rightbar-content')

<?php

use Illuminate\Support\Facades\App;
use App\Patient;

$patient = Patient::all()->sortByDesc('id');

App::setLocale(Session('app_locale'));



?>

@if(Session('open'))
<a hidden id="zoom_url" href="{{Session('open')}}" target="_blank">
</a>
<script>
    var myWindow = window.open("about:blank", 'name', 'height=500,width=550');

    function showWindow(win, url) {
        win.open(url, 'name', 'height=500,width=550');
    }
    // $('zoom_url').trigger('click');
    //document.getElementById('zoom_url').trigger('click');
    //     d.onclick = () => {
    //         window.open("{{Session('open')}}");
    //     };
    //     d.click();
    // let newTab = window.open();
    // newTab.location.href = "{{Session('open')}}"
</script>
@endif
<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-6 col-lg-6 ">

            <div class="col-md-8 col-lg-8">
                <h2 class="page-title">Notifications</h2>

            </div>

        </div>
    </div>
</div>

<!-- Start Contentbar -->
<div class="contentbar">
    <!-- Start row -->
    <div class="row">
        <!-- Start col -->
        <div class="col-lg-12">
            <div class="card m-b-30">

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="default-datatable" class="display table table-bordered">
                            <thead>
                                <tr>
                                    <th>Test ID</th>

                                    <th>Patient</th>

                                    <th>Date And Time</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach($patient as $patient)
                                <tr>
                                    <form method="POST" action="{{ route('accept_session') }}">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$patient->id}}">
                                        <td class="text-dark">{{$patient->test_no }}</td>
                                        <td class="text-dark">{{$patient->first_name}} {{$patient->last_name}}</td>
                                        <td class="text-dark">{{$patient->created_at}}</td>
                                        @if($patient->test_status == null)
                                        <td><a href="/host/{{$patient->room}}"><button type="button" class="btn btn-primary-rgba"><i class="feather icon-file-text mr-2"></i>{{__('Access Test')}}</button></a> 
                                            <!-- <button type="button" data-toggle="modal" data-target=".bd-example-modal-sm" onclick="asses()"  class="btn btn-primary-rgba"><i class="feather icon-file-text mr-2"></i>{{__('Access Test')}}</button> --></td>
                                        @endif

                                </tr>
                                </form>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Test ID</th>

                                    <th>Patient</th>

                                    <th>Date And Time</th>
                                    <th>Action</th>

                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- End row -->
</div>

<div class="modal fade bd-example-modal-sm" id="smallload" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <button class="btn btn-primary" type="button" disabled>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    <span class="sr-only"></span>
                </button>
            </div>
        </div>
</div>

<!-- End Contentbar -->
@endsection
@section('script')
<!-- Datatable js -->
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/jszip.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/js/custom/custom-table-datatable.js') }}"></script>


<script>
    function asses() {

        $('#smallload').modal('show');
        setTimeout(function() {
            $('#smallload').modal('hide');
        }, 3000);
        $.ajax({
            url: "{{ route('accept_session') }}",
            type: "POST",

            data: {
                '_token': "{{ csrf_token() }}",
                'id': $('input[name=id]').val(),
            },
            success: function(data) {

                window.open(data.url, '_blank');
                console.log(data.url);


            },
        });
    }
</script>
@endsection