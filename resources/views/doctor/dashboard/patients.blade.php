@section('title')
Datatable
@endsection
@extends('layouts.main')


<?php

use App\Patient;
use Illuminate\Support\Facades\App;
App::setLocale(Session('app_locale'));

$patient = Patient::all()->sortByDesc('id');
?>
@section('style')
<!-- DataTables css -->
<link href="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<!-- Responsive Datatable css -->
<link href="{{ asset('assets/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('rightbar-content')
<<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-6 col-lg-6 ">

            <div class="col-md-8 col-lg-8">
                <h2 class="page-title">Patients</h2>

            </div>

        </div>
        <div class="col-md-6 col-lg-6">
            <div class="widgetbar">
                <a href="{{route('bulk-generate')}}" class="btn btn-primary"><i class="feather icon-file mr-2"></i>Bulk Generate CSV</a>
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

                                        <th>Name</th>
                                        <th>Phone Number</th>
                                        <th>Email</th>
                                        <th>Date of Birth</th>
                                        <th>Result</th>
                                        
                                        <th>Performed By</th>
                                        <th>Generate CSV</th>

                                        <th></th>
                                    </tr>

                                </thead>
                                <tbody>
                                    @foreach($patient as $patient)
                                    <tr>
                                        <form method="POST" action="{{ route('generateCSV') }}">
                                            @csrf




                                            <td class="text-dark">{{$patient->first_name}} {{$patient->last_name}}</td>
                                            <td class="text-dark">{{$patient->phone}}</td>
                                            <td class="text-dark">{{$patient->email}}</td>
                                            <td class="text-dark">{{$patient->date_of_birth}}</td>
                                            @if($patient->result != null)

                                            <td class="text-dark">
                                            @if($patient->result == "Success")
                                            <button type="button" class="btn btn-success" style=" width: 100px;" disabled>{{$patient->result}}</button>
                                            @elseif($patient->result == "Fail")
                                            <button type="button" class="btn btn-danger" style=" width: 100px;" disabled>{{$patient->result}}</button>
                                            @else
                                            <button type="button" class="btn btn-warning" style=" width: 100px;" disabled>{{$patient->result}}</button>
                                            @endif
                                        </td>
                                            @else
                                            <td></td>
                                            @endif
                                            <td class="text-dark">{{$patient->performed_by}}</td>
                                              

                                            <td class="text-dark">
                                            @if($patient->result == "Success")  
                                                <button type="submit" class="btn btn-primary-rgba"><i class="feather icon-file-text mr-2"></i>Generate CSV</button></td>
                                                @endif
                                            <td>
                                                <!-- <a href="{{env('APP_URL').$patient->test}}" target="_blank"><img src="{{env('APP_URL').$patient->test}}" alt="" style="max-width: 50px; max-height:50px"></a> -->
                                                <button type="button" value="{{env('APP_URL').$patient->ID_back}},{{env('APP_URL').$patient->ID_front}},{{env('APP_URL').$patient->test}}" id="modalbutton" class="btn btn-rounded btn-primary-rgba"><i class="feather icon-image"></i></button>
                                                <br>
                                            </td>
                                            <td>
                                                <input type="hidden" name="id" value="{{$patient->id}}">
                                            </td>
                                        </form>
                                    </tr>

                                    
                                <!-- Modal -->
                                <div class="modal fade" id="ImageModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-center" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalCenterTitle">Images</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <div class="modal-body" style="background-color: #F2F5FA;">

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
                                                            <img id="imgtest" style="max-width: 300px;" alt="">
                                                        </div>
                                                        <div class="tab-pane fade" id="pills-profile-button" role="tabpanel" aria-labelledby="pills-profile-tab-button">
                                                            <h6>Front</h6>
                                                            <img id="imgfront" style="max-width: 300px;" alt="">
                                                            <h6>Back</h6>
                                                            <img id="imgback" style="max-width: 300px;" alt="">
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>

                                    @endforeach

                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- End row -->
    </div>
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <input type="hidden" name="posting">
                <img src="https://static.remove.bg/remove-bg-web/a76316286d09b12be1ebda3b400e3f44716c24d0/assets/start-1abfb4fe2980eabfbbaaa4365a0692539f7cd2725f324f904565a9a744f8e214.jpg" style="max-width: 100%;" alt="">
            </div>
        </div>
    </div>
    <!-- End Contentbar -->
    @endsection
    @section('script')
    <script>
         $(document).on("click", "#modalbutton", function() {
        var fields = $(this).attr('value').split(',');

        $('#imgback').attr('src', "");
        $('#imgback').attr('src', fields[0]);
        $('#imgfront').attr('src', "");
        $('#imgfront').attr('src', fields[1]);
        $('#imgtest').attr('src', "");
        $('#imgtest').attr('src', fields[2]);
        $('#ImageModalCenter').modal('show');
    });

    </script>
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
    @endsection