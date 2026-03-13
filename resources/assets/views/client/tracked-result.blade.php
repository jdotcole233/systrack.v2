@extends('header-footer.client-header-footer')
@section('content')

<style type="text/css">
	input, button not(#request){
		width: 100%;
		margin-bottom: 10px;
	}
</style>

<style type="text/css">
	.step {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    font-size: 25px;
    color: #fff;
    line-height: 50px;
    text-align: center !important;
    background: #36404e;
    transition: all 1s;
}

.step-ok {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    font-family: 'SansaPro-SemiBold';
    font-size: 25px;
    color: #fff;
    line-height: 50px;
    text-align: center !important;
    background: #39B54A;
}

.step-fll-prev {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    font-family: 'SansaPro-Bold';
    font-size: 30px !important;
    text-align: center !important;
    cursor: pointer;
}

.step-fll {
    color: #fff;
    background: #283897;
    margin-left: 3px;
    line-height: 38px;
}

.step-prev {
    color: #283897;
    background: #FFF;
    border-width: 2px;
    border-style: solid;
    border-color: #283897;
    margin-left: -5px;
    line-height: 35px;
}

.step-fll-prev i {
    font-size: 30px !important;
}

.step-text {
    /*font-family: 'SansaPro-SemiBold';*/
    font-size: 15px;
    padding-left: 46px;
    padding-top: 5px;
}

.panel-default {
    border-color: transparent;
}

.panel {
    margin-bottom: 20px;
    background-color: transparent;
    border: 0px solid transparent;
    border-radius: 4px;
    -webkit-box-shadow: 0 0px 0px rgba(0,0,0,0.05);
    box-shadow: 0 0px 0px rgba(0,0,0,0.05);
}

.panel-default>.panel-heading {
    color: #333;
    background-color: transparent;
    border-color: transparent;
}

.panel-group .panel-heading+.panel-collapse .panel-body {
    border-top: 0px solid #ddd;
}

.line-wizard {
    position: absolute;
    width: 2px;
    background-color: #CCCCCC;
    z-index: -1;
}

.l1 {
    height: 214px;
    margin-top: -44px;
    margin-left: 25px;
}

.l2 {
    height: 217px;
    margin-top: -45px;
    margin-left: 25px;
}

.l3 {
    height: 131px;
    margin-top: -199px;
    margin-left: 25px;
}

.outgoing_message{
	border:1px solid black;
	width: 500px;
	height: 250px;
	position: absolute;
	display: block;
	z-index: 1000;
	/* margin: auto; */
	margin-bottom: 0px;
}
</style>



<div class="container">

	<div class="row">

		<div class="col-md-12" style="height: 100px;"></div>
		<div class="col-md-12" style="background-color: #36404e; color: #fff; padding-top: 10px; padding-bottom: 10px;">
			<span id="job_reference">JOB # - {{$Job_Request->reference_number}}</span> <span class="pull-right" id="job_title">{{DB::table('firmus_jobs')->where('job_id', $Job_Request->job_id)->value('job_name')}}</span>
		</div>


        <div class="row" style="background-color: #f9f9f9;">
            <div class="col-md-4">
            	<center>
                <h5>Date/Time started</h5>
                {{$start_date->start_date}}<hr>
            </center>
            </div>

            <div class="col-md-4">
                <center>
                    <h5>Current Progress</h5>
                    {{$current_task->task_name}}<hr>
                </center>
            </div>

            <div class="col-md-4">
                <center>
                <h5>Assigned Employee</h5>
								<table id="table_emails">
                @foreach($employees as $employee)
                    {{DB::table('employees')->where('emp_id', $employee->emp_id)->value('first_name')}} {{DB::table('employees')->where('emp_id', $employee->emp_id)->value('last_name')}},
										<tr style="display:none;">
											<td>{{DB::table('employees')->where('emp_id', $employee->emp_id)->value('company_email')}}</td>
										</tr>
                @endforeach
								</table>
                </center>
            </div>
        </div>
        <div style="height: 20px;"></div>

		<center class="request-noti">
		<button type="button" class="btn btn-rounded btn-success waves-effect waves-light" id="request" data-toggle="modal" data-target="#myModal" style="color: #fff; padding: 12px;">Request Notification</button>
		</center>
    </div>



	<div class="row">
		<div class="col-md-12" style="height: 30px;"></div>
		<div class="col-md-12">
		<h5 style="margin-top: 10px;">JOB HISTORY<span class="pull-right" style="font-size: 14px;"><a href="#">Need help?</a></span></h5><hr>
		<p>Status update on all stages</p>

<div class="container">
    <div class="panel-group" id="accordion">
        <?php $count = 0; ?>
        @foreach($tasks as $task)
        <?php $task_completion = App\Job_Task_Completion::where('task_id', $task->task_id)->where('job_request_id', $Job_Request->job_request_id)->orderBy('created_at', 'desc')->first();?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $count; ?>">
                        <div class="row">
                            <div class="col-md-1"><div class="step s<?php echo $count; ?>"><?php $other = $count + 1; echo $other; ?></div></div>
                            @if(!is_null($task_completion))
                                <div class="col-md-11 step-text">{{$task->task_name}}<span class="pull-right" style="color: #4BD39C;">{{$task_completion->status}}</span></div>
                            @else
                                <div class="col-md-11 step-text">{{$task->task_name}}<span class="pull-right" style="color: RED;">PENDING</span></div>
                            @endif
                        </div>
                    </a>
                </h4>
            </div>
            @if(!is_null($task_completion))
                <div id="collapse<?php echo $count; ?>" class="panel-collapse collapse in">
                    <div class="panel-body">
                    <div class="line-wizard l1"></div>
                        <div class="row">
                                <div class="col-md-1"></div>
                                <div class="col-md-11 step-text">
                                    <div class="row" style="padding-left: 5px; padding-right: 5px;">
                                <div class="4">
                                    <label><h5>Date/Time Started:</h5></label>
                                    <span class="pull-right">{{$task_completion->start_date}}</span>
                                </div>
                                <div class="4">
                                    <label><h5>Remark:</h5></label>
                                    <span class="pull-right">{{$task_completion->comments}}</span>
                                </div>
                                <div class="4">
                                    <label><h5>Completion Date:</h5></label>
                                    <span class="pull-right">{{$task_completion->end_date}}</span>
                                </div>

                                </div>

                                </div>
                            </div>
                    </div>
                </div>
            @else
                <div id="collapse<?php echo $count; ?>" class="panel-collapse collapse in">
                    <div class="panel-body">
                        <div class="line-wizard l1"></div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-11 step-text">
                                <div class="row" style="padding-left: 5px; padding-right: 5px;">
                                    <div class="4">
                                        <label><h5>Date/Time Started:</h5></label>
                                        <span class="pull-right">None</span>
                                    </div>
                                    <div class="4">
                                        <label><h5>Remark:</h5></label>
                                        <span class="pull-right">None</span>
                                    </div>
                                    <div class="4">
                                        <label><h5>Completion Date:</h5></label>
                                        <span class="pull-right">None</span>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            @endif
            </div>
        <?php $count++; ?>
     @endforeach

    </div>
</div>
		<hr>
		</div>


	</div>

	<div class="row" style="height: 50px;"></div>

</div>



<div class="modal fade" id="myModal" role="dialog">
		<div class="modal-dialog modal-dialog-centered">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">MAKE AN URGENT REQUEST</h4>
				</div>
				<div class="modal-body">
							<form id="emailRequest">
								<meta name="csrf_token" content="{{csrf_token()}}">
								<input type="hidden" id="client_name" name="" value="{{DB::table('clients')->where('client_id', $Job_Request->client_id)->value('company_name')}}">
								 <div class="form-group">
									 <label for="message-text" class="col-form-label">Message:</label>
									 <textarea class="form-control" id="message-text" rows="10" placeholder="Make a quick request or send a quick message about your needs."></textarea>
								 </div>
					 </form>
				</div>
				<div class="modal-footer">
					<button type="button" id="close_btn" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" id="send_client_urgent" class="btn btn-primary">Send Request</button>
				</div>
			</div>

		</div>
	</div>

	<div id="sending_progress" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none; margin-top: 40px;">
	    <div class="modal-dialog">
	        <center>
	            <img src="{{asset('images/sending.gif')}}" alt="sending message">
	        </center>
	    </div>

	</div><!-- /.modal -->

<script type="text/javascript">
	$(function() {

        $('.next').click(function() {
            var numStep = $(this).attr( "num-step" );
            var clStep = '#collapse' + (parseInt(numStep) + 1);
            $(clStep).collapse('show');
            $('#accordion .in').collapse('hide');
            console.log(clStep);
            /*cambiar estilo e imagen a botón*/
            $('.s' + numStep).addClass('step-ok').removeClass('step');
            $('.s' + numStep).empty().append('<i class=\"fa fa-check\" aria-hidden=\"true\"><\/i>');

        });

        $('.prev').click(function() {
            var numStep = $(this).attr( "num-step" );
            var clStep = '#collapse' + (parseInt(numStep) - 1);
            $(clStep).collapse('show');
            $('#accordion .in').collapse('hide');
        });

        $('.btn-primary').click(function() {

            var delay = 4000;
            setTimeout(function(){ window.location = 'p3'; }, delay);

        });

         $('.btn-secondary').click(function() {
            $('.step-ok').addClass('step').removeClass('step-ok');
            $('.s0').empty().append('1');
            $('.s1').empty().append('2');
            $('#collapse0').collapse('show');
            $('#accordion .in').collapse('hide');

        });


    });
</script>



@endsection
