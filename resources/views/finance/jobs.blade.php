@extends('finance.finance-template')
@section('finance')
<style type="text/css">
    table tr:hover{
        cursor: pointer;
    }
</style>

<div class="container">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="page-title-box">
                                    <h4 class="page-title">Jobs &amp; and their payments</h4>
                                    <ol class="breadcrumb p-0 m-0">
                                        
                                        <li>
                                            <a href="#">Firmus Advisory</a>
                                        </li>
                                        <li>
                                            <a href="#">Jobs</a>
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
                                    <h4 class="m-t-0 header-title"><b>All Jobs</b></h4>
                                    <p class="text-muted font-13 m-b-30">
                                        
                                    </p>

                                    <table id="datatable-buttons" class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Reference No</th>
                                            <th>Job Title</th>
                                            <th>Client</th>
                                            <th>Payment Status</th>
                                            <th>Job Cost</th>
                                            <th>Amount Paid</th>
                                            <th>Amount Deficit</th>
                                            <th>View Transactions</th>
                                            <th>Edit</th>
                                        </tr>
                                        </thead>


                                        <tbody>
                                            @foreach($job_requests as $job_request)
                                                <?php
                                                    $total_payed = DB::table('payment__transactions')->where('job_request_id', $job_request->job_request_id)->where('payment_status', '<>', 'REFUND')->sum('amount_paid');
                                                    $amount_deficit = DB::table('payment__transactions')->where('job_request_id', $job_request->job_request_id)->where('payment_status', 'REFUND')->sum('amount_paid');
                                                    $total_payed -= $amount_deficit;
                                                    $deficit = (double)$job_request->job_cost - $total_payed;
                                                ?>
                                                <tr id="job_pay{{$job_request->job_request_id}}">
                                                    <td id="reference_number">{{$job_request->reference_number}}</td>
                                                    <td id="job_title">{{ DB::table('jobs')->select('job_name')->where('job_id', $job_request->job_id)->first()->job_name}}</td>
                                                    <td id="client" >{{ DB::table('clients')->select('company_name')->where('client_id', $job_request->client_id)->first()->company_name}}</td>
                                                    <td id="payment_status">{{$job_request->status}}</td>
                                                    <td id="job_cost" style="display: none">{{$job_request->job_cost}}</td>
                                                    <td id="been_payed">{!!$total_payed!!}</td>
                                                    <td id="amount_deficit">{{$deficit}}</td>
                                                    @if($job_request->status != 'PENDING')
                                                    <td><button value="{{$job_request->reference_number}}" data-toggle="modal" data-target="#custom-width-modal3" id="viewTransactions" type="button" class=" viewTransactions btn btn-warning waves-effect" >View Transactions</button></td>
                                                    @else
                                                        <td><button type="button" class="btn btn-warning waves-effect" disabled>View Transactions</button></td>
                                                    @endif
                                                    <td><button id="makePayment" type="button" class="btn btn-success makePayment waves-effect" data-toggle="modal" data-target="#con-close-modal" value="job_pay{{$job_request->job_request_id}}">Update Payment</button></td>
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
                                                    <h4 class="modal-title">Job Payment Status</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="make_payment_form">
                                                        {{csrf_field()}}
                                                        <div class="row">
                                                        
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="field-1" class="control-label">Payment Status</label>
                                                                    <input type="text" name="payment_status" class="form-control" id="field-1" value="" readonly>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="field-1" class="control-label">Original Price</label>
                                                                    <input type="text" name="job_cost" class="form-control" id="total" value="" readonly>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="field-1" class="control-label">Paid Amount</label>
                                                                    <input type="text"  name="been_payed" class="form-control" id="payed" value="" readonly>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="field-1" class="control-label">Deficit Amount</label>
                                                                    <input type="text"  name="amount_deficit" class="form-control"  value="" readonly>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <section id="hideArea">
                                                                    <label for="field-1" class="control-label">New Payment</label>

                                                                    <input type="number" class="form-control" id="amount_paid" name="amount_paid" placeholder="Enter New Amount" style="margin-bottom: 10px;">
                                                                    <label for="field-1" class="control-label">Method of Payment</label>

                                                                    <input type="text" class="form-control" id="mode_of_payment" name="mode_of_payment" placeholder="Enter Mode of Payment" style="margin-bottom: 10px;">
                                                                    <label id="status_of_payment_label" for="field-1" class="control-label">Payment Status</label>

                                                                    <select type="text" id="status_of_payment" class="form-control" name="status_of_payment" placeholder="Enter New Payment Status" style="margin-bottom: 10px;">
                                                                        <option value=""> -- SELECT STATUS -- </option>
                                                                        {{--@if($job_request->status != 'PREFINANCED')--}}
                                                                            <option value="PREFINANCED" >PREFINANCED</option>
                                                                            <option value="REFUND" >REFUND</option>
                                                                        {{--@endif--}}
                                                                    </select>
                                                                    <label for="field-1" class="control-label">Payment Date</label>

                                                                    <input type="date" class="form-control" id="payment_date" name="payment_date" placeholder="Enter Payment Date" style="margin-bottom: 10px;">
                                                                    <label for="field-1" class="control-label">Payment Time</label>

                                                                    <input type="time" id="payment_time" class="form-control" name="payment_time" placeholder="Enter Payment Time" style="margin-bottom: 10px;">
                                                                    <label for="field-1" class="control-label">Remark</label>

                                                                        <textarea class="form-control" id="remark" name="remark" placeholder="Enter Remark" style="margin-bottom: 10px;"></textarea>
                                                                    <button type="button" class="btn btn-danger waves-effect waves-light" id="pay_btn" style="margin-top: 5px;">Pay</button>
                                                                    </section>

                                                                    <button type="button" onClick="displayNew()" id="updateBtn" class="btn btn-info waves-effect waves-light pull-right" style="margin-top: 5px;">Make Payment</button>
                                                                    
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="field-1" class="control-label">Reference No</label>
                                                                    <input name="reference_number" type="text" class="form-control" id="field-1" placeholder="FRMJOB-001239" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <div class="form-group">
                                                                    <label for="field-2" class="control-label">Job Title</label>
                                                                    <input name="job_title" type="text" class="form-control" id="field-1" placeholder="Business Registration" readonly>

                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="field-2" class="control-label">Client</label>
                                                                    <input type="text" class="form-control" id="field-1" placeholder="Nana Kwarteng" name="client" readonly>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                    
                                                    <style type="text/css">
                                                        #hideArea{
                                                            display: none;
                                                        }
                                                    </style>

                                                    <script type="text/javascript">
                                                        function displayNew(){

                                                            $('#hideArea').each(function(){
                                                                $(this).find(':input').val(" ");
                                                            });
                                                            
                                                            var hideArea = document.getElementById('hideArea');

                                                            var btn = document.getElementById('updateBtn');

                                                            if (hideArea.style.display == 'none') {
                                                                
                                                                hideArea.style.display = 'block';
                                                                btn.textContent = 'Cancel';
                                                            } else{
                                                                hideArea.style.display = 'none';
                                                                btn.textContent = 'Make Payment';
                                                            }
                                                        }
                                                    </script>
                                                    
                                                   
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.modal -->


                        <!-- End of About Job form -->
                                </div>
                            </div>
                            </div>
                            <div id="custom-width-modal3" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: hidden;">
                                <div class="col-md-8 col-md-offset-2">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            <h4 class="modal-title">Transactions</h4>
                                        </div>
                                        <div id="transactions_table" class="modal-body">

                                        </div>
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