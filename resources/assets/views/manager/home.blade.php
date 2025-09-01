@extends('partner.manager.manager-template')
@section('manager')

<div class="container">
                        <div class="row">
							<div class="col-xs-12">
								<div class="page-title-box">
                                    <h4 class="page-title">Manager Dashboard</h4>
                                    <ol class="breadcrumb p-0 m-0">
                                        <li>
                                            <a href="#">Firmus Advisory</a>
                                        </li>
                                        <li>
                                            <a href="#">Dashboard</a>
                                        </li>
                                        <li class="active">
                                            Manager
                                        </li>
                                    </ol>
                                    <div class="clearfix"></div>
                                </div>
							</div>
						</div>
                        <!-- end row -->

                        <div class="row">

                            <div class="col-lg-2 col-md-4 col-sm-6">
                                <div class="card-box widget-box-one">
                                    <i class="mdi mdi-chart-areaspline widget-one-icon"></i>
                                    <div class="wigdet-one-content">
                                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="Statistics">Total Jobs</p>
                                        <h2><span id="jobStat" >0</span><small><i class="mdi mdi-arrow-up text-success"></i></small></h2>
                                    </div>
                                </div>
                            </div><!-- end col -->

                            <div class="col-lg-2 col-md-4 col-sm-6">
                                <div class="card-box widget-box-one">
                                    <i class="mdi mdi-account-convert widget-one-icon"></i>
                                    <div class="wigdet-one-content">
                                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="User Today">Total Clients</p>
                                        <h2><span id="clientStat" >0</span><small><i class="mdi mdi-arrow-down text-danger"></i></small></h2>
                                    </div>
                                </div>
                            </div><!-- end col -->

                            <div class="col-lg-2 col-md-4 col-sm-6">
                                <div class="card-box widget-box-one">
                                    <i class="mdi mdi-layers widget-one-icon"></i>
                                    <div class="wigdet-one-content">
                                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="User This Month">Pending Payments</p>
                                        <h2><span id="pendingPaymentStat" >0</span><small><i class="mdi mdi-arrow-up text-success"></i></small></h2>
                                    </div>
                                </div>
                            </div><!-- end col -->

                            <div class="col-lg-2 col-md-4 col-sm-6">
                                <div class="card-box widget-box-one">
                                    <i class="mdi mdi-av-timer widget-one-icon"></i>
                                    <div class="wigdet-one-content">
                                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="Request Per Minute">Pending Jobs</p>
                                        <h2><span id="pendingJobStat" >0</span> <small><i class="mdi mdi-arrow-down text-danger"></i></small></h2>
                                    </div>
                                </div>
                            </div><!-- end col -->

                            <div class="col-lg-2 col-md-4 col-sm-6">
                                <div class="card-box widget-box-one">
                                    <i class="mdi mdi-account-multiple widget-one-icon"></i>
                                    <div class="wigdet-one-content">
                                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="Total Users">Total Employees</p>
                                        <h2><span id="employeeStat" >0</span> <small><i class="mdi mdi-arrow-down text-danger"></i></small></h2>
                                    </div>
                                </div>
                            </div><!-- end col -->

                            <div class="col-lg-2 col-md-4 col-sm-6">
                                <div class="card-box widget-box-one">
                                    <i class="mdi mdi-download widget-one-icon"></i>
                                    <div class="wigdet-one-content">
                                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="New Downloads">Contacts</p>
                                        <h2><span id="contactStat" >0</span> <small><i class="mdi mdi-arrow-up text-success"></i></small></h2>
                                    </div>
                                </div>
                            </div><!-- end col -->

                        </div>
                        <!-- end row -->


                        <div class="row">
                            <div class="col-lg-4">
                        		<div class="card-box">

                        			<h4 class="header-title m-t-0">Job Delivery</h4>

                                    <div class="widget-chart text-center">
                                        <div id="morris-donut-example" style="height: 245px;"></div>
                                        <ul class="list-inline chart-detail-list m-b-0">
                                            <li>
                                                <h5 class="text-danger"><i class="fa fa-circle m-r-5"></i>Pending Jobs</h5>
                                            </li>
                                            <li>
                                                <h5 class="text-success"><i class="fa fa-circle m-r-5"></i>Completed Jobs</h5>
                                            </li>
                                            <li>
                                                <h5 class="text-success"><i class="fa fa-circle m-r-5"></i>Rejected Jobs</h5>
                                            </li>

                                        </ul>
                                	</div>
                        		</div>
                            </div><!-- end col -->

                            <div class="col-lg-4">
                                <div class="card-box">

                                    <h4 class="header-title m-t-0">Statistics</h4>
                                    <div id="morris-bar-example" style="height: 280px;"></div>
                                </div>
                            </div><!-- end col -->

                            <div class="col-lg-4">
                                <div class="card-box">

                                    <h4 class="header-title m-t-0">Total Revenue This Month</h4>
                                    <div id="morris-line-example" style="height: 280px;"></div>
                                </div>
                            </div><!-- end col -->

                        </div>
                        <!-- end row -->


                        <div class="row">
                            <div class="col-lg-12">
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
