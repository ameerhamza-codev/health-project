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
<link href="{{ asset('assets/plugins/pnotify/css/pnotify.custom.min.css') }}" rel="stylesheet" type="text/css" />

@endsection
@section('rightbar-content')

<?php

use App\passwrod_user;
?>
<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-6 col-lg-6 ">

            <div class="col-md-8 col-lg-8">
                <h2 class="page-title">Settings</h2>

            </div>

        </div>
        <div class="col-md-6 col-lg-6">
            <div class="widgetbar">
                <button class="btn btn-primary" data-toggle="modal" data-target="#UserModalCenter"><i class="feather icon-plus mr-2"></i>Add User</button>
            </div>
        </div>
    </div>
    @if(session('success'))
        <br>
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <br>
        <div class="alert alert-danger" role="alert">
            {{session('error')}}
        </div>
        @endif
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
                        <table class="table table table-bordered" id="edit-btn">
                            <thead>
                                <tr>
                                    <th>Name</th>

                                    <th>Phone Number</th>

                                    <th>Type</th>
                                    <th>Password</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td class="text-dark">{{$user->name}}</td>
                                    <td class="text-dark">+{{$user->phone}}</td>
                                    <td class="text-dark">{{ $user->roles()->pluck('name')[0]}}</td>
                                    <td class="text-dark">{{passwrod_user::Where('user_id',$user->id)->first()->password}}</td>


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

<div class="modal fade" id="UserModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Add User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="background-color: #F2F5FA;">
                <form action="{{ route('user.add') }}" method="POST">
                    @csrf
                    <div class="form-group mb-0">
                        <br>
                        <h6>Name</h6>
                        <input type="text" name="name" class="form-control" placeholder="Name" required>
                        <br>
                        <h6>Phone</h6>
                        <div class="row">
                            <div class="col-lg-4">
                                <select name="code" class="select2-single form-control" required>
                                    <optgroup>
                                        @foreach($code as $code)
                                        <option value="{{$code->country_code}}">{{$code->country_name}} +{{$code->country_code}}</option>
                                        @endforeach
                                    </optgroup>

                                </select>
                            </div>
                            <div class="col-lg-8">
                                <input type="tel" name="phone" class="form-control" placeholder="Phone" required />
                            </div>
                        </div>
                    </div>

                    <br>
                    <h6>User</h6>
                    <select class="select2-single form-control" name="role" required>
                        <optgroup>
                            @foreach($roles as $r)
                            @if ($r->name != 'Patient')
                            <option value="{{$r->id}}" value="7">{{$r->name}}</option>
                            @endif
                            @endforeach
                        </optgroup>
                    </select>
            </div>
            <div class="modal-footer" style="background-color: #F2F5FA;">
                <button type="submit" class="btn btn-primary">Add User</button>
            </div>
            </form>
        </div>
    </div>
</div>




<!-- End Contentbar -->
@endsection
@section('script')
<!-- Datatable js -->
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/pnotify/js/pnotify.custom.min.js') }}"></script>
<script src="{{ asset('assets/js/custom/custom-pnotify.js') }}"></script>
<script src="{{ asset('assets/plugins/tabledit/jquery.tabledit.js') }}"></script>
<script src="{{ asset('assets/js/custom/custom-table-editable.js') }}"></script>
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