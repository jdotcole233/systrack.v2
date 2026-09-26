@extends('employee.my-jobs-template')

@section('employee')
    <style>
        #job-modal .modal-dialog { width: 85%; max-width: 1100px; }
        @media (max-width: 767px) { #job-modal .modal-dialog { width: auto; margin: 10px; } }
        #job-modal .jm-stages-wrap { overflow-x: auto; padding: 10px 0 30px; }
        #jm-stages { margin: 0 auto; }
        #jm-stages li { cursor: default; }
        #jm-stages li.current:before { border-color: #f9c851; background: #fff8e6; }
        #jm-stage-label { min-height: 20px; }
    </style>

    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="page-title-box">
                    <h4 class="page-title">Assigned Jobs</h4>
                    <ol class="breadcrumb p-0 m-0">
                        <li><a href="#">Firmus Advisory</a></li>
                        <li><a href="#">Assigned Jobs</a></li>
                    </ol>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card-box table-responsive">
                    <h4 class="m-t-0 header-title"><b>Assigned Jobs</b></h4>

                    {{-- id kept as datatable-buttons so the layout's DataTables init still picks it up --}}
                    <table id="datatable-buttons" class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>Reference No</th>
                            <th>Job Title</th>
                            <th>Client</th>
                            <th>Assigned By</th>
                            <th>Applicant</th>
                            <th>Current Task</th>
                            <th>Assigned On</th>
                            <th>End Date</th>
                            <th>Renewal Date</th>
                            <th>Progress</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($jobs as $job)
                            <tr id="tab{{ $job['assignment_id'] }}" data-id="{{ $job['id'] }}">
                                <td>{{ $job['reference'] }}</td>
                                <td>{{ $job['job_name'] }}</td>
                                <td>{{ $job['client'] }}</td>
                                <td>{{ $job['assigned_by'] }}</td>
                                <td>{{ $job['applicant'] }}</td>
                                <td>
                                    @if ($job['current_task'])
                                        {{ $job['current_task']['name'] }}
                                        @if ($job['current_task']['status'])
                                            <br><small class="text-muted">{{ ucfirst($job['current_task']['status']) }}</small>
                                        @endif
                                    @elseif ($job['is_done'])
                                        <span class="label label-success">Done</span>
                                    @else
                                        <span class="text-muted">No tasks defined</span>
                                    @endif
                                </td>
                                <td data-order="{{ $job['assigned_on_sort'] }}">{{ $job['assigned_on'] }}</td>
                                <td>{{ $job['end_date'] ?? '—' }}</td>
                                <td>{{ $job['renewal_date'] ?? '—' }}</td>
                                <td>
                                    <button type="button"
                                            class="btn btn-primary btn-sm js-open-progress"
                                            data-job="{{ json_encode($job) }}"
                                            {{ $job['current_task'] ? '' : 'disabled' }}>
                                        Progress Update
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Progress modal --}}
    <div id="job-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="job-modal-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close close_clear" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="job-modal-title">About Job</h4>
                </div>

                <div class="modal-body">
                    {{-- Stage tracker: hover a stage to see its name and state --}}
                    <p id="jm-stage-label" class="text-center text-muted"></p>
                    <div class="jm-stages-wrap">
                        <ul id="jm-stages" class="progressbar"></ul>
                    </div>

                    {{-- Job details (read-only) --}}
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="jm-reference" class="control-label">Reference No</label>
                                <input id="jm-reference" type="text" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="jm-job-name" class="control-label">Job Title</label>
                                <input id="jm-job-name" type="text" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="jm-client" class="control-label">Client</label>
                                <input id="jm-client" type="text" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="jm-assignment-status" class="control-label">Assignment Status</label>
                                <input id="jm-assignment-status" type="text" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="jm-assigned-on" class="control-label">Assigned On</label>
                                <input id="jm-assigned-on" type="text" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="jm-applicant" class="control-label">Applicant</label>
                                <input id="jm-applicant" type="text" class="form-control" readonly>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" id="job_request_id">
                    <input type="hidden" id="job_request_id_details" name="job_request_id_de">

                    <hr>
                    <h4>Assigned Employee(s)</h4>
                    <div class="table-responsive">
                        <table id="jm-assignees" class="table table-striped"></table>
                    </div>

                    <hr>
                    <h4>Update Progress</h4>
                    <form id="job_task_completion_send">
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        <input type="hidden" name="task_id" id="current_task_id">
                        <input type="hidden" name="job_assignment_id" id="task_job_assignment_id">
                        <input type="hidden" name="job_request_id" id="current_task_form_job_request_id">
                        <input type="hidden" id="company_email">
                        <input type="hidden" id="client_remark">
                        <input type="hidden" name="renewal_date" id="renewal_date_o">

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="current_task_form" class="control-label">Current Task</label>
                                    <input id="current_task_form" type="text" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="field-5" class="control-label">Current Status</label>
                                    <select name="status" id="field-5" class="form-control" required>
                                        <option value="">-- Select current status --</option>
                                        <option value="in progress">In Progress</option>
                                        <option value="delayed">Delayed</option>
                                        <option value="cancelled">Cancelled</option>
                                        <option value="completed">Completed</option>
                                    </select>
                                </div>
                                {{-- Shown only on the final task, as before --}}
                                <div class="form-group" id="renewal1">
                                    <label for="renewal_date_proxy" class="control-label">Renewal Date</label>
                                    <input id="renewal_date_proxy" type="date" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="client_remarks" class="control-label">Status Remark</label>
                                    <textarea id="client_remarks" name="comments" class="form-control" rows="5" required></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="checkbox checkbox-primary">
                                <input id="send_email_notification" type="checkbox" name="send_email_notification" checked>
                                <label for="send_email_notification">Send Email Notification to Client</label>
                            </div>
                        </div>
                        <div id="email_section" class="form-group">
                            <input id="alt_email" name="alt_email" type="text" class="form-control"
                                   list="clientsEmail" placeholder="Enter alternative email (E.g. abcd@firmus.com)">
                            <datalist id="clientsEmail"></datalist>
                        </div>
                    </form>

                    <button id="sendTasksUpdate" class="btn btn-danger">Send</button>

                    <hr>
                    <h4>Feedback</h4>
                    <div id="message_stuff" style="height: 300px; overflow-y: auto; background: #f7f7f7; padding: 20px 10px 0; margin-bottom: 15px;">
                        <ul id="chat_messages" class="conversation-list"></ul>
                    </div>
                    <div class="form-group">
                        {{ csrf_field() }}
                        <label for="message" class="control-label">Update Progress</label>
                        <textarea id="message" class="form-control" rows="3" placeholder="Write remark or feedback here"></textarea>
                    </div>
                    <button type="button" id="post_message" class="btn btn-info waves-effect waves-light">Post</button>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect close_clear" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div id="loading_progress" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="margin-top: 40px;">
        <div class="modal-dialog">
            <div class="text-center"><img src="{{ asset('images/loader.gif') }}" alt="please wait"></div>
        </div>
    </div>

    <script src="{{ asset('js/employee-jobs.js') }}"></script>
@endsection