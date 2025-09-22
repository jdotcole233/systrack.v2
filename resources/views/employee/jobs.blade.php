@extends('employee.my-jobs-template')
@section('employee')
    <style type="text/css">
        table tr:hover{
            cursor: pointer;
        }


    </style>



    <script>

    </script>




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
                <!-- end row -->

                {{--<div class="row" style="margin-bottom: 20px;">--}}

                {{--<div class="col-md-12">--}}
                {{--<div class="row" style="padding: 20px;">--}}
                {{--<label class="control-label">Progress</label>--}}
                {{--<div class="row" style="padding: 20px;">--}}

                {{--<div class="range">--}}
                {{--<input type="range" min="1" max="7" steps="1" value="1" style="width: 100%">--}}
                {{--</div>--}}

                {{--<ul class="range-labels">--}}
                {{--<li class="active selected">Stage1</li>--}}
                {{--<li>Stage2</li>--}}
                {{--<li>Stage3</li>--}}
                {{--<li>Stage4</li>--}}
                {{--<li>Stage5</li>--}}
                {{--<li>Stage6</li>--}}
                {{--<li>Stage7</li>--}}
                {{--</ul>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}



                {{--</div>--}}





                <div class="row">
                    <div class="col-md-12">
                        <div class="col-sm-12">
                            <div class="card-box table-responsive">
                                <h4 class="m-t-0 header-title"><b>My Jobs</b></h4>
                                <p class="text-muted font-13 m-b-30">

                                </p>

                                <table id="datatable-buttons" class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Reference No</th>
                                        <th>Job Title</th>
                                        <th>Client</th>
                                        <th>Assigned By</th>
                                        <th>Applicant</th>
                                        <th>Current Task</th>
                                        <th>Assigned On</th>
                                        <th>End date</th>
                                        <th>Renewal date</th>
                                        <th>Progress</th>
                                    </tr>
                                    </thead>


                                    <tbody>

                                    @foreach($my_jobs as $my_job)
                                        <tr id="tab{{$my_job->job_assignment_id}}">
                                            <?php $job_id = DB::table('jobs')->join('job__requests','jobs.job_id','=','job__requests.job_id')->where('job_request_id',$my_job->job_request_id)->where('jobs.delete_status', 'NOT DELETED')->value('jobs.job_id');
                                            $s = DB::table('job__task__completions')->where('job_request_id',$my_job->job_request_id)->where('delete_status', 'NOT DELETED')->where('status', 'completed')->orderBy('created_at','desc')->first();
                                            $last = null;
                                            $now_last = null;
                                            ?>
                                            <td style="display: none;" id="job_request_id_de">{{$my_job->job_request_id}}</td>
                                            <td id="tasks{{$my_job->job_request_id}}" style="display: none" >{{DB::table('tasks')->where('job_id', $job_id)->where('delete_status', 'NOT DELETED')->get()}}</td>
                                            <td id="reference_number">{{DB::table('job__requests')->where('job_request_id', $my_job->job_request_id)->where('delete_status', 'NOT DELETED')->value('reference_number')}}</td>
                                            <td id="job_name">{{DB::table('jobs')->join('job__requests','jobs.job_id','=','job__requests.job_id')->where('job_request_id',$my_job->job_request_id)->where('jobs.delete_status', 'NOT DELETED')->value('job_name')}}</td>
                                                <input id="job_request_contact_information" value="{{DB::table('job__requests')->select('details')->where('client_id',DB::table('clients')->join('job__requests','clients.client_id','=','job__requests.client_id')->where('job_request_id',$my_job->job_request_id)->where('clients.delete_status', 'NOT DELETED')->value('job__requests.client_id'))->get()}}" type="hidden" style="display: none" >

                                                <td id="company_name">{{DB::table('clients')->join('job__requests','clients.client_id','=','job__requests.client_id')->where('job_request_id',$my_job->job_request_id)->where('clients.delete_status', 'NOT DELETED')->value('company_name')}}</td>
                                            {{--<td id="company_email" style="display: none;">{{DB::table('clients')->join('job__requests','clients.client_id','=','job__requests.client_id')->where('job_request_id',$my_job->job_request_id)->where('clients.delete_status', 'NOT DELETED')->value('email')}}</td>--}}
                                            <td id="company_email{{$my_job->job_request_id}}" style="display: none;">{{DB::table('clients')->join('job__requests','clients.client_id','=','job__requests.client_id')->where('job_request_id',$my_job->job_request_id)->where('clients.delete_status', 'NOT DELETED')->value('email')}}</td>
                                            <td>{{DB::table('employees')->where('emp_id', $my_job->assigned_by)->value('first_name')}} {{DB::table('employees')->where('emp_id', $my_job->assigned_by)->value('last_name')}}</td>
                                            <!-- <td id="assignment_status">{{$my_job->assignment_status}}</td> This use to be at Applicant column-->

                                            <td id="assignment_status">{{ json_decode(DB::table('job__requests')->where('job_request_id', $my_job->job_request_id)->where('delete_status', 'NOT DELETED')->value('details'))->{"COMPANY NAME"} }}</td> <!-- This was changed to add the applicant name instead of job status -->
                                            @if($s != null)
                                                <?php
                                                $task = DB::table('tasks')->where('task_id', $s->task_id + 1)->first();
                                                $last = DB::table('tasks')->where('task_id', $s->task_id + 1)->where('job_id',$job_id)->first();
                                                $now_last = DB::table('tasks')->where('task_id', $s->task_id + 2)->where('job_id',$job_id)->first();
                                                $status = DB::table('job__task__completions')->select('status')->where('job_request_id',$my_job->job_request_id)->where('task_id', $s->task_id + 1)->orderBy('created_at','desc')->value('status');
                                                //                                            dd($job_id);
                                                ?>
                                                @if($last != null)
                                                    <td id="current_task_id{{$my_job->job_request_id}}" style="display: none" >{{$task->task_id}}</td>
                                                    <td id="current_task{{$my_job->job_request_id}}" >{{$task->task_name}}</td>
                                                    <td id="status" style="display: none;" >{{$status}}</td>
                                                @else
                                                    <td id="current_task_id{{$my_job->job_request_id}}" style="display: none" >0</td>
                                                    <td id="current_task{{$my_job->job_request_id}}" >Done</td>
                                                    <td id="status" style="display: none;" >{{$status}}</td>
                                                @endif
                                            @else
                                                <td id="current_task_id{{$my_job->job_request_id}}" style="display: none"  ></td>
                                                <td id="current_task{{$my_job->job_request_id}}"><script>
                                                        var stuff = JSON.parse(document.getElementById("tasks{{$my_job->job_request_id}}").textContent)[0];
                                                        document.getElementById("current_task{{$my_job->job_request_id}}").innerHTML = stuff.task_name;
                                                        document.getElementById("current_task_id{{$my_job->job_request_id}}").innerHTML = stuff.task_id;
                                                    </script></td>
                                            @endif
                                            <td id="job_request_id_id{{$my_job->job_request_id}}" style="display: none" >{{$my_job->job_request_id}}</td>
                                            <td id="created_at">{{$my_job->created_at}}</td>
                                            <td id="end_date">{{DB::table('job__completions')->where('job_request_id',  $my_job->job_request_id)->value('end_date')}}</td>
                                            <td id="job_request{{$my_job->job_request_id}}" style="display: none">{{DB::table('employees')->join('job__assignments','employees.emp_id','=','job__assignments.emp_id')->where('job_request_id', $my_job->job_request_id)->where('employees.delete_status', 'NOT DELETED')->get()}}</td>
                                            <td id="renewal_date">{{DB::table('job__requests')->where('job_request_id', $my_job->job_request_id)->where('delete_status', 'NOT DELETED')->value('renewal_date')}}</td>
                                            <td>
                                                @if($now_last == null && $last != null)
                                                    <button id="progress_btn" class="btn btn-primary progress_button" data-toggle="modal" data-target="#custom-width-modal2" onclick="progress_view({{$my_job->job_request_id}}); document.getElementById('renewal1').style.display = 'block';" > Progress Update</button>
                                                @elseif($last != null)
                                                    <button id="progress_btn" class="btn btn-primary progress_button" data-toggle="modal" data-target="#custom-width-modal2" onclick="progress_view({{$my_job->job_request_id}});" > Progress Update</button>
                                                @else<button id="progress_btn" class="btn btn-primary progress_button" data-toggle="modal" data-target="#custom-width-modal2" disabled> Progress Update</button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>


                                <!-- View Job Details -->
                                <div id="custom-width-modal2" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: hidden;">

                                    <div class="col-md-8 col-md-offset-2">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close close_clear" data-dismiss="modal" aria-hidden="true" >×</button>
                                                <h4 class="modal-title">About Job</h4>
                                            </div>
                                            <div class="modal-body">
                                                <input id="tasks_details" type="hidden" style="display: none">
                                                <div class="row">
                                                    <center><label  id="display_task" class="form-control">Label to display on hover</label></center>
                                                </div>
                                                <div class="row">
                                                    <div style="width: 500px"></div>
                                                    <div class="container" style="margin: 0; display: flex; justify-content: center; align-items: center; padding-top: 5px;">
                                                        <ul id="stages" class="progressbar">
                                                        </ul>
                                                    </div>
                                                </div>


                                                <div class="row" style="margin-top: 150px;">

                                                    <div class="col-md-12">
                                                        <form id="job_assignment_form" >
                                                            <div class="col-md-12">
                                                                {{--</div>--}}
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="field-1" class="control-label">Reference No</label>
                                                                        <input name="reference_number" type="text" class="form-control" id="field-1" readonly>
                                                                        <input value="" type="hidden" name="job_request_id_de" id="job_request_id_details" class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="field-2" class="control-label">Job Title</label>
                                                                        <input name="job_name" type="text" class="form-control" id="field-2" readonly>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="field-2" class="control-label">Client</label>
                                                                        <input name="company_name" type="text" class="form-control" id="field-3" readonly>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="field-2" class="control-label">Status</label>
                                                                        <input name="assignment_status" type="text" class="form-control" id="field-3" readonly>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="field-2" class="control-label">Assigned On</label>
                                                                        <input name="created_at" type="text" class="form-control" value="" id="field-4" readonly>
                                                                    </div>

                                                                </div>
                                                                <div class="col-md-4" style="display: none" id="renewal1">
                                                                    <div class="form-group">
                                                                        <label for="field-2" class="control-label">Renewal Date</label>
                                                                        <input name="renewal_date_proxy" id="renewal_date_proxy" type="date" class="form-control" value="">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <hr>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="col-md-12">
                                                        <h4>Assigned Employee(s)</h4>
                                                        <input id="job_request_id" value="" type="hidden" style="display: none" >
                                                        <table id="assigned_employees" class="table table-striped">
                                                        </table>
                                                    </div>

                                                </div>


                                        </form>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="col-md-12">
                                            <h4>Update Progress</h4>
                                            <div class="col-md-12">
                                                <hr>
                                            </div>

                                            <div class="col-md-4">
                                                <form id="job_task_completion_send">
                                                    <meta name="csrf-token" content="{{csrf_token()}}">
                                                    <div class="form-group">
                                                        <label for="field-2" class="control-label">Current Task</label>
                                                        <input name="task_id"  type="hidden" id="current_task_id"  class="form-control" value="" >
                                                        <input name="job_assignment_id"  type="hidden" id="task_job_assignment_id"  class="form-control" value="">
                                                        <input type="text" id="current_task_form"  class="form-control" value="" >
                                                        <input name="job_request_id" type="hidden" id="current_task_form_job_request_id"  class="form-control" value="" >
                                                        <input type="hidden" id="company_email"  class="form-control" value="" >
                                                        <input type="hidden" id="client_remark"  class="form-control" value="" >
                                                        <input type="hidden" id="renewal_date_o" name="renewal_date"  class="form-control" value="" >

                                                    </div>
                                                    <div class="form-group">
                                                        <label for="field-2" class="control-label">Current Status</label>
                                                        <select required name="status" class="form-control" value="" id="field-5">
                                                            <option value="" >-- Select current status --</option>
                                                            <option value="in progress" >In Progress</option>
                                                            <option value="delayed" >Delayed</option>
                                                            <option value="cancelled" >Cancelled</option>
                                                            <option value="completed" >Completed</option>
                                                        </select>
                                                    </div>

                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="field-2" class="control-label">Status Remark</label>
                                                    <textarea required name="comments" class="form-control" value="" id="client_remarks" rows="5" ></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input class="form-control" list="clientsEmail" type="text" name="alt_email"  id="alt_email" placeholder="Enter alternative email (E.g. abcd@firmus.com)">
                                                    <datalist style="display:none" class="form-control" id="clientsEmail" >

                                                    </datalist>
                                                </div>
                                            </div>
                                            </form>

                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <button id="sendTasksUpdate" class="btn btn-danger">Send</button>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <hr>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="row">
                                        <div class="col-md-12">

                                            <div class="form-group no-margin">
                                                <label for="field-7" class="control-label"><h4>Feedback</h4></label>
                                                <div id="message_stuff" style="height: 250px; min-height: 332px; overflow: auto; width: auto; background-color: #f7f7f7; padding-top: 20px; overflow-y: scroll;">
                                                    <ul id="chat_messages" class="conversation-list" >
                                                    </ul>
                                                </div>
                                            </div>
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

                <!-- End of View Job Details -->
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
