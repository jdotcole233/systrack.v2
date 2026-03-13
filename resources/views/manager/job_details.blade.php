<?php
 $job_id = DB::table('firmus_jobs')->join('job__requests','firmus_jobs.job_id','=','job__requests.job_id')->where('job_request_id',$job->job_request_id)->where('firmus_jobs.delete_status', 'NOT DELETED')->value('firmus_jobs.job_id');
$s = DB::table('job__task__completions')->where('job_request_id',$job->job_request_id)->where('delete_status', 'NOT DELETED')->orderBy('created_at','desc')->first();
//dd($s);
    if($s != null) {
        $task = DB::table('tasks')->where('task_id', $s->task_id + 1)->first();
    }
?>
@if($s != null)
<input id="tasks_details" type="hidden" style="display: none" value="{{DB::table('tasks')->where('job_id', $job_id)->where('delete_status', 'NOT DELETED')->get()}}">
<input type="hidden" name="" id="current_task_form" value="{{$task->task_name}}">
<div class="row">
    <center><label  id="display_task" class="form-control">{{$task->task_name}}</label></center>
</div>
@endif
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div style="height: 50px">
                <div class="containerr" style="margin: 0;">
                    <ul id="stages" class="progressbar">
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

    </div>
</div>


<div class="col-md-4">
    <div class="form-group">
        <label for="field-1" class="control-label">Reference No</label>
        <input name="reference_number2" value="{{$job->reference_number}}" type="text" class="form-control" id="field-1" placeholder="FRMJOB-001239" readonly>
        <input value="{{$job->job_request_id}}" type="hidden" class="form-control" id="job_request_id_details" placeholder="FRMJOB-001239" readonly>
    </div>
</div>
<div class="col-md-4">
    <div class="form-group">
        <label for="field-2" class="control-label">Job Title</label>
        <input name="job_id2" type="text" value="{{ DB::table('jobs')->select('job_name')->where('job_id', $job->job_id)->where('delete_status', 'NOT DELETED')->first()->job_name}}" class="form-control" id="field-2" readonly>
    </div>
</div>
<div class="col-md-4">
    <div class="form-group">
        <label for="field-2" class="control-label">Client</label>
        <input name="client_id2" value="{{ DB::table('clients')->select('company_name')->where('client_id', $job->client_id)->where('delete_status', 'NOT DELETED')->first()->company_name}}" type="text" class="form-control" id="field-3" readonly>
    </div>
</div>
<div class="col-md-6">
    <div class="form-group">
        <label for="field-2" class="control-label">Start Date</label>
        <input type="text" value="{{$job->created_at}}" class="form-control" value="" id="field-4" readonly>
    </div>
</div>
{{--<div class="col-md-6">--}}
    {{--<div class="form-group">--}}
        {{--<label for="field-2" class="control-label">Expected End Date</label>--}}
        {{--<input type="text" class="form-control" value="" id="field-5" readonly>--}}
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
            </div>
        </div>
    </form>
    <div class="col-md-12">
        <h4>Assigned Employee(s)</h4>
        <table class="table table-responsive table-striped" id="employeeList">
            @foreach($employees as $employee)
                <tr>
                    <td>{{DB::table('employees')->where('emp_id', $employee->emp_id)->value('first_name')}} {{DB::table('employees')->where('emp_id', $employee->emp_id)->value('last_name')}}</td>
                    <td> </td>
                </tr>
            @endforeach
        </table>
    </div>
</div>


<div class="row">
    <div class="col-md-12" >
        <div class="form-group no-margin">
            <label for="field-7" class="control-label"><h4>Feedback</h4></label>
            {{--<div class="alert alert-info" role="alert">--}}
                {{--<strong>Please</strong>, can you forward me the documents to my personal mail. Thank you.--}}
                {{--<div class="pull-right">20 mins ago</div>--}}
            {{--</div>--}}
            {{--<div class="alert alert-warning" role="alert">--}}
                {{--Just sent it to you mail, sir.--}}
                {{--<div class="pull-right">5 mins ago</div>--}}
            {{--</div>--}}
            {{--<div class="alert alert-info" role="alert">--}}
                {{--Yeah, thanks... Received.--}}
                {{--<div class="pull-right">2 mins ago</div>--}}
            {{--</div>--}}
            <div id="message_stuff" style="height: 250px; min-height: 332px; overflow: hidden; width: auto; background-color: #f7f7f7; padding-top: 20px; overflow-y: scroll">
            <ul id="chat_messages" class="conversation-list slimscroll-alt" >
            </ul>
            </div>

        </div>
    </div>

