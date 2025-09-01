@extends('partner.admin.admin-template')
@section('admin')


<div class="container">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="page-title-box">
                                    <h4 class="page-title">Employees</h4>
                                    <ol class="breadcrumb p-0 m-0">
                                        
                                        <li>
                                            <a href="#">Firmus Advisory</a>
                                        </li>
                                        <li>
                                            <a href="#">Employees</a>
                                        </li>

                                    </ol>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->

                        <div class="row" style="margin-bottom: 20px;">
                            <div class="col-md-12">   
                                <button class="btn-rounded btn-inverse waves-effect waves-light m-b-5 pull-right" data-toggle="modal" data-target="#con-close-modal"> <i class="fa fa-plus-circle m-r-5"></i> <span>Add Employee</span> </button>
                                        
                            </div>
                        </div>

                        <!-- Create New Employee form -->

                         <div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    <h4 class="modal-title">New Employee Form</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="employee_forms">
                                                     <meta name="csrf-token" content="{{ csrf_token() }}">
                            
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="field-1" class="control-label">First Name</label>
                                                                <input type="text" class="form-control" name="first_name" id="field-1" placeholder="Kassim" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="field-2" class="control-label">Other Name</label>
                                                                <input type="text" class="form-control" name="other_name" id="field-2" placeholder="Mohammed">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="field-2" class="control-label">Surname</label>
                                                                <input type="text" class="form-control" name="last_name" id="field-3" placeholder="Balogun" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="field-8" class="control-label">Gender</label>
                                                                <select class="form-control" id="field-8" name="gender" required>
                                                                    <option value="null">- Choose Gender -</option>
                                                                    <option value="MALE">Male</option>
                                                                    <option value="FEMALE">Female</option>

                                                                </select>
                                                                
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="field-2" class="control-label">Phone</label>
                                                                <input type="text" class="form-control" name="contact_number" id="field-4" placeholder="Phone Number" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="field-2" class="control-label">Home Address</label>
                                                                <input type="text" class="form-control" name="address" id="field-5" placeholder="Hse.25, East Legon" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="field-2" class="control-label">Company email</label>
                                                                <input type="email" class="form-control" name="company_email" id="field-6" placeholder="Email" required>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="field-7" class="control-label">Position</label>
                                                                <select class="form-control" id="field-7" name="position" required>
                                                                    <option value="null">- Choose Position -</option>
                                                                    <option value="Manager">Manager</option>
                                                                    <option value="Finance Officer">Finance Officer</option>
                                                                    <option value="Employee">Employee </option>
                                                                    <option value="System Administrator">System Administrator</option>
                                                                    <option value="Partner">Partner</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default waves-effect close_emp_form" data-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-info waves-effect waves-light save_changes">Save changes</button>
                                                    <button type="button" class="btn btn-info waves-effect waves-light update_changes">update</button>
                                                    <button type="button" style="display: none;" class="btn btn-warning waves-effect waves-light reset_password">Reset Password</button>
                                                </div>
                                              </form>
                                            </div>
                                        </div>
                                    </div><!-- /.modal -->


                        <!-- End of employee form -->

                        

                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-sm-12">
                                <div class="card-box table-responsive">
                                    <h4 class="m-t-0 header-title"><b>All Employees</b></h4>
                                    <p class="text-muted font-13 m-b-30">
                                        
                                    </p>

                                    <table id="datatable-buttons" class="table table-striped table-bordered tbt">
                                        <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Position</th>
                                            <th>Company Email</th>
                                            <th>Home Address</th>
                                            <th>Phone</th>
                                            <th>Gender</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($emp_information) > 0)
                                                @foreach($emp_information as $all_emp_info)
                                                <tr id="employee_row{{$all_emp_info->emp_id}}">
                                                    <td>{{$all_emp_info->first_name}} {{" "}} {{$all_emp_info->other_name}}  {{$all_emp_info->last_name}}</td>
                                                    <td>{{$all_emp_info->position}}</td>
                                                    <td>{{$all_emp_info->company_email}}</td>
                                                    <td>{{$all_emp_info->address}}</td>
                                                    <td>{{$all_emp_info->contact_number}}</td>
                                                    <td>{{$all_emp_info->gender}}</td>
                                                    <td><a  class="btn btn-primary edit_btn" value="{{$all_emp_info->emp_id}}">Edit</a></td>
                                                    <td><a class="btn btn-danger employee_delete_info" value="{{$all_emp_info->emp_id}}">Delete</a></td>
                                                </tr>

                                            
                                                @endforeach
                                            @endif                            
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