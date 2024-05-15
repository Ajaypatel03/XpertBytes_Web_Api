<!DOCTYPE html>

<!--
 // WEBSITE: https://themefisher.com
 // TWITTER: https://twitter.com/themefisher
 // FACEBOOK: https://www.facebook.com/themefisher
 // GITHUB: https://github.com/themefisher/
-->

<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>XpertBytes</title>

    <!-- theme meta -->
    <meta name="theme-name" content="XpertBytes" />

    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css?family=Karla:400,700|Roboto" rel="stylesheet">
    <link href="plugins/material/css/materialdesignicons.min.css" rel="stylesheet" />
    <link href="plugins/simplebar/simplebar.css" rel="stylesheet" />

    <!-- PLUGINS CSS STYLE -->
    <link href="plugins/nprogress/nprogress.css" rel="stylesheet" />




    <link href="plugins/DataTables/DataTables-1.10.18/css/jquery.dataTables.min.css" rel="stylesheet" />



    <link href="plugins/jvectormap/jquery-jvectormap-2.0.3.css" rel="stylesheet" />



    <link href="plugins/daterangepicker/daterangepicker.css" rel="stylesheet" />



    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">



    <link href="plugins/toaster/toastr.min.css" rel="stylesheet" />


    <!-- MONO CSS -->
    <link id="main-css-href" rel="stylesheet" href="css/style.css" />




    <!-- FAVICON -->
    <link href="images/xb.jpeg" rel="shortcut icon" />

    <!-- Include SweetAlert CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11" rel="stylesheet">


    <!--
    HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries
  -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
    <script src="plugins/nprogress/nprogress.js"></script>
</head>

<body class="navbar-fixed sidebar-fixed" id="body">
    <script>
        NProgress.configure({
            showSpinner: false
        });
        NProgress.start();
    </script>


    {{--  <div id="toaster"></div>  --}}


    <!-- ====================================
    ——— WRAPPER
    ===================================== -->
    <div class="wrapper">


        <!-- ====================================
          ——— LEFT SIDEBAR WITH OUT FOOTER
        ===================================== -->
        <aside class="left-sidebar sidebar-dark" id="left-sidebar">
            <div id="sidebar" class="sidebar sidebar-with-footer">
                <!-- Aplication Brand -->
                <div class="app-brand">
                    <a href="{{ url('/dashboard') }}">
                        <img src="images/xb2logo.png" alt="XpertBytes">
                    </a>
                </div>
                <!-- begin sidebar scrollbar -->
                <div class="sidebar-left" data-simplebar style="height: 100%;">
                    <!-- sidebar menu -->
                    <ul class="nav sidebar-inner" id="sidebar-menu">



                        <li class="active">
                            <a class="sidenav-item-link" href="{{ route('dashboard') }}">
                                <i class="mdi mdi-briefcase-account-outline"></i>
                                <span class="nav-text">Dashboard</span>
                            </a>
                        </li>


                        <li class="section-title">
                            Apps
                        </li>





                        <li>
                            <a class="sidenav-item-link" href="{{ route('blogs.index') }}">
                                <i class="mdi mdi-blogger"></i>
                                <span class="nav-text">Blog</span>
                            </a>
                        </li>

                        <li>
                            <a class="sidenav-item-link" href="{{ route('clients.index') }}">
                                <i class="mdi mdi-account-question"></i>
                                <span class="nav-text">Client Review</span>
                            </a>
                        </li>

                        <li>
                            <a class="sidenav-item-link" href="{{ route('employs.index') }}">
                                <i class="mdi mdi-account-group"></i>
                                <span class="nav-text">Employees</span>
                            </a>
                        </li>

                        <li>
                            <a class="sidenav-item-link" href="{{ route('services.index') }}">
                                <i class="mdi mdi-alpha-s-box"></i>
                                <span class="nav-text">Service</span>
                            </a>
                        </li>

                        <li>
                            <a class="sidenav-item-link" href="{{ route('quotes.index') }}">
                                <i class="mdi mdi-alpha-q-box"></i>
                                <span class="nav-text">Quotes</span>
                            </a>
                        </li>

                        <li>
                            <a class="sidenav-item-link" href="{{ route('contacts.index') }}">
                                <i class="mdi mdi-phone-classic"></i>
                                <span class="nav-text">Contact Us</span>
                            </a>
                        </li>

                    </ul>

                </div>


            </div>
        </aside>

        <!-- ====================================
      ——— PAGE WRAPPER
      ===================================== -->
        <div class="page-wrapper">

            <!-- Header -->
            <header class="main-header" id="header">
                <nav class="navbar navbar-expand-lg navbar-light" id="navbar">
                    <!-- Sidebar toggle button -->
                    <button id="sidebar-toggler" class="sidebar-toggle">
                        <span class="sr-only">Toggle navigation</span>
                    </button>

                    <div class="navbar-right ">

                        <ul class="nav navbar-nav">

                            <!-- User Account -->
                            <li class="dropdown user-menu">
                                <button class="dropdown-toggle nav-link" data-toggle="dropdown">
                                    <span class="d-none d-lg-inline-block">{{ Auth()->user()->name }}</span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li>
                                        <a class="dropdown-link-item" href="">
                                            <i class="mdi mdi-account-outline"></i>
                                            <span class="nav-text">My Profile</span>
                                        </a>
                                    </li>

                                    {{--  <li class="dropdown-footer">
                                        <a class="dropdown-link-item" href="sign-in.html"> <i
                                                class="mdi mdi-logout"></i> Log
                                            Out </a>
                                    </li>  --}}
                                    <li class="dropdown-footer">
                                        <form id="logout-form" method="post" action="{{ route('logout') }}">
                                            @csrf
                                            <a id="logout-button" class="dropdown-link-item" href="#">
                                                <i class="mdi mdi-logout"></i> LogOut
                                            </a>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>


            </header>

            @yield('content')

            <!-- Footer -->
            <footer class="footer mt-auto">
                <div class="copyright bg-white">
                    <p>
                        <img src="images/xb2logo.png" alt="XpertBytes"
                            style="width: 100px; height: auto;background-color:black;">
                        <a class="text-primary" href="https://xpertbytes.com/" target="_blank"> &copy; <span
                                id="copy-year"></span> Copyright,All Rights Reserved</a>.
                    </p>
                </div>
                <script>
                    var d = new Date();
                    var year = d.getFullYear();
                    document.getElementById("copy-year").innerHTML = year;
                </script>
            </footer>

        </div>
    </div>




    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="plugins/simplebar/simplebar.min.js"></script>
    <script src="https://unpkg.com/hotkeys-js/dist/hotkeys.min.js"></script>



    <script src="plugins/apexcharts/apexcharts.js"></script>



    <script src="plugins/DataTables/DataTables-1.10.18/js/jquery.dataTables.min.js"></script>



    <script src="plugins/jvectormap/jquery-jvectormap-2.0.3.min.js"></script>
    <script src="plugins/jvectormap/jquery-jvectormap-world-mill.js"></script>
    <script src="plugins/jvectormap/jquery-jvectormap-us-aea.js"></script>



    <script src="plugins/daterangepicker/moment.min.js"></script>
    <script src="plugins/daterangepicker/daterangepicker.js"></script>
    <script>
        jQuery(document).ready(function() {
            jQuery('input[name="dateRange"]').daterangepicker({
                autoUpdateInput: false,
                singleDatePicker: true,
                locale: {
                    cancelLabel: 'Clear'
                }
            });
            jQuery('input[name="dateRange"]').on('apply.daterangepicker', function(ev, picker) {
                jQuery(this).val(picker.startDate.format('MM/DD/YYYY'));
            });
            jQuery('input[name="dateRange"]').on('cancel.daterangepicker', function(ev, picker) {
                jQuery(this).val('');
            });
        });
    </script>



    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>



    <script src="plugins/toaster/toastr.min.js"></script>
    <!-- Include SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



    <script src="js/mono.js"></script>
    <script src="js/chart.js"></script>
    <script src="js/map.js"></script>
    <script src="js/custom.js"></script>

    <script>
        document.getElementById('logout-button').addEventListener('click', function() {
            document.getElementById('logout-form').submit();
        });
    </script>

    {{--  <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>  --}}

    @yield('script')

    <!--  -->


</body>

</html>
