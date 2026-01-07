@extends('header-footer.employee-header-footer')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="page-title-box">
                    <h4 class="page-title">Employee Dashboad </h4>
                    <ol class="breadcrumb p-0 m-0">
                        <li>
                            <a href="#">Firmus Advisory</a>
                        </li>
                        <li>
                            <a href="#">Dashboard </a>
                        </li>
                        <li class="active">
                            Employee
                        </li>
                    </ol>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <!-- end row -->


        <div class="row text-center">

            <!-- <div class="col-lg-2 col-md-4 col-sm-6">
                <div class="card-box widget-box-one">
                    <div class="wigdet-one-content">
                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow">Unassigned Jobs</p>
                        <h2 class="text-danger"><span id="unassingedJobStat" data-plugin="counterup">0</span></h2>
                    </div>
                </div>
            </div> -->
            <!-- end col -->



            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card-box widget-box-one">
                    <div class="wigdet-one-content">
                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow">Completed Jobs</p>
                        <h2 class="text-success"><span id="completedJobStat" data-plugin="counterup">{{ $job_completion_count }}</span></h2>
                    </div>
                </div>
            </div><!-- end col -->

            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card-box widget-box-one">
                    <div class="wigdet-one-content">
                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow">Pending Jobs</p>
                        <h2 class="text-warning"><span id="pendingJobStat" data-plugin="counterup">{{ $pending_jobs_count }}</span> </h2>
                    </div>
                </div>
            </div><!-- end col -->


            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card-box widget-box-one">
                    <div class="wigdet-one-content">
                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow">Total Assigned Jobs</p>
                        <h2 class="text-dark"><span id="assignedJobStat" data-plugin="counterup">{{ $job_assignment_count }}</span> </h2>
                    </div>
                </div>
            </div><!-- end col -->

            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card-box widget-box-one">
                    <div class="wigdet-one-content">
                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow">Total Activities</p>
                        <h2 class="text-dark"><span id="activitiesStat" data-plugin="counterup">{{ $activites_count }}</span> </h2>
                    </div>
                </div>
            </div><!-- end col -->

            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card-box widget-box-one">
                    <div class="wigdet-one-content">
                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow">Clients</p>
                        <h2 class="text-danger"><span id="contactStat" data-plugin="counterup">{{ $client_count }}</span> </h2>
                    </div>
                </div>
            </div><!-- end col -->

        </div>


        <div class="row">
            <div class="col-lg-6">
                <!-- <div class="card-box">
                    <h4 class="header-title m-t-0 m-b-30">Work Analytics</h4>

                    <div id="website-stats" style="height: 320px;" class="flot-chart"></div>
                </div> -->
            </div>

            <div class="col-lg-6">
                <!-- <div class="card-box">
                    <h4 class="header-title m-t-0">Job Delivery</h4>

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

                    <p class="text-muted m-b-0 m-t-15 font-13 text-overflow">Pie chart is used to see the proprotion of each
                        data groups, making Flot pie chart is pretty simple, in order to make pie chart you have to incldue
                        jquery.flot.pie.js plugin.</p>
                </div> -->
            </div>

        </div>
        <!-- end row -->


        <!--  About Job Modal -->




        <div class="row">
            <!-- INBOX -->
            <div class="col-lg-12">
                <div class="card-box">
                    <h4 class="header-title m-t-0 m-b-30">Messages
                        <button type="button" class="btn btn-danger clearAllMessages" style="float:right"
                            data-dismiss="alert" aria-label="Close"> CLEAR ALL</button>
                    </h4>
                    <form action="">
                        <meta name="csrf-token" content=" {{csrf_token()}} ">
                    </form>
                    <div id="messages_notifications" class="inbox-widget slimscroll-alt"
                        style="min-height: 302px; overflow-x: scroll">

                    </div>
                </div> <!-- end card -->
            </div>
        </div>


    </div> <!-- container -->


@endsection