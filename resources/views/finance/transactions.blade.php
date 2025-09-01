<div class="row">
    <div class="col-md-12">
        <div class="col-sm-12">
            <div class="card-box table-responsive">
                <h4 class="m-t-0 header-title"><b>All Job Types</b></h4>
                <p class="text-muted font-13 m-b-30">

                </p>
                 <table id="datatable-buttons" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Reference No</th>
                        <th>Payment Status</th>
                        <th>Amount Paid</th>
                        <th>Amount Deficit</th>
                        <th>Payment Date</th>
                        <th>Payment Time</th>
                        <th>Mode of Payment</th>
                        <th>Remark</th>
                    </tr>
                    </thead>


                    <tbody>
                    @foreach($transactions as $transaction)
                        <tr>
                        <td>{{DB::table('job__requests')->where('job_request_id', $transaction->job_request_id)->value('reference_number')}}</td>
                        <td>{{$transaction->payment_status}}</td>
                        {{--<td>{{}}</td>--}}
                        <td>{{$transaction->amount_paid}}</td>
                        <td>{{$transaction->amount_deficit}}</td>
                        <td>{{$transaction->payment_date}}</td>
                        <td>{{$transaction->payment_time}}</td>
                        <td>{{$transaction->mode_of_payment}}</td>
                        <td>{{$transaction->remark}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>