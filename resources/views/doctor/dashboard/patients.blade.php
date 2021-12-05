@section('title')
Datatable
@endsection
@extends('layouts.main')


<?php

use App\Patient;

$patient = Patient::all();
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
                <a href="{{route('bulk-generate')}}" class="btn btn-primary"  ><i class="feather icon-file mr-2"></i>Bulk Generate CSV</a>
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
                                            <td class="text-dark"><button type="button" class="btn btn-success" style="padding-inline: 33px;" disabled><i class="feather icon-check mr-2"></i>Success</button></td>
                                            <td class="text-dark"><button type="submit" class="btn btn-primary-rgba"><i class="feather icon-file-text mr-2"></i>Generate CSV</button></td>

                                            <td class="text-dark">
                                                <a href="{{env('APP_URL').$patient->test}}" target="_blank"><img src="{{env('APP_URL').$patient->test}}" alt="" style="max-width: 50px;"></a>
                                            </td>
                                            <td><input type="hidden" name="id" value="{{$patient->id}}"></td>
                                            </form>
                                    </tr>
                                    
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