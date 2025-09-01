@extends('finance.finance-template')
@section('finance')


<div class="container">


                        <div class="row">
                            <div class="col-xs-12">
                                <div class="page-title-box">
                                    <h4 class="page-title">Accountant Dashboad </h4>
                                    <ol class="breadcrumb p-0 m-0">
                                        <li>
                                            <a href="#">Firmus Advisory</a>
                                        </li>
                                        <li>
                                            <a href="#">Dashboard </a>
                                        </li>
                                        <li class="active">
                                            Accountant
                                        </li>
                                    </ol>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->


                        <div class="row text-center">

                            <div class="col-lg-2 col-md-4 col-sm-6">
                                <div class="card-box widget-box-one">
                                    <div class="wigdet-one-content">
                                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow">Refunded Payments</p>
                                        <h2 class="text-danger"><span id="refundedPaymentStat" data-plugin="counterup">0</span></h2>
                                    </div>
                                </div>
                            </div><!-- end col -->

                            

                            <div class="col-lg-2 col-md-4 col-sm-6">
                                <div class="card-box widget-box-one">
                                    <div class="wigdet-one-content">
                                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow">Complete Payments</p>
                                        <h2 class="text-success"><span id="completePaymentStat" data-plugin="counterup">0</span></h2>
                                    </div>
                                </div>
                            </div><!-- end col -->

                            <div class="col-lg-2 col-md-4 col-sm-6">
                                <div class="card-box widget-box-one">
                                    <div class="wigdet-one-content">
                                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow">Pending Payments</p>
                                        <h2 class="text-warning"><span id="pendingPaymentStat" data-plugin="counterup">0</span> </h2>
                                    </div>
                                </div>
                            </div><!-- end col -->


                            <div class="col-lg-2 col-md-4 col-sm-6">
                                <div class="card-box widget-box-one">
                                    <div class="wigdet-one-content">
                                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow">Total Payments</p>
                                        <h2 class="text-dark"><span id="totalPaymentStat" data-plugin="counterup">0</span> </h2>
                                    </div>
                                </div>
                            </div><!-- end col -->

                            <div class="col-lg-2 col-md-4 col-sm-6">
                                <div class="card-box widget-box-one">
                                    <div class="wigdet-one-content">
                                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow">Total Jobs</p>
                                        <h2 class="text-dark"><span id="jobStat" data-plugin="counterup">0</span> </h2>
                                    </div>
                                </div>
                            </div><!-- end col -->

                            <div class="col-lg-2 col-md-4 col-sm-6">
                                <div class="card-box widget-box-one">
                                    <div class="wigdet-one-content">
                                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow">Contacts</p>
                                        <h2 class="text-danger"><span id="contactStat" data-plugin="counterup">0</span> </h2>
                                    </div>
                                </div>
                            </div><!-- end col -->

                        </div>

                        <style type="text/css">
                            #stages:hover{
                                cursor: pointer;
                            }
                        </style>

                        



                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card-box">
                                    <h4 class="header-title m-t-0 m-b-30">Last 3 months Payments</h4>

                                    <div id="website-stats" style="height: 320px;" class="flot-chart"></div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="card-box">
                                    <h4 class="header-title m-t-0">Pending, Declined and Completed Payments</h4>

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

                                    <p class="text-muted m-b-0 m-t-15 font-13 text-overflow">Pie chart shows the ratio of pending, declined and completed payments </p>
                                </div>
                            </div>

                        </div>
                        <!-- end row -->


                        




                        
                    </div> <!-- container -->


@endsection