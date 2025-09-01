<!DOCTYPE html>
<html>
    
<!-- Mirrored from coderthemes.com/zircos/default/page-lock-screen.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 06 Dec 2017 19:41:10 GMT -->
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
        <meta name="author" content="Coderthemes">

        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">
        <!-- App title -->
        <title>Firmus Advisory - Login<</title>

        <!-- App css -->
        <link href="{{ asset('/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('/assets/css/core.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('/assets/css/components.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('/assets/css/icons.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('/assets/css/pages.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('/assets/css/menu.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('/assets/css/responsive.css') }}" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <script src="{{ asset('/assets/js/modernizr.min.js') }}"></script>
<script>
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','../../../www.google-analytics.com/analytics.html','ga');

          ga('create', 'UA-83057131-1', 'auto');
          ga('send', 'pageview');

        </script>

    </head>


    <body class="bg-transparent">

        <!-- HOME -->
        <section>
            <div class="container-alt">
                <div class="row">
                    <div class="col-sm-12">

                        <div class="wrapper-page" style="box-shadow: 5px 5px 4px #f3f3f3;">

                            <div class="m-t-40 account-pages">
                                <div class="text-center account-logo-box" style="background-color: #f3f3f3;">
                                    <h2 class="text-uppercase">
                                        <a href="index-2.html" class="text-success">
                                            <span><img src="{{ asset('/assets/images/logo.png') }}" alt="" height="55"></span>
                                            
                                        </a>
                                    </h2>
                                    <!--<h4 class="text-uppercase font-bold m-b-0">Sign In</h4>-->
                                </div>

                                <div class="account-content">
                                    <div class="text-center m-b-20">
                                        <div class="m-b-20">
                                            <!-- <img src="assets/images/users/avatar-5.jpg" class="img-circle img-thumbnail thumb-lg" alt="thumbnail"> -->
                                            <center>
                                            <div class="img-circle img-thumbnail thumb-lg bg-primary" style="display: table; overflow: hidden;">
                                               @foreach($name_avt as $name)
                                                  <?php $avt = str_split($name->first_name); ?>
                                                <div style="display: table-cell; vertical-align: middle;">
                                                    <span style="font-size: 40px;">{{ ucfirst($avt[0]) }}</span>
                                                </div>
                                                @endforeach
                                            </div>
                                            </center>

                                            
                                        </div>

                                        @if($check == 1)
                                        <div class="row" style="margin-bottom: 20px;">
                                            <div class="alert alert-danger alert-dismissable">
                                                 <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                 <strong>password must be atleast 8 characters</strong><br>
                                            </div>
                                        </div>
                                        @endif

                                        @if($check == 2)
                                        <div class="row" style="margin-bottom: 20px;">
                                            <div class="alert alert-danger alert-dismissable">
                                                 <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                 <strong>Failed to update password, try again!!</strong><br>
                                            </div>
                                        </div>
                                        @endif


                                        <p class="text-muted m-b-0 font-13">Please complete login by resetting password</p>
                                    </div>
                                    <form class="form-horizontal" method="post" action="pass_confirm_update">
                                        {{ csrf_field()}}
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <input class="form-control" type="password" required=""
                                                       placeholder="New Password" name="password" required>
                                            </div>
                                            
                                        </div>
                                        <div class="form-group">
                                            
                                            <div class="col-xs-12">
                                                <input class="form-control" type="password" required=""
                                                       placeholder="Confirm New Password" name="confirm_password" required>
                                            </div>
                                        </div>

                                        <div class="form-group account-btn text-center m-t-10">
                                            <div class="col-xs-12">
                                                <button class="btn w-md btn-bordered btn-danger waves-effect waves-light"
                                                        type="submit">Continue </button>
                                            </div>
                                        </div>

                                    </form>

                                    <div class="clearfix"></div>

                                </div>
                            </div>
                            <!-- end card-box-->


                            

                        </div>
                        <!-- end wrapper -->

                    </div>
                </div>
            </div>
          </section>
          <!-- END HOME -->

        <script>
            var resizefunc = [];
        </script>
<!-- jQuery  -->
        <script src="{{ asset('/assets/js/jquery.min.js') }}"></script>
        <script src="{{ asset('/assets/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('/assets/js/detect.js') }}"></script>
        <script src="{{ asset('/assets/js/fastclick.js') }}"></script>
        <script src="{{ asset('/assets/js/jquery.blockUI.js') }}"></script>
        <script src="{{ asset('/assets/js/waves.js') }}"></script>
        <script src="{{ asset('/assets/js/jquery.slimscroll.js') }}"></script>
        <script src="{{ asset('/assets/js/jquery.scrollTo.min.js') }}"></script>

        <!-- App js -->
        <script src="{{ asset('/assets/js/jquery.core.js') }}"></script>
        <script src="{{ asset('/assets/js/jquery.app.js') }}"></script>

    </body>

<!-- Mirrored from coderthemes.com/zircos/default/page-lock-screen.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 06 Dec 2017 19:41:10 GMT -->
</html>