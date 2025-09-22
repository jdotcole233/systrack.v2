@extends('partner.admin.admin-template')
@section('admin')
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="page-title-box">
                <h4 class="page-title">Jobs Types</h4>
                <ol class="breadcrumb p-0 m-0">
                    <li>
                        <a href="#">Firmus Advisory</a>
                    </li>
                    <li>
                        <a href="#">Jobs Types</a>
                    </li>
                </ol>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <!-- end row -->

     <div class="row" style="margin-bottom: 20px;">
        <div class="col-md-12" >
            <button onclick="" class="btn-rounded btn-inverse waves-effect waves-light m-b-5 pull-right" data-toggle="modal" data-target="#con-close-modal" id="addNewJob_to" > <i class="fa fa-plus-circle m-r-5"></i> <span>New Job</span> </button>
        </div>
    </div>

                                    <!-- Start of Add New Job -->

    <div id="con-close-modal" class="showmesomething modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">New Job Form</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form id="job">
                            <meta name="csrf-token" content="{{csrf_token()}}">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="field-2" class="control-label">Job Name</label>
                                    <input type="text" name="job_name" class="form-control" placeholder="Job Name" id="field-2">
                                </div>
                            </div>
                            <div class="col-md-12" style="display: none" >
                                <div class="form-group">
                                    <label for="field-2" class="control-label">Job Id</label>
                                    <input id="job_id" type="text" name="job_id" class="form-control" placeholder="Job Id" id="field-2">
                                </div>
                            </div>
                            <div class="col-md-12" style="display: none">
                                <div class="form-group">
                                    <label for="detail" class="control-label">Details</label>
                                    <input type="text" class="form-control" placeholder="" id="detail" name="details">
                                </div>
                            </div>
                        </form>
                        <div class="col-md-12">
                            <div class="form-group">
                                <script type="text/javascript"> j = 0; k = 0 </script>
                                <button type="button" class="btn btn-info waves-effect waves-light" id="add" onclick="var detail = 'Detail ' + (++j); add('details', detail, '')">Add Details</button>
                                <button type="button" class="btn btn-info waves-effect waves-light" id="remove" onclick="--j; remove('details')" >Remove</button>
                            </div>
                            <div id="details"></div>
                        </div>

                    </div>
                    {{--task--}}

                    <div class="row" id="form-task">
                            <h4 class="modal-title">Add Task</h4>
                            <div class="col-md-12">
                            <div class="form-group">
                                <button type="button" class="btn btn-info waves-effect waves-light" id="add" onclick="var tasks = 'Task Name ' + (++k); add('tasks', tasks, '')">Add Task</button>
                                <button type="button" class="btn btn-info waves-effect waves-light" id="remove" onclick=" --k; remove('tasks')" >Remove</button>
                            </div>
                        </div>
                        <form id="task-form" method="post">
                            {{csrf_field()}}
                            <div class="col-md-12" style="display: none" >
                                <div class="form-group">
                                    <label for="field-2" class="control-label">Job Id</label>
                                    <input id="job_task_id" type="text" name="job_id" class="form-control" placeholder="Job Task ID" id="field-2">
                                </div>
                            </div>
                            <div id="tasks"></div>
                            <div id="removed_tasks"></div>
                            <div class="col-md-12" style="display: none">
                                <div class="form-group">
                                    <label for="detail" class="control-label">Tasks</label>
                                    <input type="text" class="form-control" placeholder="" id="task" name="tasks">
                                    <input type="text" class="form-control" placeholder="" id="removed_task" name="removed_tasks">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button style="display: none" type="button" class="btn btn-default waves-effect" id="addTask"  data-toggle="modal" data-target="#task-modal" onclick="document.getElementById('form-task').style.display = 'block'; document.getElementById('job_task_id').value = document.getElementById('job_id').value;">Tasks</button>
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal" onclick="j = 0; k = 0">Close</button>
                    <button type="button" class="btn btn-info waves-effect waves-light" onclick="j = 0; k = 0" style="display: none;" id="save">Save</button>
                    <button type="button" class="btn btn-info waves-effect waves-light" onclick="j = 0; k = 0" id="addJob" >Create Job</button>
                </div>
            </div>
        </div>
    </div><!-- /.modal -->




                        
                        

    <div class="row">
        <div class="col-md-12">
            <div class="col-sm-12">
            <div class="card-box table-responsive">
                <h4 class="m-t-0 header-title"><b>All Job Types</b></h4>
                <p class="text-muted font-13 m-b-30">
                    Create a job template
                </p>

                <table id="datatable-buttons" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Job ID</th>
                        <th>Job Name</th>
                        <th>Required Details</th>
                        <th>Date Created</th>
                        <th>Last Modified</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                    </thead>


                    <tbody id="job_request_tbody">

                    @foreach($jobs as $job)
                    <tr id="Job{{$job->job_id}}"  data-toggle="modal" data-target="#custom-width-modal">
                        <td>{{$job->job_id}}</td>
                        <td>{{$job->job_name}}</td>
                        <td>
                            @if($job->details != null)
                                @foreach(json_decode($job->details) as $item)
                                    {{$item.", "}}
                                @endforeach
                            @endif
                        </td>
                        <td>{{$job->created_at}}</td>
                        <td>{{$job->updated_at}}</td>
                        <td><button type="button" class="btn btn-warning waves-effect waves-warning" data-toggle="modal" data-target="#con-close-modal" onclick="edit('job',{{json_encode($job)}}, {{DB::table('tasks')->where('job_id', $job->job_id)->get()}}); document.getElementById('addTask').style.display = 'none'; document.getElementById('addJob').style.display = 'none'; document.getElementById('save').style.display = 'block'; j = document.getElementById('details').children.length; k = document.getElementById('tasks').children.length;" >Edit</button></td>
                        <td><button type="button" value="{{$job}}" class="deleteJob btn btn-danger waves-effect waves-danger ">Delete</button></td>

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