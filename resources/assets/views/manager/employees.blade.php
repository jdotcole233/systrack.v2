@extends('partner.manager.manager-template')
@section('manager')

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




                            </div>
                        </div>






                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-sm-12">
                                <div class="card-box table-responsive">
                                    <h4 class="m-t-0 header-title"><b>All Employees</b></h4>
                                    <p class="text-muted font-13 m-b-30">

                                    </p>

                                    <table id="datatable-buttons" class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Position</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Start date</th>
                                        </tr>
                                        </thead>


                                        <tbody>
                                        @foreach($employee_manager_view as $employee)
                                        <tr>
                                            <td>{{$employee->first_name .' ' .$employee->other_name. ' '.$employee->last_name}}</td>
                                            <td>{{$employee->position}}</td>
                                            <td>{{$employee->company_email}}</td>
                                            <td>{{$employee->contact_number}}</td>
                                            <td>{{$employee->created_at}}</td>
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
