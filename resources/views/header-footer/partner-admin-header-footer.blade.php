<!DOCTYPE html>
<html>

<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="The best system to track job status and flow in firmus advisory">
        <meta name="author" content="Coderthemes">
        <meta name="csrf_token" content="{{csrf_token()}}">
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('/assets/images/favicon.ico') }}">
        <!-- App title -->
        <title>Firmus Advisory - Partner Admin</title>

        <!--Morris Chart CSS -->
        <link rel="stylesheet" href="{{ asset('/plugins/morris/morris.css') }}">

        <!-- DataTables -->
        <link href="{{ asset('/plugins/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('plugins/datatables/buttons.bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('plugins/datatables/fixedHeader.bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('plugins/datatables/responsive.bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('plugins/datatables/scroller.bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('plugins/datatables/dataTables.colVis.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('plugins/datatables/dataTables.bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('plugins/datatables/fixedColumns.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>

        <!-- App css -->
        <link href="{{ asset('/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('/assets/css/core.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('/assets/css/components.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('/assets/css/icons.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('/assets/css/pages.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('/assets/css/menu.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('/assets/css/responsive.css') }}" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="{{ asset('/plugins/switchery/switchery.min.css') }}">

    <link href="{{ asset('/css/stylee.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/css/loading_progress.css') }}" rel="stylesheet" type="text/css" />


        <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <script src="{{ asset('assets/js/modernizr.min.js') }}"></script>


    </head>


    <body class="fixed-left">

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Top Bar Start -->
            <div class="topbar">

                <!-- LOGO -->
                <div class="topbar-left" style="background-color: #f3f3f3;">
                    <a href="{{ url('/') }}" class="logo" id="lo1"><span style="color: #36404e;">FIRMUS-<span>SYSTRACK</span></span><i class="mdi mdi-layers"></i></a>
                    <!-- <a href="index.html" class="logo">
                        <span>
                            <img src="{{ asset('assets/images/logo.png') }}" alt="" height="50">
                        </span>
                        <i>
                            <img src="{{ asset('assets/images/logo_sm.png') }}" alt="" height="48">
                        </i>
                    </a> -->
                </div>

                <!-- Button mobile view to collapse sidebar menu -->
                <div class="navbar navbar-default" role="navigation">
                    <div class="container">

                        <!-- Navbar-left -->
                        <ul class="nav navbar-nav navbar-left">
                            <li>
                                <button class="button-menu-mobile open-left waves-effect">
                                    <i class="mdi mdi-menu"></i>
                                </button>
                            </li>



                        </ul>

                        <!-- Right(Notification) -->
                        <ul class="nav navbar-nav navbar-right">
                            <li>
                                <a href="#" class="right-menu-item dropdown-toggle" data-toggle="dropdown">
                                    <i class="mdi mdi-bell"></i>
                                    <span id="countNotificationbadge" class="badge up bg-success">0</span>
                                </a>

                                <ul class="dropdown-menu dropdown-menu-right arrow-dropdown-menu arrow-menu-right dropdown-lg user-list notify-list">
                                    <li>
                                        <h5>Notifications</h5>
                                    </li>
                                    <li>
                                        <a href="#" class="user-list-item">
                                            <div class="icon bg-info">
                                                <i class="mdi mdi-account"></i>
                                            </div>
                                            <div class="user-desc">
                                                <span class="name">New Signup</span>
                                                <span class="time">5 hours ago</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="user-list-item">
                                            <div class="icon bg-danger">
                                                <i class="mdi mdi-comment"></i>
                                            </div>
                                            <div class="user-desc">
                                                <span class="name">New Message received</span>
                                                <span class="time">1 day ago</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="user-list-item">
                                            <div class="icon bg-warning">
                                                <i class="mdi mdi-settings"></i>
                                            </div>
                                            <div class="user-desc">
                                                <span class="name">Settings</span>
                                                <span class="time">1 day ago</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="all-msgs text-center">
                                        <p class="m-0"><a href="#">See all Notification</a></p>
                                    </li>
                                </ul>
                            </li>




                            <li class="dropdown user-box">
                                <a href="#" class="dropdown-toggle waves-effect user-link" data-toggle="dropdown" aria-expanded="true">
                                  @if(Auth::check())
                                    <img src="{{ asset('/images/profile_photo/'.App\Models\Employee::where('emp_id', Auth::user()->emp_id)->value('profile_pic')) }}" alt="user-img" class="img-circle user-img">
                                </a>

                                <ul class="dropdown-menu dropdown-menu-right arrow-dropdown-menu arrow-menu-right user-list notify-list">
                                    <li>
                                        <h5>Hi, {{DB::table('employees')->where('emp_id', Auth::user()->emp_id)->value('first_name')}}</h5>
                                    </li>
                                    <li id="profile_details" value="{{Auth::user()->emp_id}}"><a href="{{ url('/profile/partner-admin') }}"><i class="ti-user m-r-5"></i> Profile</a></li>
                                    @endif
                                    <li><a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                              //  alert('Hello');
                                                     document.getElementById('logout-form').submit();"><i class="ti-power-off m-r-5"></i>
                                            Logout
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form></li>
                                </ul>
                            </li>

                        </ul> <!-- end navbar-right -->

                    </div><!-- end container -->
                </div><!-- end navbar -->
            </div>
            <!-- Top Bar End -->


            <!-- ========== Left Sidebar Start ========== -->
            <div class="left side-menu">
                <div class="sidebar-inner slimscrollleft">

                    <!--- Sidemenu -->
                    <div id="sidebar-menu">
                        <!-- <ul>
                            <li>
                                <a href="calendar.html" class="waves-effect"><i class="fa fa-plus"></i><span> ADD JOB </span></a>
                            </li>
                        </ul> -->
                        <ul>
                            <li class="menu-title">Navigation</li>

                            <li class="has_sub">
                                <a href="{{ url('/admin/home/partner-admin') }}" class="waves-effect"><i class="mdi mdi-view-dashboard"></i><span id="countNotification" class="label label-success pull-right">0</span> <span> Home </span> </a>

                            </li>

                            <li>
                                <a href="{{ url('/admin/employees/partner-admin') }}" class="waves-effect"><i class="fa fa-users"></i><span> Employees </span></a>
                            </li>
                            <li>
                                <a href="{{ url('/address-book/partner-admin') }}" class="waves-effect"><i class="fa fa-book"></i><span> My Address Book </span></a>
                            </li>

                            <!-- <li>
                                <a href="{{ url('/admin-reports/partner-admin') }}" class="waves-effect"><i class="mdi mdi-calendar"></i><span> Reports </span></a>
                            </li> -->
                            

                            <li>
                                <a href="{{ url('/meeting/directory/partner-admin') }}" class="waves-effect"><i class="fa fa-line-chart"></i><span> Meetings </span></a>
                            </li>

                            <li>
                                <a href="{{ url('/firmus-web-stats/partner-admin') }}" class="waves-effect"><i class="fa fa-line-chart"></i><span> Activity Logs </span></a>
                            </li>

                            <li>
                                <a href="{{ url('/admin/jobs/partner-admin') }}" class="waves-effect"><i class="fa fa-line-chart"></i><span> Jobs Template </span></a>
                            </li>


                            <li>
                                <a href="{{ url('/manager/home/partner') }}" class="waves-effect"><i class="fa fa-home"></i><span> Switch to Manager </span></a>
                            </li>

                            <li>
                                <a href="{{ url('/finance/home/partner-finance') }}" class="waves-effect"><i class="fa fa-home"></i><span> Switch to Finance </span></a>
                            </li>

                            <li><a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                              //  alert('Hello');
                                                     document.getElementById('logout-form').submit();"><i class="ti-power-off m-r-5"></i>
                                            Logout
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                            </li>


                        </ul>
                    </div>
                    <!-- Sidebar -->
                    <div class="clearfix"></div>

                    <!-- <div class="help-box">
                        <h5 class="text-muted m-t-0">For Help ?</h5>
                        <p class=""><span class="text-custom">Email:</span> <br/> support@support.com</p>
                        <p class="m-b-0"><span class="text-custom">Call:</span> <br/> (+123) 123 456 789</p>
                    </div> -->

                </div>
                <!-- Sidebar -left -->

            </div>
            <!-- Left Sidebar End -->



            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="content-page">
                <!-- Start content -->
                <div class="content">

                    @yield('content')

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



        <script>
            var resizefunc = [];
        </script>
<!-- jQuery  -->
        <script src="{{asset('assets/js/jquery.min.js')}}"></script>
        <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('assets/js/detect.js')}}"></script>
        <script src="{{asset('assets/js/fastclick.js')}}"></script>
        <script src="{{asset('assets/js/jquery.blockUI.js')}}"></script>
        <script src="{{asset('assets/js/waves.js')}}"></script>
        <script src="{{asset('assets/js/jquery.slimscroll.js')}}"></script>
        <script src="{{asset('assets/js/jquery.scrollTo.min.js')}}"></script>
        <script src="{{asset('/plugins/switchery/switchery.min.js')}}"></script>

        <!-- Counter js  -->
        <script src="{{asset('/plugins/waypoints/jquery.waypoints.min.js')}}"></script>
        <script src="{{asset('/plugins/counterup/jquery.counterup.min.js')}}"></script>

        <!-- Flot chart js -->
        <script src="{{asset('/plugins/flot-chart/jquery.flot.min.js')}}"></script>
        <script src="{{asset('/plugins/flot-chart/jquery.flot.time.js')}}"></script>
        <script src="{{asset('/plugins/flot-chart/jquery.flot.tooltip.min.js')}}"></script>
        <script src="{{asset('/plugins/flot-chart/jquery.flot.resize.js')}}"></script>
        <script src="{{asset('/plugins/flot-chart/jquery.flot.pie.js')}}"></script>
        <script src="{{asset('/plugins/flot-chart/jquery.flot.selection.js')}}"></script>
        <script src="{{asset('/plugins/flot-chart/jquery.flot.crosshair.js')}}"></script>

        <script src="{{asset('/plugins/moment/moment.js')}}"></script>
        <script src="{{asset('/plugins/bootstrap-daterangepicker/daterangepicker.js')}}"></script>


        <!-- Dashboard init -->
        <script src="{{asset('assets/pages/jquery.dashboard_2.js')}}"></script>

        <!-- chatjs  -->
        <script src="{{asset('assets/pages/jquery.chat.js')}}"></script>

        <script src="{{asset('/plugins/moment/moment.js')}}"></script>

        <!-- App js -->
        <script src="{{asset('assets/js/jquery.core.js')}}"></script>
        <script src="{{asset('assets/js/jquery.app.js')}}"></script>


        <script src="{{ asset('/plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('/plugins/datatables/dataTables.bootstrap.js') }}"></script>

        <script src="{{ asset('/plugins/datatables/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('/plugins/datatables/buttons.bootstrap.min.js') }}"></script>
        <script src="{{ asset('/plugins/datatables/jszip.min.js') }}"></script>
        <script src="{{ asset('/plugins/datatables/pdfmake.min.js') }}"></script>
        <script src="{{ asset('/plugins/datatables/vfs_fonts.js') }}"></script>
        <script src="{{ asset('/plugins/datatables/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('/plugins/datatables/buttons.print.min.js') }}"></script>
        <script src="{{ asset('/plugins/datatables/dataTables.fixedHeader.min.js') }}"></script>
        <script src="{{ asset('/plugins/datatables/dataTables.keyTable.min.js') }}"></script>
        <script src="{{ asset('/plugins/datatables/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('/plugins/datatables/responsive.bootstrap.min.js') }}"></script>
        <script src="{{ asset('/plugins/datatables/dataTables.scroller.min.js') }}"></script>
        <script src="{{ asset('/plugins/datatables/dataTables.colVis.js') }}"></script>
        <script src="{{ asset('/plugins/datatables/dataTables.fixedColumns.min.js') }}"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

        <script src="{{ asset('/js/rangesliderr.js') }}"></script>

        <!-- init -->
        <script src="{{ asset('/assets/pages/jquery.datatables.init.js') }}"></script>

<script type="text/javascript">
            $(document).ready(function () {
                $('#datatable').dataTable();
                $('#datatable-keytable').DataTable({keys: true});
                $('#datatable-responsive').DataTable();
                $('#datatable-colvid').DataTable({
                    "dom": 'C<"clear">lfrtip',
                    "colVis": {
                        "buttonText": "Change columns"
                    }
                });
                $('#datatable-scroller').DataTable({
                    ajax: "{{ asset('/plugins/datatables/json/scroller-demo.json') }}",
                    deferRender: true,
                    scrollY: 380,
                    scrollCollapse: true,
                    scroller: true
                });
                var table = $('#datatable-fixed-header').DataTable({fixedHeader: true});
                var table = $('#datatable-fixed-col').DataTable({
                    scrollY: "300px",
                    scrollX: true,
                    scrollCollapse: true,
                    paging: false,
                    fixedColumns: {
                        leftColumns: 1,
                        rightColumns: 1
                    }
                });
            });
            TableManageButtons.init();

        </script>



        <script>
            $('#reportrange span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
            $('#reportrange').daterangepicker({
                format: 'MM/DD/YYYY',
                startDate: moment().subtract(29, 'days'),
                endDate: moment(),
                minDate: '01/01/2012',
                maxDate: '12/31/2016',
                dateLimit: {
                    days: 60
                },
                showDropdowns: true,
                showWeekNumbers: true,
                timePicker: false,
                timePickerIncrement: 1,
                timePicker12Hour: true,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                opens: 'left',
                drops: 'down',
                buttonClasses: ['btn', 'btn-sm'],
                applyClass: 'btn-success',
                cancelClass: 'btn-default',
                separator: ' to ',
                locale: {
                    applyLabel: 'Submit',
                    cancelLabel: 'Cancel',
                    fromLabel: 'From',
                    toLabel: 'To',
                    customRangeLabel: 'Custom',
                    daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                    monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    firstDay: 1
                }
            }, function (start, end, label) {
                console.log(start.toISOString(), end.toISOString(), label);
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            });
        </script>
        <script type="text/javascript" src="{{ asset('assets/js/firm_data_handler.js')}}"></script>
        <script src="{{ asset('/assets/js/manager-handler.js') }}"></script>
        <script src="{{ asset('js/crud.js') }}"></script>
       <script src="{{ asset('/js/loading.js') }}"></script>



        <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
  <script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js"></script>
  <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js"></script>
  <script type="text/javascript" charset="utf-8" src="{{asset('js/combobox.js')}}"></script>
  <script type="text/javascript" charset="utf-8">

  var no = new ComboBox('cb_identifier');
  </script>
    </body>

</html>
