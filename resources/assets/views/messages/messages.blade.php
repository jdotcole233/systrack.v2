
@foreach($messages as $message)
    
    @if($message->emp_id == Auth::user()->emp_id)
        <li class="clearfix">
            <div class="row pull-right">
                <div class="col-md-3 chat-avatar">
                    <span class="avatar-sm-box bg-success">{{substr(DB::table('employees')->where('emp_id', $message->emp_id)->value('last_name'),0,1)}}</span>
                    <i>{{$message->time}}</i>
                </div>
                <div class="col-md-9 conversation-text">
                    <div class="ctext-wrap" style="background-color: #ff8080;">
                        <i>{{DB::table('employees')->where('emp_id', $message->emp_id)->value('first_name')}} {{DB::table('employees')->where('emp_id', $message->emp_id)->value('last_name')}}</i>
                        <p style="color: white; font-size: 10pt;">
                            {{$message->message}}
                        </p>
                    </div>
                </div>
            </div>
        </li>
    @else
        <li class="clearfix">
            <div class="chat-avatar">
                <span class="avatar-sm-box bg-success">{{substr(DB::table('employees')->where('emp_id', $message->emp_id)->value('last_name'),0,1)}}</span>
                <i>{{$message->time}}</i>
            </div>
            <div class="conversation-text">
                <div class="ctext-wrap" style="background-color: #bad1ff;">
                    <i>{{DB::table('employees')->where('emp_id', $message->emp_id)->value('first_name')}} {{DB::table('employees')->where('emp_id', $message->emp_id)->value('last_name')}}</i>
                    <p style="color: white; font-size: 10pt;">
                        {{$message->message}}
                    </p>
                </div>
            </div>
        </li>
    @endif
@endforeach

