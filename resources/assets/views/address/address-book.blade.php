@extends('address.address-book-template')
@section('address')


    <!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-lite.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-lite.js"></script>
    <style type="text/css">
        .table-responsivee:not(.no-effect) table {
            overflow-y:scroll;
            height:350px;
            display:block;
        }
    </style>
    <style>
        .loader {
          border: 16px solid #f3f3f3;
          border-radius: 50%;
          border-top: 16px solid #3498db;
          width: 120px;
          height: 120px;
          -webkit-animation: spin 2s linear infinite; /* Safari */
          animation: spin 2s linear infinite;
        }

        /* Safari */
        @-webkit-keyframes spin {
          0% { -webkit-transform: rotate(0deg); }
          100% { -webkit-transform: rotate(360deg); }
        }

        @keyframes spin {
          0% { transform: rotate(0deg); }
          100% { transform: rotate(360deg); }
        }
    </style>

    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="page-title-box">
                    <h4 class="page-title">Address Book</h4>
                    <ol class="breadcrumb p-0 m-0">
                        <li>
                            <a href="#">Firmus Advisory</a>
                        </li>
                        <li>
                            <a href="#">Address Book</a>
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



        <div class="row" style="margin-bottom: 20px;">
            <div class="col-md-12">

                <button class="add_firm_contact btn-rounded btn-inverse waves-effect waves-light m-b-5 pull-right" > <i class="fa fa-plus-circle m-r-5"></i> <span>Add Contact</span> </button>

            </div>
        </div>

        <!-- Create New Contact form -->

        <div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">Add New Contact</h4>
                    </div>
                    <div class="modal-body">
                        <form id="cont_forms">
                            <meta name="csrf-token" content="{{csrf_token()}}">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="field-1" class="control-label">Contact Name</label>
                                        <input type="text" class="form-control" name="contact_name" id="contact_name" placeholder="Full Name" required>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="field-2" class="control-label">Organization</label>
                                        <input type="text" class="form-control" name="organization" id="organization" placeholder="Firmus Advisory">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-2" class="control-label">Position</label>
                                        <input type="text" class="form-control" name="position" id="position" placeholder="CEO" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="field-2" class="control-label">Email</label>
                                        <input type="email" class="form-control" name="email" id="email" placeholder="Email" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="field-2" class="control-label">Phone</label>
                                        <input type="text" class="form-control" name="contact_number" id="contact_number" placeholder="Phone Number" required>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="field-2" class="control-label">Website</label>
                                        <input type="text" class="form-control" name="Website" id="Website" placeholder="http://www.firmusadvisory.com">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="field-3" class="control-label">Remarks</label>
                                        <textarea class="form-control autogrow" name="contact_remarks" id="contact_remarks" placeholder="Contact Remarks" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 64px;"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="field-3" class="control-label">Address</label>
                                        <textarea class="form-control autogrow" name="address" id="address" placeholder="Address or Location" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 104px;"></textarea>
                                    </div>
                                </div>
                            </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="close_cont btn btn-default waves-effect" data-dismiss="modal">Close</button>
                     <button type="button" class="btn btn-info waves-effect waves-light " id="save_con">Save Contact</button>

                    </div>
                    </form>
                    <button id="" class="update_con btn btn-info waves-effect waves-light"  style="display: none;" >Update Contact</button>
                </div>
            </div>
        </div><!-- /.modal -->


        <!-- End of Address Book form -->





        <style type="text/css">
            table tr:hover{
                cursor: pointer;
            }
        </style>





        <div class="col-lg-5">
            <div class="card-box">
                <h4 class="header-title m-t-0 m-b-30">New Contacts</h4>

                <div class="table-responsivee">
                    <table class="table table table-hover m-0">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Full Name</th>
                            <th>Organization</th>
                            <th>Phone</th>
                            <th>Date</th>
                            <th>View</th>

                        </tr>
                        </thead>
                        <tbody>
                        @if(count($current_contact) > 0)
                            @foreach($current_contact as $contact)
                                <tr  >
                                    <th>
                                        <?php $avt = str_split($contact->contact_name); ?>
                                        <span class="avatar-sm-box bg-success"> {{ ucfirst($avt[0]) }}</span>
                                    </th>
                                    <td>
                                        <h5 class="m-0">{{$contact->contact_name}}</h5>
                                        <p class="m-0 text-muted font-13"><small>{{$contact->position}}</small></p>
                                    </td>
                                    <td>{{$contact->organization}}</td>
                                    <td>{{$contact->contact_number}}</td>
                                    <td>{{$contact->created_at}}</td>
                                    <td><button data-toggle="modal" data-target="#con-close-modal2" class="view_contact_current btn btn-warning" value="{{$contact->contact_id}}">View</button></td>
                                    <input type="hidden" name="id" value="{{$contact->id}}">
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>

                </div> <!-- table-responsive -->
            </div> <!-- end card -->
        </div>
        <!-- end col -->



        <!-- Contact Details-->

        <div id="con-close-modal2" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">Contact Details</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="field-1" class="control-label">Contact Name</label>
                                    <input type="text" class="form-control" id="contact_name_det" value="Kassim" disabled>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="field-2" class="control-label">Organization</label>
                                    <input type="text" class="form-control" placeholder="No organization" id="contact_organization" disabled>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="field-2" class="control-label">Position</label>
                                    <input type="text" class="form-control" id="contact_position" value="CEO" disabled>
                                </div>
                            </div>
                            <section id="hideArea1" style="display: block;">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="field-2" class="control-label">Email</label>
                                        <input type="text" class="form-control"  id="contact_email" placeholder="no email" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="field-2" class="control-label">Phone</label>
                                        <input type="text" class="form-control" id="contact_phone" value="+233269056851" disabled>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="field-2" class="control-label">Website</label>
                                        <input type="text" placeholder="No Website" class="form-control" id="contact_website_det" value="http://www.firmusadvisory.com" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="field-2" class="control-label">Date</label>
                                        <input type="text" class="form-control" id="contact_date" value="15/12/2017" disabled>
                                    </div>
                                </div>



                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="field-3" class="control-label">Address</label>
                                            <textarea class="form-control autogrow" id="contact_address" placeholder="No Contact Address" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 104px;" name="contact_address" disabled></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="field-3" class="control-label">Contact Remark</label>
                                            <textarea class="form-control autogrow" placeholder="No Contact Remark" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 104px;" id="cont_remarks" name="contact_remarks" disabled></textarea>
                                        </div>
                                    </div>
                                </div>

                            </section>

                            <div id="hideArea2" style="display: none;">
                                <div class="col-md-12">
                                    <div class="form-group no-margin">
                                        <label for="field-7" class="control-label">Send Message</label>
                                        <input type="text" class="form-control" id="subject" placeholder="Subject" style="margin-bottom: 5px; background-color: #fff;  color: #000;">
                                        <textarea class="form-control autogrow" name="content" id="summernote"></textarea>

                                    <!-- <div id="summernote"></div> -->

                                <script type="text/javascript">
                                    $('#summernote').summernote({
                                        placeholder: 'Enter message',
                                        tabsize: 2,
                                        height: 100
                                      });
                                </script>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="hidden" id="emp_id" value="{{Auth::user()->emp_id}}">
                                                <button type="button" id="sendMail" class="btn-rounded btn-info waves-effect waves-light" style="margin-top: 5px;">
                                                    <span id="loading"><i class="fa fa-spinner fa-spin"></i>Sending....</span><span id="send_text">Send Message</span></button>

                                            </div>
                                            <div class="col-md-6">
                                                <select class="form-control btn-info" id="choice">
                                                    <option>Email &amp; SMS</option>
                                                    <option value="Email">Email</option>
                                                    <option value="SMS">SMS</option>

                                                </select>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>




                    </div>
                    <div class="modal-footer">
                        <button type="button" id="close_messages" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                        <button type="button" id="switchBtn" class="btn btn-info waves-effect waves-light" onClick="displayMessageForm()">Send Message</button>

                    </div>
                </div>
            </div>
        </div><!-- /.modal -->



        <script type="text/javascript">




            function displayMessageForm(){
                var mainFields = document.getElementById('hideArea1');
                var messageFields = document.getElementById('hideArea2');

                var btn = document.getElementById('switchBtn');

                if (messageFields.style.display == 'none') {
                    mainFields.style.display = 'none';
                    messageFields.style.display = 'block';
                    btn.textContent = 'Go Back';
                } else{
                    mainFields.style.display = 'block';
                    messageFields.style.display = 'none';
                    btn.textContent = 'Send Message';
                    document.getElementById('send_text').textContent = 'Send Message';
                    $('.note-editable').html('');
                    $('#subject').val('');
                }



            }



        </script>


        <div class="col-sm-12">
            <!-- Peter i removed table-responsive from the  card-box class-->
            <div class="card-box ">

                <h4 class="m-t-0 header-title"><b>Contacts</b></h4>
                <p class="text-muted font-13 m-b-30">
                    <!-- // -->
                </p>

                <table id="datatable-buttons"
                       class="table table-striped table-bordered dt-responsive nowrap contactTable" cellspacing="0"
                       width="100%">
                    <thead>
                    <tr>
                        <th>Contact name</th>
                        <th>Position</th>
                        <th>Organization</th>
                        <!-- <th>Phone</th> -->
                        <!-- <th>E-mail</th>
                        <th>Wesite</th>
                        <th>Address</th> -->
                        <th>View</th>
                        <th>Edit</th>
                        <!-- <th>Delete</th> -->
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($job_contacts) > 0)
                        @foreach($job_contacts as $contact)
                            <tr id="cont_info{{$contact->contact_id}}">
                                <td>{{$contact->contact_name}}</td>
                                <td>{{$contact->position}}</td>
                                <td>{{$contact->organization}}</td>
                                <!-- <td>{{$contact->contact_number}}</td> -->
                                <!-- <td>{{$contact->email}}</td>
                                <td>{{$contact->website}}</td>
                                <td>{{$contact->address}}</td> -->
                                <td><button data-toggle="modal" data-target="#con-close-modal2" class="view_contact btn btn-warning" value="{{$contact->contact_id}}">View</button></td>
                                <td><button class="edit_cont_firm btn btn-primary" value="{{$contact->contact_id}}">Edit Contact</button></td>
                                <!-- <td>
                                    <meta name="csrf-token" content="{{csrf_token()}}">
                                    <button class="del_cont_firm  btn btn-danger" value="{{$contact->contact_id}}">Delete Contact</button>
                                </td> -->

                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
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
@endsection



{{--<script type="text/javascript" src="{{ asset('assets/js/firm_data_handler.js')}}"></script>--}}
{{--<script src="{{ asset('js/crud.js') }}"></script>--}}
