@extends('partner.manager.manager-template')
@section('manager')

                      <div class="row" style="margin-top: 20px;">
                        <div class="col-md-12">
                          <div class="col-sm-12">
                            <div class="card-box ">
                              <div class="row" style="margin-bottom: 20px;">
                              <!-- <form> -->
                                <meta name="csrf-token" content="{{csrf_token()}}">
                                <div class="container row">
                                  <div class="col-md-4">
                                          <label>Type of Job</label>
                                          <select class="form-control" id="job_selection_box">
                                            <option value="SJ"> SELECT JOB </option>
                                            <option value="allJobs"> ALL JOBS </option>
                                            @foreach(DB::table('jobs')->get() as $job)
                                             <option value="{{$job->job_id}}">{{$job->job_name}}</option>
                                            @endforeach
                                          </select>
                                  </div>

                                  <div class="col-md-4">
                                  <label>From</label>
                                    <input type="date" class="form-control" id="from_date" />
                                  </div>

                                  <div class="col-md-4">
                                          <label>To</label>
                                          <input type="date" class="form-control" id="to_date"/>
                                      </div>
                              <!-- </form> -->
                                      <div class="col-md-12">
                                          <div style="height: 20px;"></div>
                                          <button id="generate_report" class="btn-rounded btn-inverse waves-effect waves-light m-b-5 pull-right" ><span>Generate Report</span> </button>
                                      </div>
                                </div>





                                  <style type="text/css">
                                      table tr:hover{
                                          cursor: pointer;
                                      }
                                  </style>


                              </div>

                            </div>
                          </div>
                        </div>
                      </div>



                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-sm-12">
                                <div class="card-box table-responsive">
                                    <h4 class="m-t-0 header-title"><b>All Jobs</b></h4>
                                    <p class="text-muted font-13 m-b-30">

                                    </p>
                                    <table id="datatable-buttons" class="table table-striped table-bordered">
                                      <!-- datatable-buttons -->
                                        <thead>
                                        <tr>
                                            <th>Date of job logged in</th>
                                            <th>Type of job</th>
                                            <th>Client name</th>
                                            <th>Amount (GHS)</th>
                                            <!-- <th>Issued Date</th>
                                            <th>Expiry Date</th> -->
                                            <!-- <th>Total Amount (Ghs)</th> -->

                                        </tr>
                                        </thead>

                                        <tbody id="report_table">
                                          <!-- Generated reports goes here -->

                                        </tbody>
                                    </table>

                                </div>
                            </div>
                            </div>
                        </div>
                        <!-- end row -->
                        <div class="row">
                          <div class="col-md-12">
                            <div class="col-sm-12">
                              <div class="card-box ">
                                <div class="col-sm-4">

                                  </div>
                                  <div class="col-sm-4">

                                  </div>
                                  <div class="col-sm-4">
                                      <h4 class="m-t-0 header-title pull-right" id="total_output"></h4>
                                  </div>
                              </div>
                            </div>
                          </div>
                        </div>




                    </div> <!-- container -->





<div id="loading_progress" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none; margin-top: 40px;">
        <div class="modal-dialog">
            <center>
                <img src="{{asset('images/loader.gif')}}" alt="please wait">
            </center>
        </div>

    </div><!-- /.modal -->



                    <!-- End of section -->

                </div> <!-- content -->

                <footer class="footer text-right">
                     ©2017 Firmus Advisory
                </footer>

            </div>


            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->



        </div>
        <!-- END wrapper -->
                @endsection
