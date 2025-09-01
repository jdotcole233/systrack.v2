@extends('partner.admin.admin-template')
@section('admin')


<div class="container">


                        <div class="row">
                            <div class="col-xs-12">
                                <div class="page-title-box">
                                    <h4 class="page-title">Admin Dashboad </h4>
                                    <ol class="breadcrumb p-0 m-0">
                                        <li>
                                            <a href="#">Firmus Advisory</a>
                                        </li>
                                        <li>
                                            <a href="#">Dashboard </a>
                                        </li>
                                        <li class="active">
                                            Admin
                                        </li>
                                    </ol>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->


                        <div class="row">

                            <div class="col-lg-3 col-md-6">
                                <div class="card-box widget-box-two widget-two-primary">
                                    <i class="mdi mdi-chart-areaspline widget-two-icon"></i>
                                    <div class="wigdet-two-content">
                                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="Statistics">Total Enmployee</p>
                                        <h2><span id="employeeStat" data-plugin="counterup">0</span> <small><i class="mdi mdi-arrow-up text-success"></i></small></h2>
                                    </div>
                                </div>
                            </div><!-- end col -->

                            <div class="col-lg-3 col-md-6">
                                <div class="card-box widget-box-two widget-two-warning">
                                    <i class="mdi mdi-layers widget-two-icon"></i>
                                    <div class="wigdet-two-content">
                                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="User This Month">Total Activities</p>
                                        <h2><span id="activitiesStat" data-plugin="counterup">0</span> <small><i class="mdi mdi-arrow-up text-success"></i></small></h2>
                                    </div>
                                </div>
                            </div><!-- end col -->

                            <div class="col-lg-3 col-md-6">
                                <div class="card-box widget-box-two widget-two-danger">
                                    <i class="mdi mdi-access-point-network widget-two-icon"></i>
                                    <div class="wigdet-two-content">
                                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="Statistics">User This Month</p>
                                        <h2><span id="activitiesThisMonthStat" data-plugin="counterup">0</span> <small><i class="mdi mdi-arrow-up text-success"></i></small></h2>
                                    </div>
                                </div>
                            </div><!-- end col -->

                            <div class="col-lg-3 col-md-6">
                                <div class="card-box widget-box-two widget-two-success">
                                    <i class="mdi mdi-account-convert widget-two-icon"></i>
                                    <div class="wigdet-two-content">
                                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="User Today">User Today</p>
                                        <h2><span id="activitiesTodayStat" data-plugin="counterup">0 </span> <small><i class="mdi mdi-arrow-down text-danger"></i></small></h2>
                                    </div>
                                </div>
                            </div><!-- end col -->

                        </div>
                        <!-- end row -->


                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card-box">
                                    <h4 class="header-title m-t-0 m-b-30">User Graph Analytics</h4>

                                    <div id="website-stats" style="height: 320px;" class="flot-chart"></div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="card-box">
                                    <h4 class="header-title m-t-0">User Pie Chart Analytics</h4>

                                    <div class="pull-right m-b-30">
                                        <div id="reportrange" class="form-control">
                                            <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                            <span></span>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>

                                    <div id="donut-chart">
                                        <div id="donut-chart-container" class="flot-chart" style="height: 240px;">
                                        </div>
                                    </div>

                                    <p class="text-muted m-b-0 m-t-15 font-13 text-overflow">Pie chart is used to see the proprotion of each data groups, making Flot pie chart is pretty simple, in order to make pie chart you have to incldue jquery.flot.pie.js plugin.</p>
                                </div>
                            </div>

                        </div>
                        <!-- end row -->


                        <div class="row">

                            <div class="col-md-4">
                                <div class="card-box">
                                   <h4 class="header-title m-t-0 m-b-30">Messages
                                         <button type="button" class="btn btn-danger clearAllMessages" style="float:right" data-dismiss="alert" aria-label="Close">  CLEAR ALL</button>
                                    </h4>
                                    <form action="">
                                      <meta name="csrf-token" content=" {{csrf_token()}} " >
                                    </form>
                                    <div id="messages_notifications" class="inbox-widget slimscroll-alt" style="min-height: 302px; overflow-x: scroll">

                                    </div>

                                </div> <!-- end card -->
                            </div>
                            <!-- end col -->

                            <div class="col-md-8">
                                <div class="card-box">
                                    <h4 class="header-title m-t-0 m-b-30">Recent Users</h4>

                                    <div class="table-responsive">
                                        <table id="datatable-buttons" class="table table table-hover m-0">
                                            <thead>
                                            <tr>
                                                <th></th>
                                                <th>Employee Name</th>
                                                <th>Access point IP</th>
                                                <th>Country Code</th>
                                                <th>Date/Time of access</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            @foreach($user_activity as $activity)
                                                <tr>
                                                    <td><img  src="{{ asset('/images/profile_photo/'.App\Models\Employee::where('emp_id', $activity->emp_id)->value('profile_pic')) }}"  alt="user" class="thumb-sm img-circle"></td>
                                                    <?php $em_name = DB::table('employees')->where('delete_status','NOT DELETED')->where('emp_id', $activity->emp_id)->first(); ?>
                                                    <td>{{ $em_name->first_name }} {{ $em_name->other_name }} {{ $em_name->last_name }}</td>
                                                    <td>{{$activity->location_ip_addresses}}</td>
                                                    <td>{{$activity->country_code}}</td>
                                                    <td>{{$activity->created_at}}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>

                                    </div> <!-- table-responsive -->
                                </div> <!-- end card -->
                            </div>
                            <!-- end col -->

                        </div>
                        <!-- end row -->


                    </div> <!-- container -->


@endsection