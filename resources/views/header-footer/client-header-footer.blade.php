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
    <title>Firmus Advisory - Track</title>

    <!--Morris Chart CSS -->
    <link rel="stylesheet" href="{{ asset('/plugins/morris/morris.css') }}">

    <!-- DataTables -->
    <link href="{{ asset('/plugins/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('plugins/datatables/buttons.bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('plugins/datatables/fixedHeader.bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('plugins/datatables/responsive.bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('plugins/datatables/scroller.bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('plugins/datatables/dataTables.colVis.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('plugins/datatables/dataTables.bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('plugins/datatables/fixedColumns.dataTables.min.css') }}" rel="stylesheet" type="text/css" />

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


    <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

    <script src="{{ asset('assets/js/modernizr.min.js') }}"></script>


    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <style type="text/css">
        #lo1 {
            display: none;
        }

        #lo2 {
            display: none;
        }

        @media only screen and (max-width: 768px) and (min-width: 420px) {
            #lo1 {
                display: block;
            }
        }

        @media only screen and (max-width: 419px) and (min-width: 20px) {
            #lo2 {
                display: block;
            }
        }
    </style>

</head>


<body class="fixed-left">

    <!-- Begin page -->
    <div id="wrapper">

        <!-- Top Bar Start -->
        <div class="topbar">

            <!-- LOGO -->
            <div class="topbar-left" style=".background-color: #f3f3f3;">
                <a href="https://firmusadvisory.com/" class="logo"><span>FIRMUS-<span>SYSTRACK</span></span><i
                        class="mdi mdi-layers"></i></a>
            </div>

            <!-- Button mobile view to collapse sidebar menu -->
            <div class="navbar navbar-default" role="navigation">
                <div class="container">

                    <a href="https://firmusadvisory.com/" class="logo" id="lo1"><span
                            style="color: #36404e;">FIRMUS-<span>SYSTRACK</span></span><i
                            class="mdi mdi-layers"></i></a>

                    <!-- Right(Notification) -->
                    <ul class="nav navbar-nav navbar-right pull-left">


                        <li>
                            <a href="https://firmusadvisory.com/" id="lo2">
                                <h4 style="font-weight: 800;"><span
                                        style="color: #36404e;">FIRMUS-<span>SYSTRACK</span></span><i
                                        class="mdi mdi-layers"></i></h4>
                            </a>
                        </li>







                    </ul> <!-- end navbar-right -->


                    <ul class="nav navbar-nav navbar-right">
                        <li class="hidden-xs">
                            <a href="https://firmusadvisory.com/about-the-company/" target="_blank"
                                class="menu-item">About Us</a>
                        </li>

                        <li class="hidden-xs">
                            <a href="https://firmusadvisory.com/contact-us/" target="_blank"
                                class="menu-item">Contact</a>
                        </li>
                        <li class="hidden-xs">
                            <a href="https://firmusadvisory.com" target="_blank" class="menu-item">Help</a>
                        </li>







                    </ul> <!-- end navbar-right -->

                </div><!-- end container -->
            </div><!-- end navbar -->
        </div>
        <!-- Top Bar End -->





        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <!-- Start content -->
                <div class="content.">

                    @yield('content')

                </div> <!-- content -->

                <footer class="footer text-right">
                    ©2017 Firmus Systrack
                </footer>

            </div>
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
    <script src="{{ asset('/js/client_interact.js') }}"></script>

    <!-- init -->
    <script src="{{ asset('/assets/pages/jquery.datatables.init.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#datatable').dataTable();
            $('#datatable-keytable').DataTable({ keys: true });
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
            var table = $('#datatable-fixed-header').DataTable({ fixedHeader: true });
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
    <script src="{{ asset('js/crud.js') }}"></script>
    <script src="{{ asset('/js/loading.js') }}"></script>
    <script type="text/javascript" charset="utf-8" src="{{asset('js/combobox.js')}}"></script>
    <script type="text/javascript" charset="utf-8">

        var no = new ComboBox('cb_identifier');
    </script>
    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.21/lodash.min.js"></script>
</body>
</html>