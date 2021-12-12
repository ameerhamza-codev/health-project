@extends('layouts.main')
@section('style')
<style>
    .form-control {
        color: black !important;

        font-size: 15px;
        color: #8A98AC;
        border: 1px solid rgba(0, 0, 0, 0.4) !important;
        border-radius: 3px;


    }
</style>
<link href="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<!-- Responsive Datatable css -->
<link href="{{ asset('assets/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

<?php

use App\Patient;
use App\CountryCode;
use App\Http\Controllers\ZoomController;
use App\ZoomMeetings;
use Illuminate\Support\Facades\App;

App::setLocale(Session('app_locale'));

$csvrecords = Patient::where('csv_date', '!=', null)->count();

$meetings = ZoomMeetings::all();
$code = CountryCode::all();
$code2 = CountryCode::all();
$patient = Patient::all()->sortByDesc('id');
$patient2 = Patient::all();
$paitentno = Patient::all()->count();
$meetingsno = ZoomMeetings::all()->count();




//$name = str_replace(': Event_by_Calendly', '', $r['1']['topic']);



?>
<style>
    .datepicker {
        z-index: 9999999 !important;
    }
</style>
<!-- Responsive Datatable css -->
@endsection
@section('rightbar-content')


<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-6 col-lg-6 ">

            <div class="col-md-8 col-lg-8">
                <h2 class="page-title">{{__('Test Status')}}</h2>
                <!-- {{auth()->user()->roles()->pluck('name')[0]}} -->
            </div>

        </div>

    </div>


</div>

<br>
<!-- End row -->
<!-- Start row -->
<div class="contentbar">
    <!-- Start row -->
    <div class="row">
        <!-- Start col -->
        <div class="col-lg-12">
            <div class="card m-b-30">

        <input id="search" type="text" class="form-control" placeholder="Search..">

                <div class="card-body">
                    <div class="table-responsive">
                        <table  class="display table" width="100%" >
                            <thead>
                                <tr>
                                    <th>{{__('Name')}}</th>
                                    <th>{{__('Test Date')}}</th>
                                    <th>{{__('Result')}}</th>
                                    <th>{{__('Generate CSV')}}</th>
                                    <th>{{__('CSV Generated')}}</th>
                                    <th>{{__('Performed By')}}</th>
                                    <th>{{__('Tests')}}</th>
                                    <th>{{__('Action')}}</th>
                                    <th></th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach($patient as $patient)

                                <form method="POST" id="patient_form" action="{{ route('generateCSV') }}">
                                    <tr class="vari3"> 
                                        @csrf
                                        <input type="hidden" name="id" value="{{$patient->id}}">
                                        <input type="hidden" name="generate" id="generate">

                                        <td class="vari" >{{$patient->first_name}} {{$patient->last_name}}</td>
                                        <td class="vari2">{{$patient->updated_at}}</td>
                                        <td class="vari2">
                                            @if((auth()->user()->name == $patient->performed_by && auth()->user()->roles()->pluck('id')[0] == 1) || auth()->user()->roles()->pluck('id')[0] == 3)

                                            @if(__($patient->result) == __('On Hold'))
                                            <select class="select2-single form-control" style="background-color: #ffa800;" id="testselect" name="test_status" required>
                                                @elseif(__($patient->result) == __('Success'))
                                                <select class="select2-single form-control" style="background-color: #18d26b;" id="testselect" name="test_status" required>
                                                    @elseif(__($patient->result) == __('Fail'))
                                                    <select class="select2-single form-control" style="background-color: #ff3f3f;" id="testselect" name="test_status" required>
                                                        @else
                                                        <select class="select2-single form-control" id="testselect" name="test_status" required>
                                                            @endif

                                                            <option value="{{$patient->result}}" selected hidden style="font-weight: bold;">{{__($patient->result)}}</option>

                                                            <option value="On Hold" class="btn-warning"><span class="btn-primary">{{__('On Hold')}}</span></option>
                                                            <option value="Fail" class="btn-danger"><span class="btn-danger">{{__('Fail')}}</span></option>
                                                            <option value="Success" class="btn-success"><span class="btn-success">{{__('Success')}}</span></option>

                                                        </select>
                                                        @else
                                                        @if($patient->result != null)
                                                        @if($patient->result == "Success")
                                                        <button type="button" class="btn btn-success" style=" width: 100px;" disabled>{{$patient->result}}</button>
                                                        @elseif($patient->result == "Fail")
                                                        <button type="button" class="btn btn-danger" style=" width: 100px;" disabled>{{$patient->result}}</button>
                                                        @else
                                                        <button type="button" class="btn btn-warning" style=" width: 100px;" disabled>{{$patient->result}}</button>
                                                        @endif
                                                        @endif
                                                        @endif
                                        </td>

                                        <input type="hidden" name="imgfrontin" value="{{env('APP_URL').$patient->ID_back}}">

                                        <td class="vari2">
                                            @if((auth()->user()->name == $patient->performed_by && auth()->user()->roles()->pluck('id')[0] == 1) || auth()->user()->roles()->pluck('id')[0] == 3)
                                            @if($patient->result == "Success")
                                            <button type="submit"  class="btn btn-secondary-rgba"><i class="feather icon-file-text mr-2"></i>{{__('Generate CSV')}}</button>
                                            @else
                                            <button type="submit" disabled  class="btn btn-secondary-rgba"><i class="feather icon-file-text mr-2"></i>{{__('Generate CSV')}}</button>
                                
                                            @endif
                                            @endif
                                        </td>



                                        <td class="vari2">{{$patient->csv_date}}</td>
                                        <td class="vari2">{{$patient->performed_by}}</td>
                                        <td class="vari2">
                                            <!-- <a href="{{env('APP_URL').$patient->test}}" target="_blank"><img src="{{env('APP_URL').$patient->test}}" alt="" style="max-width: 50px; max-height:50px"></a> -->
                                            <button type="button" value="{{env('APP_URL').$patient->ID_back}},{{env('APP_URL').$patient->ID_front}},{{env('APP_URL').$patient->test}}" id="modalbutton" class="btn btn-rounded btn-primary-rgba"><i class="feather icon-image"></i></button>
                                        </td>
                                        <td class="vari2">
                                            @if((auth()->user()->name == $patient->performed_by && auth()->user()->roles()->pluck('id')[0] == 1) || auth()->user()->roles()->pluck('id')[0] == 3)

                                            <button type="submit" name="submit" value="Save" class="btn btn-outline-success"><i class="feather icon-check"></i></button>
                                            @endif
                                        </td>
                                        <td></td>
                                    </tr>
                                </form>





                                @endforeach


                            </tbody>


                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>


</div>

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



<div class="modal fade" id="CalModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="card-body">
                <br>
                <br>
                <div class="container">

                    <div id='calendarFull'></div>
                </div>

                <div class="modal fade" id="event-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content shadow" style="background-color: #F2F5FA;">
                            <form action="{{route('zoom.store')}}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <form name="save-event">
                                        <div class="form-group">
                                            <select class="select2-single form-control" id="pat2" onChange="updateinput();" name="pat">
                                                <optgroup>
                                                    <option value="" disabled selected hidden>{{__('Select Already Registered Patient')}}</option>
                                                    @foreach($patient2->unique('email') as $pat)
                                                    <option value="{{$pat->id}}">{{$pat->first_name}} {{$pat->last_name}} ({{$pat->email}}) </option>
                                                    @endforeach
                                                </optgroup>

                                            </select>

                                        </div>
                                        <div class="row">



                                            <div class="col-lg-4">


                                                <select class="select2-single form-control" id="code2" name="code" required>
                                                    <optgroup>
                                                        @foreach($code2 as $code)
                                                        <option value="{{$code->country_code}}">{{$code->country_name}} +{{$code->country_code}}</option>
                                                        @endforeach
                                                    </optgroup>

                                                </select>
                                            </div>
                                            <div class="col-lg-8">
                                                <input type="tel" class="form-control" id="phone2" name="phone" placeholder="{{__('Phone')}}" required />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Event start</label>


                                            <input type="text" name="date" id="ev_date" class="form-control col-xs-3" required />
                                        </div>


                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" name="add" value="true" class="btn btn-primary">Save changes</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="event-details" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Meeting Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('meeting.update')}}" method="POST">
                    @csrf
                    <h6>Start time</h6>
                    <!-- <input type="text" id="time-format" name="time2" class="form-control" /> -->
                    <input type="text" id="p_time" name="time" hidden class="form-control" />

                    <div class="input-group">
                        <input type="text" id="time-format2" required name="time2" class="form-control" placeholder="dd/mm/yyyy - hh:ii aa" aria-describedby="basic-addon5" />
                        <div class="input-group-append">
                            <span class="input-group-text" id="basic-addon5"><i class="feather icon-calendar"></i></span>
                        </div>
                    </div>
                    <input type="hidden" id="p_id" name="phone" />


                    <br>
                    <h6 id="p_phonehad">{{__('Phone')}}</h6>
                    <p id="p_phone"></p>
                    <br>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Save Changes</button>

                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

            </div>
            </form>
        </div>
    </div>
</div>



<!-- End Contentbar -->
@endsection
@section('script')



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
    var items = document.getElementsByClassName("vari");
    var items2 = document.getElementsByClassName("vari3");
    console.log(items[19 ].innerHTML);

    $('#search').on('keyup', function() {
        var value = $(this).val();
        for (i = 0; i < items.length; i++) {
            if (items[i].innerHTML.toLowerCase().includes(value.toLowerCase())) {
                
                items2[i].style.display = "";
            } else {
                
                items2[i].style.display = "none";
            }
        }
        
    }   
    );
    
    $(document).ready(function() {
        $('#testtable').DataTable();
    });

    function changecolor() {
        var x = document.getElementById("testselect");

        if (x.value == "Success") {
            x.style.backgroundColor = "green";
        } else if (x.value == "Fail") {
            x.style.backgroundColor = "red";
        } else if (x.value == "On Hold") {
            x.style.backgroundColor = "orange";
        }
    }

    function updateinput() {
        var pat = ($('#pat').val());
        if (pat == null) {
            var pat = ($('#pat2').val());
        }
        $.ajax({
            type: "POST",
            url: "{{ route('get_patient2') }}",
            data: {
                '_token': $('input[name=_token]').val(),
                'pat': pat
            },

        }).done(function(data) {


            phone = ""
            code = ""
            for ($i = 0; $i < data.phone.length; $i++) {
                if ($i < 2) {
                    code += data.phone[$i];


                } else {
                    phone += data.phone[$i];

                }
            }

            $('#code').val(code);
            console.log($('#code').val() == code);
            $('#phone').val(phone);

            $('#code2').val(code);
            console.log($('#code').val() == code);
            $('#phone2').val(phone);

            console.log(data.id);
            $('#zoomid').val(data.id);

        });

    }
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

    function submit_rec() {

        document.getElementById("generate").value = 0;
        document.getElementById("patient_form").submit();

    }
   </script>




@endsection