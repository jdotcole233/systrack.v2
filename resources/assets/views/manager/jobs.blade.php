@extends('partner.manager.manager-template')
@section('manager')
<div class="container">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="page-title-box">
                                    <h4 class="page-title">Jobs</h4>
                                    <ol class="breadcrumb p-0 m-0">

                                        <li>
                                            <a href="#">Firmus Advisory</a>
                                        </li>
                                        <li>
                                            <a href="#">Jobs</a>
                                        </li>

                                    </ol>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->

                        <div class="row" style="margin-bottom: 20px;">
                            <div class="col-md-12">


                                <button class="btn-rounded btn-inverse waves-effect waves-light m-b-5 pull-right" data-toggle="modal" id="add_job_gen" data-target="#con-close-modal" > <i class="fa fa-plus-circle m-r-5"></i> <span>Add Job Request</span> </button>


                            </div>




                            <style type="text/css">
                                table tr:hover{
                                    cursor: pointer;
                                }
                            </style>

                                      <!-- Start of Add New Job -->

                         <div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    <h4 class="modal-title">New Job Form</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="job_request_form" method="post" action="">
                                                        {{csrf_field()}}
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="field-1" class="control-label">Reference No</label>
                                                                    <input readonly name="reference_number" type="text" class="form-control" id="reference_number" placeholder="FRMJOB-001239" >
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4" style="display: none">
                                                                <div class="form-group">
                                                                    <label for="field-1" class="control-label">Reference No</label>
                                                                    <input readonly name="job_request_id" type="hidden" class="form-control" id="job_request_id" >
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4" style="display: none">
                                                                <div class="form-group">
                                                                    <input name="status" type="hidden" class="form-control" id="field-1" value="PENDING" >
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <div class="form-group">
                                                                    <label for="jobsMenu" class="control-label">Job Title</label>
                                                                    {{----}}
                                                                    <select name="job_id" class="form-control" id="jobsMenu" onchange="displayAdditonalInfo('detail', this, 'job_id')">
                                                                        <option id="0" value=""> -- Select Job -- </option>
                                                                        @foreach($jobs as $job)
                                                                            <option id="{{$job}}" value="{{$job->job_id}}">{{$job->job_name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="field-2" class="control-label">Cost</label>
                                                                    <input name="job_cost" type="text" class="form-control" id="field-1" placeholder="Cost">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="field-2" class="control-label">Job Priority</label>
                                                                    <select  name="job_priority" class="form-control" id="jobsMenu">
                                                                        <option value="MEDIUM">Medium</option>
                                                                        <option value="VERY HIGH">Very High</option>
                                                                        <option value="HIGH">High</option>
                                                                        <option value="LOW">Low</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-12" style="display: none">
                                                                <div class="form-group">
                                                                    <label for="detail" class="control-label">Details</label>
                                                                    <input type="text" class="form-control" placeholder="" id="detail" name="details">
                                                                </div>
                                                            </div>

                                                            <div id="details">

                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="field-2" class="control-label">Client</label>
                                                                    <select name="client_id" class="form-control" id="client_detail">
                                                                        <option value="">Select Client</option>
                                                                        @foreach($clients as $client)
                                                                            <option value="{{$client->client_id}}" >{{$client->company_name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">

                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default waves-effect close_clear" data-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-info waves-effect waves-light" id="submit_job_request">Save</button>
                                                    <button type="button" class="btn btn-info waves-effect waves-light" id="edit_job_request" style="display: none">Edit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.modal -->


                        <!-- End of New Job form -->

                            <!-- Job Details -->
                            <div id="custom-width-modal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
                                        <div class="col-md-8 col-md-offset-2">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close close_clear" data-dismiss="modal" aria-hidden="true">×</button>
                                                    <h4 class="modal-title">About Job</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">

                                                        <div class="col-md-12">



                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="field-1" class="control-label">Reference No</label>
                                                                <input name="reference_number2" type="text" class="form-control" id="reference_num" placeholder="FRMJOB-001239" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4" >
                                                            <div class="form-group">
                                                                <label for="field-2" class="control-label">Job Title</label>
                                                                <input name="job_id2" type="text" class="form-control" id="field-2" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4" style="display: none;">
                                                            <div class="form-group">
                                                                <label for="field-2" class="control-label">Job Title</label>
                                                                <input  type="hidden" class="form-control" id="field-6" name="job_request_id2" >
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="field-2" class="control-label">Client</label>
                                                                <input name="client_id2" type="text" class="form-control" id="field-3" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="field-2" class="control-label">Start Date</label>
                                                                <input type="text" class="form-control" value="" id="field-4" disabled>
                                                            </div>
                                                        </div>
                                                        {{--<div class="col-md-6">--}}
                                                            {{--<div class="form-group">--}}
                                                                {{--<label for="field-2" class="control-label">Expected End Date</label>--}}
                                                                {{--<input type="text" class="form-control" value="" id="field-5" disabled>--}}
                                                            {{--</div>--}}
                                                        {{--</div>--}}

                                                                <div class="col-md-12">
                                                                    <hr>
                                                                </div>

                                                        <div class="col-md-12">
                                                            <form id="job_make_assign_form"  style="display: none">
                                                                {{csrf_field()}}
                                                                <div class="col-md-4" style="display: none">
                                                                    <div class="form-group">
                                                                        <input name="job_req_id" id="job_request_id_detail" type="hidden" class="form-control" value="" >
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4" style="display: none">
                                                                    <div class="form-group">
                                                                        <input name="jsonData" id="jsonData" type="hidden" class="form-control" value="" >
                                                                        <input type="hidden" name="removed_employees" id="removed_employees">
                                                                    </div>
                                                                </div>
                                                            </form>
                                                            <div class="col-md-12">
                                                                <h4>Assigned Employee(s)</h4>
                                                                <table class="table table-responsive table-striped" id="employeeList">

                                                                </table>
                                                            </div>
                                                            <div class="col-md-12">
                                                            <div class="form-group">
                                                                <div class="col-md-12">

                                                                <label for="field-2" class="control-label">Assign Task to:</label>
                                                                </div>
                                                                <div class="col-md-10">
                                                                <select id="assignedEmployee"  class="form-control" required>
                                                                    <option value="">-- Select Employee --</option>
                                                                    @foreach($employees as $employee)
                                                                        <option id="{{$employee->emp_id}}" value="{{$employee->first_name}} {{$employee->last_name}}">{{$employee->first_name}}   {{$employee->last_name}}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div id="removed_important" style="display: none;">

                                                                </div>
                                                            </div>

                                                            <div class="col-md-2">
                                                                <button type="button" onClick="addEmployee()" class="btn btn-info waves-effect waves-light" style="border-radius: 5px;">Add</button>
                                                            </div>

                <script type="text/javascript">
                    var count = 1;


                    function addEmployee(){

                        var bool = false;

                        var employee = document.getElementById('assignedEmployee').value;
                        var employeeDropDown = document.getElementById('assignedEmployee');
                        var table = document.getElementById('employeeList');

                        employeeID = employeeDropDown.options[employeeDropDown.selectedIndex].id;
                        var em_id = "sime" + employeeID;
                        $('#employeeList tr').each(function (i, v) {
                            if($(this).attr('id') === em_id) {
                                bool = true;
                            }
                        });
                        if (!bool) {
                            var row = table.insertRow(0);
                            row.setAttribute("id", em_id);
                            row.setAttribute("class", "");
                            var cell1 = row.insertCell(0);
                            var cell2 = row.insertCell(1);
                            cell1.innerHTML = employee;
                            cell2.innerHTML = "<button type='button' id='" + employeeID + "' style=\"padding:0; width:28px; height:28px;\" class='emp_remove btn-rounded btn-danger pull-right ' onclick='emp_remove(this.id)'><i class='fa fa-minus-circle'></i> Remove</button>";
                        }

                    }
                </script>



                                                <div class="col-md-12" style="height: 10px;">
                                                </div>
                                                <div class="col-md-12">
                                                    <button type="button" id="assignJobRequestSend" class="btn-rounded btn-danger waves-effect waves-danger " data-dismiss="modal" aria-hidden="true" >Make assignment</button>
                                                </div>
                                                <div class="col-md-12" style="height: 10px;">
                                                </div>

                                                </div>
                                                </div>
                                                </div>
                                                </div>


                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="close_clear btn btn-default waves-effect" data-dismiss="modal">Close</button>

                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.modal -->
                                    </div>

                                    <!-- End of Job Details -->


                                    <!-- Job Details -->
                            <div id="view-custom-width-modal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
                                        <div class="col-md-8 col-md-offset-2">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close close_clear" data-dismiss="modal" aria-hidden="true">×</button>
                                                    <h4 class="modal-title">About Job</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">

                                                        <div class="col-md-12">
                                                            <div id="job_details_info">

                                                            </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group no-margin">
                                                                 {{csrf_field()}}
                                                                <label for="field-7" class="control-label">Update Progress</label>
                                                                <textarea class="form-control autogrow" id="message" placeholder="Write remark or feedback here" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 104px;"></textarea>
                                                                <button type="button" class="btn btn-info waves-effect waves-light" id="post_message" style="margin-top: 5px;">Post</button>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default waves-effect close_clear" data-dismiss="modal">Close</button>

                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.modal -->
                                    </div>

                                    <!-- End of Job Details -->




                        </div>





                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-sm-12">
                                <div class="card-box table-responsive">
                                    <h4 class="m-t-0 header-title"><b>All Jobs</b></h4>
                                    <p class="text-muted font-13 m-b-30">

                                    </p>
                                    <table id="datatable-buttons" class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Reference No</th>
                                            <th>Job Title</th>
                                            <th>Client</th>
                                            <th>Created By</th>
                                            <th>Assigned Employee</th>
                                            <th>Status</th>
                                            <th>Start date</th>
                                            <th>View</th>
                                            <th>Edit</th>
                                            <th>Assign</th>
                                            <th>Cancel</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        @foreach($job_requests as $job_request)
                                        <?php
                                            $employees = App\Models\Job_Assignment::where('job_request_id', $job_request->job_request_id)->get();
                                        ?>
                                        <tr id="Job{{$job_request->job_request_id}}">
                                            <td>{{$job_request->reference_number}}</td>
                                            <script type="text/javascript" > var data = {{ DB::table('jobs')->select('*')->where('job_id', $job_request->job_id)->where('delete_status', 'NOT DELETED')->get()}} </script>

                                            <td id="job_id_get">{{ DB::table('jobs')->select('job_name')->where('job_id', $job_request->job_id)->where('delete_status', 'NOT DELETED')->value('job_name')}}</td>



                                            <td>{{ DB::table('clients')->select('company_name')->where('client_id', $job_request->client_id)->where('delete_status', 'NOT DELETED')->value('company_name')}}</td>
                                            <td>{{DB::table('employees')->where('emp_id', $job_request->created_by)->value('first_name')}} {{DB::table('employees')->where('emp_id', $job_request->created_by)->value('last_name')}}</td>
                                            <td>
                                                @foreach($employees as $employee)
                                                    {{DB::table('employees')->where('emp_id', $employee->emp_id)->value('first_name')}} {{DB::table('employees')->where('emp_id', $employee->emp_id)->value('last_name')}},
                                                @endforeach
                                            </td>
                                            <td class="status" >{{$job_request->status}}</td>
                                            <td>{{$job_request->created_at}}</td>
                                            <td><button data-toggle="modal" data-target="#view-custom-width-modal" type="button" id="view_job_details" class=" viewJob btn btn-success waves-effect waves-danger " value="{{$job_request->job_request_id}}" >View Job</button></td>
                                            <td><button type="button" class="btn btn-warning waves-effect waves-warning edit_job_request" data-toggle="modal" data-target="#con-close-modal" onclick="document.getElementById('submit_job_request').style.display = 'none'; document.getElementById('edit_job_request').style.display = 'block'; edit('job_request_form',{{json_encode($job_request)}}, '{{route('editJobRequest')}}');" >Edit</button></td>
                                            @if($job_request->status != 'PENDING')
                                            <td><button data-toggle="modal" data-target="#custom-width-modal" type="button" id="assignJobRequest" class="assignJobRequest btn btn-primary waves-effect waves-danger " value="{{$job_request->job_request_id}}" >Assign Job</button></td>
                                            @else
                                                <td><button  class="btn btn-primary waves-effect waves-danger" disabled>Assign Job</button></td>
                                            @endif


                                            <td><button  type="button" id="deleteJobRequest" class="deleteJobRequest btn btn-danger waves-effect waves-danger " value="{{$job_request}}" >Delete</button></td>


                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            </div>

                        </div>
                        <!-- end row -->




                    </div> <!-- container -->





<div id="loading_progress" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none; margin-top: 40px;">
        <div class="modal-dialog">
            <center>
                <img src="{{asset('images/loader.gif')}}" alt="please wait">
            </center>
        </div>

    </div><!-- /.modal -->
@endsection
