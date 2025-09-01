@extends('header-footer.client-header-footer')
@section('content')

<style type="text/css">
body{
	background-image: url("{{ asset('/images/bg2.jpg') }}");
	background-repeat: no-repeat;
	background-size: cover;
}
	input, button{
		width: 100%;
		margin-bottom: 10px;
	}
</style> 

<div class="container">
	<div class="row">
		<div class="col-md-12" style="height: 100px;"></div>
		<div class="col-md-12">
		<h5 style="margin-top: 10px;">Track the way you want</h5>
		<p>Need the status of job progress? Enter the tracking number or reference number below.</p>
		</div>

		
	</div>

	@if($check == 1)
		<div class="row" style="height: 50px;"></div>
			<div class="alert alert-danger alert-dismissable">
			  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			  	<strong>Sorry!!!</strong> invalid Reference Number
		</div>
	@endif

	<div class="row">
			<div class="row">
					<div class="col-md-12">
						<label>ENTER JOB REFERENCE NUMBER</label>
					</div>
					<form method="POST" action="{{url('/tracked-result')}}" >
						{{csrf_field()}}
						<div class="col-md-8">
							<input name="job_tracking" type="text" placeholder="ENTER REFERENCE NUMBER" class="" style="padding: 12px;">
						</div>
						<div class="col-md-4">
							<button type="submit" class="btn waves-effect waves-light" id="submit__job_request" style="background-color: #36404e; color: #fff; padding: 12px;">TRACK</button>
						</div>
					</form>
					<div class="col-md-12">
						<a href="#">Your job at your comfort</a> | <a href="#">Need Help?</a>
					</div>
			</div>
	</div>
</div>
	
</div>



@endsection