@foreach($notifications as $notification)
<a >
<button type="button" data-notificationid="{{$notification->notification_id}}" class="btn btn-danger deleteNotification" style="float:right" data-dismiss="alert" aria-label="Close">DELETE</button>
	<?php 
        	$employee = App\Models\Employee::where('emp_id', $notification->sender_id)->first();
        ?>
    <div class="inbox-item">
        <div class="inbox-item-img"><img src="{{ asset('/assets/images/users/avatar-1.jpg') }}" class="img-circle" alt=""></div>
        <p class="inbox-item-author">{{$employee->first_name}} {{$employee->other_name}} {{$employee->last_name}}</p>
        <p class="inbox-item-text">{{$notification->subject}}</p>
        <p class="inbox-item-date">{{$notification->time}}</p>
    </div>
</a>
@endforeach