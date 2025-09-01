@extends('partner.admin.admin-template')
@section('admin')
<div class="container">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="page-title-box">
                                    <h4 class="page-title">SysTrack Tracking System</h4>
                                    <ol class="breadcrumb p-0 m-0">
                                        
                                        <li>
                                            <a href="#">Firmus Advisory</a>
                                        </li>
                                        <li>
                                            <a href="#">Administrator</a>
                                        </li>

                                    </ol>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->

                        <div class="row" style="margin-bottom: 20px;">
                            <div class="col-md-12">
                                
                                
                                
                                        
                            </div>
                        </div>


                        

                        

                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-sm-12">
                                <div class="card-box table-responsive">
                                    <h4 class="m-t-0 header-title"><b>All Activities</b></h4>
                                    <p class="text-muted font-13 m-b-30">
                                        
                                    </p>

                                    <table id="datatable-buttons" class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th>Employee Name</th>
                                            <th>Access point IP</th>
                                            <th>Access Application</th>
                                            <th>Country Code</th>
                                            <th>City</th>
                                            <th>Region</th>
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
											<td>{{$activity->user_agent}}</td>
											<td>{{$activity->country_code}}</td>
											<td>{{$activity->city_name}}</td>
											<td>{{$activity->region_name}}</td>
											<td>{{$activity->created_at}}</td>
										</tr>
										@endforeach                                        
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            </div>

                        </div>
                        <!-- end row -->




                    </div> <!-- container -->

@endsection