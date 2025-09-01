@extends('meeting.meeting-template')
@section('meeting')
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-lite.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-lite.js"></script>

<style type="text/css">
    table tr:hover{
        cursor: pointer;
    }

    #editBtn{
        display: block;
    }
    #update_btn_minutes{
        display: none;
    }

    #update_meeting_info{
        display: none;
    }
</style>

<div class="container">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="page-title-box">
                                    <h4 class="page-title">Meetings</h4>
                                    <ol class="breadcrumb p-0 m-0">
                                        
                                        <li>
                                            <a href="#">Firmus Advisory</a>
                                        </li>
                                        <li>
                                            <a href="#">Meetings</a>
                                        </li>

                                    </ol>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->

                        


                        
                        

                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-sm-12">
                                <div class="card-box table-responsive">
                                    <h4 class="m-t-0 header-title"><b>Meetings</b>
                                        <span class="pull-right"><button id="addMeetingButton" class="btn-rounded btn-inverse waves-effect waves-light m-b-5 pull-right" data-toggle="modal" data-target="#custom-width-modal"> <i class="fa fa-plus-circle m-r-5"></i> <span>Add Meeting</span> </button></span></h4>
                                    <p class="text-muted font-13 m-b-30">
                                        
                                    </p>

                                    <table id="datatable-buttons" class="meeting_table table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Meeting Title</th>
                                            <th>Meeting Status</th>
                                            <th>Purpose of meeting</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>View/Update</th>
                                            <th>Cancel Meeting</th>
                                        </tr>
                                        </thead>


                                        <tbody>
                                         <?php $meetings_ = DB::table('meetings')->select('*')->get(); ?>
                                         @foreach( $meetings_ as  $meeting)
                                        <tr  >
                                            <td>{{$meeting->title}}</td>
                                            <td>{{$meeting->meeting_status}}</td>
                                            <td>{{$meeting->purpose}}</td>
                                            <td>{{$meeting->date}}</td>
                                            <td>{{$meeting->meeting_start_time}} - {{$meeting->meeting_end_time}}</td>
                                            <td><button class="view_update_btn btn btn-primary"  value="{{$meeting->meeting_id}}">View/Update</button></td>
                                            @if($meeting->meeting_status == "CANCELLED")
                                                <td><button class="cancel_meeting btn btn-warning" disabled>Cancel Meeting</button></td>
                                            @else
                                                <td><button class="cancel_meeting btn btn-warning" value="{{$meeting->meeting_id}}">Cancel Meeting</button></td>
                                            @endif

                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>

                                    <!--  About Job Modal -->

                         <div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    <h4 class="modal-title">Meeting Details</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="minutes_forms">
                                                    <div class="row">
                                                        
                                                            <div class="col-md-12">
                                                                
                                                                </div>
                                                        <!-- Hidden input field for minutes update -->
                                                 <input type="hidden" class="form-control" id="meeting_back_id" value="" >

                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="field-1" class="control-label">Meeting Title</label>
                                                                <input type="text" class="form-control" id="meeting_title_back" value="Title" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="form-group">
                                                                <label for="field-2" class="control-label">Purpose of Meeting</label>
                                                                <input type="text" class="form-control" id="meeting_purpose_back" value="Purpose of meeting" disabled>
                                                                
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="field-2" class="control-label">Invited Parties</label>
                                                                <table class="table table-hover" id="invited_employees">
                                                                    
                                                                </table>
                                                                
                                                            </div>
                                                        </div>
                                                        <div id="removed_important" style="display: none;"></div>
                                                       
                                                         <section id="update_meeting_info">
                                                            <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="field-2" class="control-label">Change Status</label>
                                                                 <select name="meeting_status_fur" id="assignedEmployee_meeting_status" class="form-control">
                                                                    <option value="UPCOMING">Upcoming</option>
                                                                    <option value="POSTPONED">Postponed</option>
                                                                </select>
                                                            </div>
                                                             </div>

                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="field-2" class="control-label">Invite From Employees</label>
                                                                <div class="col-md-10">


                                                                <select id="assignedEmployee_meeting_edit" class="form-control">
                                                                   <?php $employees = DB::table('employees')->select('emp_id','first_name','other_name','last_name')->get() ?>
                                                                   <option id="dont">-- Add from Employees --</option>
                                                                   @foreach($employees as $employee)
                                                                        <option id="e{{$employee->emp_id}}" value="{{$employee->first_name}} {{$employee->last_name}}">{{$employee->first_name. " ". $employee->other_name . " ".$employee->last_name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-2">
                                                            <button type="button" onClick="addEmployee('assignedEmployee_meeting_edit','invited_employees')" class="btn btn-info waves-effect waves-light">Add</button>
                                                        </div>
                                                                
                                                    </div>
                                                 </div>


                                                <div class="col-md-12" style="margin-top: 15px;">
                                                    <div class="form-group">
                                                        <label for="field-2" class="control-label">External Guests</label>
                                                        <div class="col-md-10">
                                                        <select id="assignedContact_meeting_edit" class="form-control">
                                                           <?php $contacts = DB::table('contacts')->select('contact_id','contact_name')->get() ?>
                                                           <option id="dont">-- Add from Address book --</option>
                                                           @foreach($contacts as $contact)
                                                                <option id="c{{$contact->contact_id}}" value="{{$contact->contact_name}}">{{$contact->contact_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2">
                                                    <button type="button" onClick="addEmployee('assignedContact_meeting_edit','invited_employees')" class="btn btn-info waves-effect waves-light">Add</button>
                                                </div>
                                                        
                                                    </div>
                                                </div>
                                                </section>
                                                
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="field-2" class="control-label">Starts from</label>
                                                                <input type="time" class="form-control" value="9:00 AM - 11:00 AM" id="meeting_time_back" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="field-2" class="control-label">Ends at</label>
                                                                <input type="time" class="form-control" value="9:00 AM - 11:00 AM" id="meeting_time_back_end" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="field-2" class="control-label">Date</label>
                                                                <input type="date" class="form-control" value="2/01/2018" id="meeting_date_back" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="field-2" class="control-label">Venue</label>
                                                                <input type="text" class="form-control" placeholder="E.g Office, Achimota" id="meeting_venue_back" disabled>
                                                            </div>
                                                        </div>
                                
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="field-2" class="control-label">Minute</label>
                                                                <textarea class="form-control autogrow" name="minutes" id="meeting_minute_to_go" placeholder="Add Minutes to the meeting" name="minutes" readonly></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div id="summernote"></div>
                                                        </div>


                                                    </div>
                                                    </form>
                                                    
                                                    
                                                   
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" id="closeBtn" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                                    <button type="button" id="editBtn" class="btn btn-info waves-effect waves-light" onClick="editable()">Edit</button>
                                                    <button type="button" id="update_btn_minutes" class="btn btn-info waves-effect waves-light" onClick="editable()">update</button>
                                                    <button type="button" class="btn btn-danger waves-effect waves-light">Delete</button>

                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.modal -->


                        <!-- End of About Meeting -->
                                </div>
                            </div>
                            </div>

                        </div>
                        <!-- end row -->

                        <script type="text/javascript">

                            var editButton = document.getElementById('meeting_title_back');
                            var editButton1 = document.getElementById('meeting_purpose_back');
                            var editButton2 = document.getElementById('meeting_date_back');
                            var editButton3 = document.getElementById('meeting_time_back');
                            var editButton7 = document.getElementById('meeting_time_back_end');
                            var editButton4 = document.getElementById('meeting_venue_back');
                            var editButton5 = document.getElementById('meeting_minute_to_go');
                            var editButton6 = document.getElementById('meeting_title_back');

                            var a = [editButton,editButton1,editButton2,editButton3,editButton4,editButton5,editButton6,editButton7];



                            var closeBtn = document.getElementById('closeBtn');

                            var editBtn = document.getElementById('editBtn');


                            closeBtn.addEventListener("click", function(){

                                editBtn.textContent = "Edit";

                                for (var i = 0; i <= 8; i++) {
                                    a[i].disabled = true;
                                }
                            });


                            function editable(){

                                document.getElementById('editBtn').style.display = 'none';
                                document.getElementById('update_btn_minutes').style.display = 'block';
                                document.getElementById('update_meeting_info').style.display = 'block';

                                for (var i = 0; i <= 8; i++) {
                                    a[i].disabled = false;
                                }
                            }

                           
                        </script>


                        <div id="custom-width-modal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: hidden;">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    <h4 class="modal-title">Add New Meeting</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="make_meetings" action="{{url('/make_meetings')}}">
                                                        <meta name="csrf-token" content="{{csrf_token()}}">
                                                    <div class="row">
                                                        
                                                            <div class="col-md-12">
                                                                
                                                                </div>

                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="field-1" class="control-label">Meeting Title</label>
                                                            <input type="text" name="title" class="form-control" id="field-1" placeholder="Title">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="form-group">
                                                                <label for="field-2" class="control-label">Purpose of Meeting</label>
                                                                <input type="text" name="purpose" class="form-control" id="field-1" placeholder="Purpose of meeting" >
                                                                
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="field-2" class="control-label">Invited Employees</label>
                                                                <div class="col-md-10">

                                                                    <!-- Hidden input for json data -->
                                                                <input type="hidden" name="jsonData" class="form-control" id="jsonData" value="">
                                                                <input type="hidden" name="removed_employees" class="form-control" id="removed_employees" value="">

                                                                <select id="assignedEmployee" class="form-control">
                                                                   <?php $employees = DB::table('employees')->select('emp_id','first_name','other_name','last_name')->get() ?>
                                                                   <option id="dont">-- Add from Employees --</option>
                                                                   @foreach($employees as $employee)
                                                                        <option id="e{{$employee->emp_id}}" value="{{$employee->first_name}} {{$employee->last_name}}">{{$employee->first_name. " ". $employee->other_name . " ".$employee->last_name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-2">
                                                            <button type="button" onClick="addEmployee('assignedEmployee','employeeList')" class="btn btn-info waves-effect waves-light">Add</button>
                                                        </div>
                                                                
                                                    </div>
                                                 </div>
                                                         <div class="col-md-12">
                                                                <h4>Assigned Employee(s)</h4>
                                                                <table class="table table-responsive table-striped" id="employeeList">
                                                                </table>
                                                            </div>

                                                        <div class="col-md-12" style="margin-top: 15px;">
                                                            <div class="form-group">
                                                                <label for="field-2" class="control-label">External Guests</label>
                                                                <div class="col-md-10">
                                                                <select id="assignedContact" class="form-control">
                                                                   <?php $contacts = DB::table('contacts')->select('contact_id','contact_name')->get() ?>
                                                                   <option id="dont">-- Add from Address book --</option>
                                                                   @foreach($contacts as $contact)
                                                                        <option id="c{{$contact->contact_id}}" value="{{$contact->contact_name}}">{{$contact->contact_name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-2">
                                                            <button type="button" onClick="addEmployee('assignedContact','employeeList')" class="btn btn-info waves-effect waves-light">Add</button>
                                                        </div>
                                                                
                                                            </div>
                                                        </div>
                                                        

                                                        <script type="text/javascript">
                                                            

                                                                function addExternal(){
                                                                    var external = document.getElementById('externalArea').value;

                                                                    if (count == 1) {
                                                                        document.getElementById('employeeDisplayArea').innerHTML = external
                                                                        count += 1;
                                                                    } else{

                                                                        var initialValue = document.getElementById('employeeDisplayArea').innerHTML;

                                                                        
                                                                            document.getElementById('employeeDisplayArea').innerHTML = initialValue + ', ' + external;
                                                                        

                                                                    
                                                                    }
                                                                    
                                                                    

                                                                }
                                                            </script>
                         <!--      <script type="text/javascript">
                                        var count = 1;


                                        function addEmployee(assigned,table_name){

                                            var bool = false;

                                            var employee = document.getElementById(assigned).value;
                                            var employeeDropDown = document.getElementById(assigned);
                                            
                                            var table = document.getElementById(table_name);

                                            employeeID = employeeDropDown.options[employeeDropDown.selectedIndex].id;
                                            var em_id = "sime" + employeeID;


                                            if(employeeID === 'dont')
                                                return;
                                            
                                            $('#employeeList tr').each(function (i, v) {
                                                if($(this).attr('id') === em_id ) {
                                                    bool = true;
                                                }

                                            });
                                            if (!bool) {
                                                var row = table.insertRow(0);
                                                row.setAttribute("id", em_id);
                                                row.setAttribute("name", employee);
                                                var cell1 = row.insertCell(0);
                                                var cell2 = row.insertCell(1);
                                                cell1.innerHTML = employee;
                                                cell2.innerHTML = "<button type='button' id='" + employeeID + "' style='padding:0; width:28px; height:28px;' class='emp_remove btn-rounded btn-danger pull-right ' onclick='emp_remove(this.id)'><i class='fa fa-minus-circle'></i></button>";
                                            }


                                        }
                                    </script>
 -->                                     <script type="text/javascript">
                                            var count = 1;


                                            function addEmployee(assigned,table_name){

                                                var bool = false;

                                                var employee = document.getElementById(assigned).value;
                                                var employeeDropDown = document.getElementById(assigned);
                                                var table = document.getElementById(table_name);

                                                if (employee.substring(0, 2) == '--')
                                                    return;

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
                                                    row.setAttribute("name", employee);
                                                    var cell1 = row.insertCell(0);
                                                    var cell2 = row.insertCell(1);
                                                    cell1.innerHTML = employee;
                                                    cell2.innerHTML = "<button type='button' id='" + employeeID + "' style=\"padding:0; width:28px; height:28px;\" class='emp_remove btn-rounded btn-danger pull-right ' onclick='emp_remove(this.id)'><i class='fa fa-minus-circle'></i> Remove</button>";
                                                }

                                            }
                                        </script>
                                                                            

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="field-2" class="control-label">Date</label>
                                                                <input type="date" name="date" class="form-control" value="" id="field-2" >
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="field-2" class="control-label">Starts from </label>
                                                                <input type="time" name="meeting_start_time" class="form-control" placeholder="2/01/2018" id="field-2" >
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="field-2" class="control-label">Ends at</label>
                                                                <input type="time" name="meeting_end_time" class="form-control" placeholder="2/01/2018" id="field-2" >
                                                            </div>
                                                        </div>
                                                         <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="field-2" class="control-label">Meeting Status</label>
                                                                <div class="col-md-12">
                                                                <select name="meeting_status" id="assignedEmployee" class="form-control">
                                                                    <option value="UPCOMING">upcoming</option>
                                                                </select>
                                                            </div>
                                                            
                                                                
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="field-2" class="control-label">Venue</label>
                                                                <input type="text" name="meeting_venue" class="form-control" placeholder="Venue" id="field-2" >
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                </form>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                                    <button id="enter_meeting" type="button" class="btn btn-info waves-effect waves-light">Save</button>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.modal -->
                                    </div>


                    </div> <!-- container -->

<div id="loading_progress" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none; margin-top: 40px;">
        <div class="modal-dialog">
            <center>
                <img src="{{asset('images/loader.gif')}}" alt="please wait">
            </center>
        </div>

    </div><!-- /.modal -->
@endsection