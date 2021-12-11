<div class="table-responsive">
                    <table id="default-datatable" class="display table table-striped table-bordered">
                        <thead>
                            <tr>

                                <th>{{__('Name')}}</th>
                                <th>{{__('Test Date')}}</th>
                                <th>{{__('Result')}}</th>
                                <th>{{__('Generate CSV')}}</th>
                                <th>{{__('CSV Generated')}}</th>
                                <th>{{__('Performed By')}}</th>
                                <th>{{__('Tests')}}</th>
                                <th></th>
                                <th> </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($patient as $patient)
                            <tr>
                                <form method="POST" id="patient_form" action="{{ route('generateCSV') }}">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$patient->id}}">
                                    <input type="hidden" name="generate" id="generate">

                                    <td>{{$patient->first_name}} {{$patient->last_name}}</td>
                                    <td>{{$patient->date_of_birth}}</td>
                                    <!-- <td><button type="button" class="btn btn-danger px-5" disabled><i class="feather icon-x mr-2"></i>Fail</button></td> -->

                                    <td>
                                        @if(__($patient->result) == __('On Hold'))
                                        <select class="select2-single form-control" style="background-color: #F9A800;" id="testselect" name="test_status" required>
                                            @elseif(__($patient->result) == __('Success'))
                                            <select class="select2-single form-control" style="background-color: #54BC5E;" id="testselect" name="test_status" required>
                                                @elseif(__($patient->result) == __('Fail'))
                                                <select class="select2-single form-control" style="background-color: #F13C40;" id="testselect" name="test_status" required>
                                                    @else
                                                    <select class="select2-single form-control" id="testselect" name="test_status" required>
                                                        @endif

                                                        <option value="{{$patient->result}}" selected hidden> {{__($patient->result)}}</option>

                                                        <option value="On Hold" class="btn-warning"><span class="btn-primary">{{__('On Hold')}}</span></option>
                                                        <option value="Fail" class="btn-danger"><span class="btn-danger">{{__('Fail')}}</span></option>
                                                        <option value="Success" class="btn-success"><span class="btn-success">{{__('Success')}}</span></option>

                                                    </select>
                                    </td>
                                    <input type="hidden" name="imgfrontin" value="{{env('APP_URL').$patient->ID_back}}">

                                    <td>
                                        @if($patient->result == "Success")
                                        <button type="submit" class="btn btn-secondary-rgba"><i class="feather icon-file-text mr-2"></i>{{__('Generate CSV')}}</button>
                                        @endif
                                    </td>

                                    
                                    <td>{{$patient->csv_date}}</td>
                                    <td>{{$patient->performed_by}}</td>
                                    <td>
                                        <!-- <a href="{{env('APP_URL').$patient->test}}" target="_blank"><img src="{{env('APP_URL').$patient->test}}" alt="" style="max-width: 50px; max-height:50px"></a> -->
                                        <button type="button" value="{{env('APP_URL').$patient->ID_back}},{{env('APP_URL').$patient->ID_front}},{{env('APP_URL').$patient->test}}" id="modalbutton" class="btn btn-rounded btn-primary-rgba"><i class="feather icon-image"></i></button>
                                    </td>
                                    <td class="text-dark">
                                        <button type="submit" name="submit" value="Save" class="btn btn-outline-success"><i class="feather icon-check"></i></button>
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
                        <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Position</th>
                                <th>Office</th>
                                <th>Age</th>
                                <th>Start date</th>
                                <th>Salary</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
