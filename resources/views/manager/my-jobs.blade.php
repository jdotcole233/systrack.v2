@extends('partner.manager.manager-template')
@section('manager')
    <style type="text/css">
        table tr:hover {
            cursor: pointer;
        }
    </style>

    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="page-title-box">
                    <h4 class="page-title">My Jobs</h4>
                    <ol class="breadcrumb p-0 m-0">

                        <li>
                            <a href="#">Firmus Advisory</a>
                        </li>
                        <li>
                            <a href="#">My Jobs</a>
                        </li>

                    </ol>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <!-- end row -->

        <div class="row" style="margin-bottom: 20px;">

            <div class="col-md-12">
                <div class="col-md-12" style="border: 2px solid #f3f3f3; padding-top: 10px; padding-bottom: 10px;">
                    <div class="form-group">
                        <label for="range_06" class="col-sm-2 control-label"><b>Current Job Progress</b><span
                                class="font-normal text-muted f-s-12 clearfix"><!-- Using any strings as values --></span></label>
                        <div class="col-md-12">
                            <span class="irs js-irs-5 irs-with-grid"><span class="irs"><span class="irs-line"
                                        tabindex="-1"><span class="irs-line-left"></span><span
                                            class="irs-line-mid"></span><span class="irs-line-right"></span></span><span
                                        class="irs-min" style="visibility: visible;">Stage 1</span><span class="irs-max"
                                        style="visibility: visible;">Stage 10</span><span class="irs-from"
                                        style="visibility: hidden;">0</span><span class="irs-to"
                                        style="visibility: hidden;">0</span><span class="irs-single"
                                        style="left: 43.0174%;">Stage 5</span></span><span class="irs-grid"
                                    style="width: 98.2704%; left: 0.76478%;"><span class="irs-grid-pol"
                                        style="left: 0%"></span><span class="irs-grid-text js-grid-text-0"
                                        style="left: 0%; margin-left: -3.14465%;">Stage 1</span><span
                                        class="irs-grid-pol small" style="left: 6.060606061%"></span><span
                                        class="irs-grid-pol small" style="left: 3.03030303%"></span><span
                                        class="irs-grid-pol" style="left: 9.090909091%"></span><span
                                        class="irs-grid-text js-grid-text-1"
                                        style="left: 9.09091%; visibility: visible; margin-left: -3.45912%;">Stage
                                        2</span><span class="irs-grid-pol small" style="left: 15.151515152%"></span><span
                                        class="irs-grid-pol small" style="left: 12.121212121%"></span><span
                                        class="irs-grid-pol" style="left: 18.181818182%"></span><span
                                        class="irs-grid-text js-grid-text-2"
                                        style="left: 18.1818%; visibility: visible; margin-left: -2.67296%;">Stage
                                        3</span><span class="irs-grid-pol small" style="left: 24.242424243%"></span><span
                                        class="irs-grid-pol small" style="left: 21.212121212%"></span><span
                                        class="irs-grid-pol" style="left: 27.272727273%"></span><span
                                        class="irs-grid-text js-grid-text-3"
                                        style="left: 27.2727%; visibility: visible; margin-left: -2.12264%;">Stage
                                        4</span><span class="irs-grid-pol small" style="left: 33.333333334%"></span><span
                                        class="irs-grid-pol small" style="left: 30.303030303%"></span><span
                                        class="irs-grid-pol" style="left: 36.363636364%"></span><span
                                        class="irs-grid-text js-grid-text-4"
                                        style="left: 36.3636%; margin-left: -1.96541%;">Stage 5</span><span
                                        class="irs-grid-pol small" style="left: 42.424242425%"></span><span
                                        class="irs-grid-pol small" style="left: 39.393939394%"></span><span
                                        class="irs-grid-pol" style="left: 45.454545455%"></span><span
                                        class="irs-grid-text js-grid-text-5"
                                        style="left: 45.4545%; visibility: visible; margin-left: -2.04403%;">Stage
                                        6</span><span class="irs-grid-pol small" style="left: 51.515151516%"></span><span
                                        class="irs-grid-pol small" style="left: 48.484848485%"></span><span
                                        class="irs-grid-pol" style="left: 54.545454546%"></span><span
                                        class="irs-grid-text js-grid-text-6"
                                        style="left: 54.5455%; visibility: visible; margin-left: -1.72956%;">Stage
                                        7</span><span class="irs-grid-pol small" style="left: 60.606060607%"></span><span
                                        class="irs-grid-pol small" style="left: 57.575757576%"></span><span
                                        class="irs-grid-pol" style="left: 63.636363637%"></span><span
                                        class="irs-grid-text js-grid-text-7"
                                        style="left: 63.6364%; visibility: visible; margin-left: -2.90881%;">Stage
                                        8</span><span class="irs-grid-pol small" style="left: 69.696969698%"></span><span
                                        class="irs-grid-pol small" style="left: 66.666666667%"></span><span
                                        class="irs-grid-pol" style="left: 72.727272728%"></span><span
                                        class="irs-grid-text js-grid-text-8"
                                        style="left: 72.7273%; margin-left: -4.16667%;">Stage 9</span><span
                                        class="irs-grid-pol small" style="left: 78.787878789%"></span><span
                                        class="irs-grid-pol small" style="left: 75.757575758%"></span><span
                                        class="irs-grid-pol" style="left: 81.818181819%"></span><span
                                        class="irs-grid-text js-grid-text-9"
                                        style="left: 81.8182%; visibility: visible; margin-left: -3.22327%;">Stage
                                        10</span><span class="irs-grid-pol small" style="left: 87.87878788%"></span><span
                                        class="irs-grid-pol small" style="left: 84.848484849%"></span><span
                                        class="irs-grid-pol" style="left: 90.90909091%"></span><span
                                        class="irs-grid-text js-grid-text-10"
                                        style="left: 90.9091%; visibility: visible; margin-left: -3.93082%;">November</span><span
                                        class="irs-grid-pol" style="left: 100%"></span><span
                                        class="irs-grid-text js-grid-text-11"
                                        style="left: 100%; visibility: visible; margin-left: -3.93082%;">December</span></span><span
                                    class="irs-bar" style="left: 0.86478%; width: 44.6684%;"></span><span
                                    class="irs-bar-edge"></span><span class="irs-shadow shadow-single"
                                    style="display: none;"></span><span class="irs-slider single"
                                    style="left: 44.6684%;"></span></span><!-- <input type="text" id="range_06" class="irs-hidden-input" readonly=""> -->
                        </div>
                    </div>
                </div>
            </div>



        </div>





        <div class="row">
            <div class="col-md-12">
                <div class="col-sm-12">
                    <div class="card-box table-responsive">
                        <h4 class="m-t-0 header-title"><b>My Jobs</b></h4>
                        <p class="text-muted font-13 m-b-30">

                        </p>

                        <table id="datatable-buttons" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Reference No</th>
                                    <th>Job Title</th>
                                    <th>Client</th>
                                    <th>Status</th>
                                    <th>Start date</th>
                                    <th>End date</th>
                                    <th>Progress</th>
                                </tr>
                            </thead>


                            <tbody>
                                <tr data-toggle="modal" data-target="#con-close-modal">
                                    <td>FRMJOB-001239</td>
                                    <td>Business Operating Permit</td>
                                    <td>Cole Baidoo</td>
                                    <td>Pending</td>
                                    <td>2017/12/16</td>
                                    <td>2018/12/16</td>
                                    <td>
                                        <div class="progress-lg">
                                            <div class="progress-bar progress-bar-danger progress-bar-striped active"
                                                role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"
                                                style="width: 60%;">
                                                <span class=".sr-only">60% Complete</span>
                                            </div>
                                        </div>
                                    </td>

                                </tr>

                                <tr>
                                    <td>FRMJOB-001239</td>
                                    <td>Business Operating Permit</td>
                                    <td>Cole Baidoo</td>
                                    <td>Completed</td>
                                    <td>2017/12/16</td>
                                    <td>2018/12/16</td>
                                    <td>
                                        <div class="progress-lg">
                                            <div class="progress-bar progress-bar-info" role="progressbar"
                                                aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"
                                                style="width: 100%;">
                                                <span class=".sr-only">100% Complete</span>
                                            </div>
                                        </div>
                                    </td>

                                </tr>

                                <tr>
                                    <td>FRMJOB-001239</td>
                                    <td>Business Operating Permit</td>
                                    <td>Cole Baidoo</td>
                                    <td>Completed</td>
                                    <td>2017/12/16</td>
                                    <td>2018/12/16</td>
                                    <td>
                                        <div class="progress-lg">
                                            <div class="progress-bar progress-bar-info" role="progressbar"
                                                aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"
                                                style="width: 100%;">
                                                <span class=".sr-only">100% Complete</span>
                                            </div>
                                        </div>
                                    </td>

                                </tr>

                                <tr>
                                    <td>FRMJOB-001239</td>
                                    <td>Business Operating Permit</td>
                                    <td>Cole Baidoo</td>
                                    <td>Completed</td>
                                    <td>2017/12/16</td>
                                    <td>2018/12/16</td>
                                    <td>
                                        <div class="progress-lg">
                                            <div class="progress-bar progress-bar-info" role="progressbar"
                                                aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"
                                                style="width: 100%;">
                                                <span class=".sr-only">100% Complete</span>
                                            </div>
                                        </div>
                                    </td>

                                </tr>

                                <tr>
                                    <td>FRMJOB-001239</td>
                                    <td>Business Operating Permit</td>
                                    <td>Cole Baidoo</td>
                                    <td>Completed</td>
                                    <td>2017/12/16</td>
                                    <td>2018/12/16</td>
                                    <td>
                                        <div class="progress-lg">
                                            <div class="progress-bar progress-bar-info" role="progressbar"
                                                aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"
                                                style="width: 100%;">
                                                <span class=".sr-only">100% Complete</span>
                                            </div>
                                        </div>
                                    </td>

                                </tr>



                            </tbody>
                        </table>

                        <!--  About Job Modal -->

                        <div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog"
                            aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-hidden="true">×</button>
                                        <h4 class="modal-title">About Job</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="field-1" class="control-label">Job Progress</label>
                                                    <div class="progress-lg form-control" style="border: none;">
                                                        <div class="progress-bar progress-bar-danger" role="progressbar"
                                                            aria-valuenow="60" aria-valuemin="0" aria-valuemax="60"
                                                            style="width: 60%;">
                                                            <span class=".sr-only">60% Complete</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="field-1" class="control-label">Reference No</label>
                                                        <input type="text" class="form-control" id="field-1"
                                                            placeholder="FRMJOB-001239" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label for="field-2" class="control-label">Job Title</label>
                                                        <select class="form-control" disabled>
                                                            <option>Business Registration</option>
                                                            <option>Amendment at RGD</option>
                                                            <option>GIPC Renewal</option>
                                                            <option>GIPC Registration</option>
                                                            <option>GIPC Quota Application</option>
                                                            <option>Registraion for Business Operating Permit</option>
                                                            <option>Quota Replacement</option>
                                                            <option>Work/Residence Permit</option>
                                                            <option> Visa on Arrival or Emergency Entry Visa</option>
                                                            <option>Visa Extension</option>
                                                            <option>Single Re-entry/Multiple Re-entry</option>
                                                            <option>Confirmation of Departure</option>
                                                            <option>Residence Permit (Student.Dependent)</option>
                                                            <option>GRA Registration</option>
                                                            <option>TCC Application</option>
                                                            <option>SSNIT Registration - ER Number</option>
                                                            <option>SSNIT Clearance</option>
                                                            <option>Food and Drugs Registration</option>
                                                            <option>Free Zones Registration</option>
                                                            <option>Registration for Manufacturing License</option>
                                                            <option>Registration for Export License</option>
                                                            <option>Tourism Permit</option>
                                                            <option>EPA Permit</option>
                                                            <option>Mining License</option>
                                                            <option>Oil and Gas - Petroleum License</option>
                                                            <option>Board Meeting</option>
                                                            <option>Annual General Meeting</option>





                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="field-2" class="control-label">Client</label>
                                                        <select class="form-control" disabled>
                                                            <option>James Arthur</option>
                                                            <option>Nelly Whyte</option>
                                                            <option>Kenneth Progress</option>
                                                            <option>Nana Kwarteng</option>

                                                        </select>

                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="field-2" class="control-label">Assign Task to</label>
                                                        <select class="form-control" disabled>
                                                            <option>Kassim Balogun</option>
                                                            <option>Cole Baidoo</option>
                                                            <option>Jasmine Amo Bempah</option>
                                                            <option>Peter Peregbakumo</option>

                                                        </select>

                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="field-2" class="control-label">Start Date</label>
                                                        <input type="text" class="form-control" value="15/12/2017"
                                                            id="field-2" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="field-2" class="control-label">Expected End Date</label>
                                                        <input type="text" class="form-control" value="15/02/2018"
                                                            id="field-2" disabled>
                                                    </div>
                                                </div>


                                            </div>


                                            <div class="row">
                                                <div class="col-md-12">

                                                    <div class="form-group no-margin">
                                                        <label for="field-7" class="control-label">Comments</label>
                                                        <ul class="conversation-list slimscroll-alt"
                                                            style="height: 250px; min-height: 332px; overflow: hidden; width: auto;">


                                                            <li class="clearfix">
                                                                <div class="chat-avatar">
                                                                    <span class="avatar-sm-box bg-success">K</span>
                                                                    <i>10:00</i>
                                                                </div>
                                                                <div class="conversation-text">
                                                                    <div class="ctext-wrap">
                                                                        <i>Kassim Balogun</i>
                                                                        <p>
                                                                            Just contacted immigration office for the
                                                                            approval
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li class="clearfix odd">
                                                                <div class="chat-avatar">
                                                                    <span class="avatar-sm-box bg-success">C</span>
                                                                    <i>10:01</i>
                                                                </div>
                                                                <div class="conversation-text">
                                                                    <div class="ctext-wrap">
                                                                        <i>Cole Baidoo</i>
                                                                        <p>
                                                                            That's great, let me know as soon as they
                                                                            respond. But for the main time, can you contact
                                                                            the client to send a most recent passport
                                                                            picture?
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li class="clearfix">
                                                                <div class="chat-avatar">
                                                                    <span class="avatar-sm-box bg-success">K</span>

                                                                    <i>10:01</i>
                                                                </div>
                                                                <div class="conversation-text">
                                                                    <div class="ctext-wrap">
                                                                        <i>Kassim Balogun</i>
                                                                        <p>
                                                                            Yes boss, I'm on it.
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li class="clearfix odd">
                                                                <div class="chat-avatar">
                                                                    <span class="avatar-sm-box bg-success">C</span>

                                                                    <i>10:02</i>
                                                                </div>
                                                                <div class="conversation-text">
                                                                    <div class="ctext-wrap">
                                                                        <i>Cole Baidoo</i>
                                                                        <p>
                                                                            Great!
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group no-margin">
                                                        <label for="field-7" class="control-label">Update Progress</label>
                                                        <textarea class="form-control autogrow" id="field-7"
                                                            placeholder="Write remark or feedback here"
                                                            style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 104px;"></textarea>
                                                        <button type="button" class="btn btn-info waves-effect waves-light"
                                                            style="margin-top: 5px;">Post</button>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default waves-effect"
                                                data-dismiss="modal">Close</button>

                                        </div>
                                    </div>
                                </div>
                            </div><!-- /.modal -->


                            <!-- End of About Job form -->
                        </div>
                    </div>
                </div>

            </div>
            <!-- end row -->


        </div> <!-- container -->

        <div id="loading_progress" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true" style="display: none; margin-top: 40px;">
            <div class="modal-dialog">
                <center>
                    <img src="{{asset('images/loader.gif')}}" alt="please wait">
                </center>
            </div>

        </div><!-- /.modal -->
@endsection