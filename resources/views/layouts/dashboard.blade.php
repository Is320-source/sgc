<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Artur Francisco">


    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('../images/icon.png') }}">
    <title>@yield('title')</title>
    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('../dash/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Menu CSS -->
    <link href="{{ asset('../dash/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css') }}" rel="stylesheet">
    <!-- toast CSS -->
    <link href="{{ asset('../dash/plugins/bower_components/toast-master/css/jquery.toast.css') }}" rel="stylesheet">
    <!-- morris CSS -->
    <link href="{{ asset('../dash/plugins/bower_components/morrisjs/morris.css') }}" rel="stylesheet">

    <link href="{{ asset('../dash/plugins/bower_components/css-chart/css-chart.css') }}" rel="stylesheet">

    <!-- chartist CSS -->
    <link href="{{ asset('../dash/plugins/bower_components/chartist-js/dist/chartist.min.css') }}" rel="stylesheet">
    <link href="{{ asset('../dash/plugins/bower_components/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css') }}" rel="stylesheet">
    <!-- Calendar CSS -->
    <link href="{{ asset('../dash/plugins/bower_components/calendar/dist/fullcalendar.css') }}" rel="stylesheet" />
    <!-- animation CSS -->
    <link href="{{ asset('../dash/css/animate.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('../dash/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('../dash/css/style2.css') }}" rel="stylesheet">
    <!-- color CSS -->
    <link href="{{ asset('../dash/css/colors/megna-dark.css') }}" id="theme" rel="stylesheet">

    <!--Gauge chart CSS -->
    <link href="{{ asset('../dash/plugins/bower_components/Minimal-Gauge-chart/css/cmGauge.css') }}" rel="stylesheet" type="text/css" />

    <!-- chartist CSS -->
    <link href="{{ asset('../dash/plugins/bower_components/chartist-js/dist/chartist.min.css') }}" rel="stylesheet">
    <link href="{{ asset('../dash/plugins/bower_components/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css') }}" rel="stylesheet">

    <!-- Menu CSS -->
    <link href="{{ asset('../dash/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('../dash/plugins/bower_components/dropify/dist/css/dropify.min.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
    <!-- Popup CSS -->
    <link href="{{ asset('../dash/plugins/bower_components/Magnific-Popup-master/dist/magnific-popup.css') }}" rel="stylesheet">

    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body class="fix-header">
    <!-- ============================================================== -->
    <!-- Preloader -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg>
    </div>
    <!-- ============================================================== -->
    <!-- Wrapper -->
    <!-- ============================================================== -->
    

    <div id="wrapper">

    <ul class="menu">

      <li title="home"><a href="#" class="menu-button home">menu</a></li>
      
      <li title="search"><a href="#" class="search">search</a></li>
      <li title="pencil"><a href="#" class="pencil">pencil</a></li>
      <li title="about"><a href="#" class="active about">about</a></li>
      <li title="archive"><a href="#" class="archive">archive</a></li>
      <li title="contact"><a href="#" class="contact">contact</a></li>
    </ul>
    
    <ul class="menu-bar">
        <li><a href="#" class="menu-button">Menu</a></li>
        <li><a href="#">Home</a></li>
        <li><a href="#">Profile</a></li>
        <li><a href="#">Editorial</a></li>
        <li><a href="#">About</a></li>
    </ul>
    
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <nav class="navbar navbar-default navbar-static-top m-b-0">
            <div class="navbar-header">
                <div class="top-left-part">
                    <!-- Logo -->
                    <a class="logo" href="{{ route('dashboard.home') }}">
                        <b>
                            <img src="{{ asset('../images/icon.png') }}" alt="home" class="dark-logo" />
                            <img src="{{ asset('../images/icon.png') }}" alt="home" class="light-logo" />
                        </b>
                        <span class="hidden-xs">
                            Boriirri
                        </span>
                        <!-- <span class="hidden-xs">
                            <img src="{{ asset('../dash/plugins/images/admin-text.png') }}" alt="home" class="dark-logo" />
                            <img src="{{ asset('../dash/plugins/images/admin-text-dark.png') }}" alt="home" class="light-logo" />
                        </span>  -->
                    </a>
                </div>
                <!-- /Logo -->
                <!-- Search input and Toggle icon -->
                <ul class="nav navbar-top-links navbar-left">
                    <li><a href="javascript:void(0)" class="open-close waves-effect waves-light visible-xs"><i class="ti-close ti-menu"></i></a></li>
                    <li class="dropdown">
                        <a class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="javascript:void(0)"> <i class="mdi mdi-bell"></i>
                            <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                        </a>
                        <ul class="dropdown-menu mailbox animated bounceInDown">
                            <li>
                                <div class="drop-title">
                                    Notificações indisponíveis</div>
                            </li>
                            <li>
                                <div class="message-center">
                                    <!-- <a href="javascript:void(0)">
                                        <div class="user-img"> <img src="{{ asset('../dash/plugins/images/users/sonu.jpg') }}" alt="user" class="img-circle"> <span class="profile-status busy pull-right"></span> </div>
                                        <div class="mail-contnet">
                                            <h5>Sonu Nigam</h5> <span class="mail-desc">I've sung a song! See you at</span> <span class="time">9:10 AM</span> </div>
                                    </a> -->
                                </div>
                            </li>
                            <li>
                                <!-- <a class="text-center" href="javascript:void(0);"> <strong>See all notifications</strong> <i class="fa fa-angle-right"></i> </a> -->
                            </li>
                        </ul>
                        <!-- /.dropdown-messages -->
                    </li>

                </ul>
                <ul class="nav navbar-top-links navbar-right pull-right">
                    <li>
                        <form role="search" class="app-search hidden-sm hidden-xs m-r-10">
                            <input type="text" placeholder="Search..." class="form-control"> <a href=""><i class="fa fa-search"></i></a>
                        </form>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="javascript:void(0)"> <img src="{{ Auth::user()->photo }}" alt="user-img" width="36" height="36" class="img-circle"><b class="hidden-xs">Admin</b><span class="caret"></span> </a>
                        <ul class="dropdown-menu dropdown-user animated flipInY">
                            <li>
                                <div class="dw-user-box">
                                    <div class="u-img"><img src="{{ Auth::user()->photo }}" alt="user" /></div>
                                    <div class="u-text">
                                        <h4>{{ Auth::user()->name }}</h4>
                                        <p class="text-muted">{{ Auth::user()->email }}</p><a href="{{ route('dashboard.show.user', Auth::user()->id) }}" class="btn btn-rounded btn-danger btn-sm">Meu Perfil</a>
                                    </div>
                                </div>
                            </li>
                            <li role="separator" class="divider"></li>
                            <li><a href="{{ route('dashboard.show.user', Auth::user()->id) }}"><i class="ti-user"></i> Meu Perfil</a></li>
                            <li><a href="{{ route('logout') }}" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();"><i class="fa fa-power-off"></i> Terminar Sessão</a></li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>

                        </ul>
                        <!-- /.dropdown-user -->
                    </li>
                    <!-- /.dropdown -->
                </ul>
            </div>
            <!-- /.navbar-header -->
            <!-- /.navbar-top-links -->
            <!-- /.navbar-static-side -->
        </nav>
        <!-- End Top Navigation -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav">
                <div class="sidebar-head">
                    <h3><span class="fa-fw open-close"><i class="ti-menu hidden-xs"></i><i class="ti-close visible-xs"></i></span> <span class="hide-menu">Navegação</span></h3>
                </div>
                <ul class="nav" id="side-menu">
                    <li class="user-pro">
                        <a href="{{ route('dashboard.show.user', Auth::user()->id) }}" class="waves-effect"><img src="{{ Auth::user()->photo }}" alt="user-img" class="img-circle"> <span class="hide-menu"> {{ Auth::user()->name }}</span>
                        </a>

                    </li>
                    <li> <a href="{{ route('dashboard.home') }}" class="waves-effect {{ (request()->is('cdm/homepage', 'cdm/')) ? 'active' : '' }}"><i class="mdi mdi-av-timer fa-fw"></i> <span class="hide-menu">Página Inicial</span></a> </li>
                    <li> <a href="{{ route('dashboard.statistics') }}" class="waves-effect {{ (request()->is('cdm/statistics')) ? 'active' : '' }}"><i class="mdi mdi-chart-line fa-fw"></i> <span class="hide-menu">Estatística</span></a> </li>
                    <li> <a href="{{ route('dashboard.finances') }}" class="waves-effect {{ (request()->is('cdm/finances')) ? 'active' : '' }}"><i class="mdi mdi-cash-multiple fa-fw"></i> <span class="hide-menu">Finanças</span></a> </li>

                    <li> <a href="javascript:void(0)" class="waves-effect {{ (request()->is('cdm/buildings', 'cdm/buildings/search', 'cdm/typologies', 'cdm/typologies/search', 'cdm/apartaments', 'cdm/apartaments/search', 'cdm/services', 'cdm/services/search')) ? 'active' : '' }}"><i class="mdi mdi-content-copy fa-fw"></i> <span class="hide-menu">Área<span class="fa arrow"></span><span class="label label-rouded label-warning pull-right">30</span></span></a>
                        <ul class="nav nav-second-level two-li">
                            <li><a href="{{ route('dashboard.index.building') }}" class="waves-effect {{ (request()->is('cdm/buildings', 'cdm/buildings/search')) ? 'active' : '' }}"><i class="mdi mdi-home-modern fa-fw"></i> <span class="hide-menu">Prédios</span></a></li>

                            <li><a href="{{ route('dashboard.index.typology') }}" class="waves-effect {{ (request()->is('cdm/typologies', 'cdm/typologies/search')) ? 'active' : '' }}"><i class="mdi mdi-vector-square fa-fw"></i> <span class="hide-menu">Tipologias</span></a></li>
                            <li><a href="{{ route('dashboard.index.apartament') }}" class="waves-effect {{ (request()->is('cdm/apartaments', 'cdm/apartaments/search')) ? 'active' : '' }}"><i class="mdi mdi-flag-variant fa-fw"></i> <span class="hide-menu">Apartamentos</span></a></li>
                            <li><a href="{{ route('dashboard.index.service') }}" class="waves-effect {{ (request()->is('cdm/services', 'cdm/services/search')) ? 'active' : '' }}"><i class="mdi mdi-worker fa-fw"></i> <span class="hide-menu">Serviços</span></a></li>
                        </ul>
                    </li>
                    <li class="devider"></li>
                     
                    <li class="last-nav"><a href="javascript:void(0)" class="waves-effect {{ (request()->is('cdm/users', 'cdm/porters', 'cdm/porters/search', 'cdm/residents', 'cdm/residents/search', 'cdm/logs', 'cdm/user/profile/'. Auth::user()->id)) ? 'active' : '' }}"><i class="mdi mdi-account-switch fa-fw"></i> <span class="hide-menu">Gestão de Usuários<span class="fa arrow"></span></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="{{ route('dashboard.index.user') }}" class="waves-effect {{ (request()->is('cdm/users', 'cdm/user/profile/'. Auth::user()->id)) ? 'active' : '' }}"><i class="mdi mdi-account-settings-variant fa-fw"></i><span class="hide-menu active">Administradores</span></a></li>
                            <li><a href="{{ route('dashboard.index.porter') }}" class="waves-effect {{ (request()->is('cdm/porters', 'cdm/porters/search')) ? 'active' : '' }}"><i class="mdi mdi-account-key fa-fw"></i><span class="hide-menu">Porteiros</span></a></li>
                            <li><a href="{{ route('dashboard.index.resident') }}" class="waves-effect {{ (request()->is('cdm/residents', 'cdm/residents/search')) ? 'active' : '' }}"><i class="mdi mdi-account-switch fa-fw"></i><span class="hide-menu">Moradores</span></a></li>
                        </ul>
                    </li>


                    <li class="last-nav"><a href="javascript:void(0)" class="waves-effect {{ (request()->is('cdm/logs', 'cdm/payments', 'cdm/rates')) ? 'active' : '' }}"><i class="mdi mdi-settings fa-fw"></i> <span class="hide-menu">Configurações<span class="fa arrow"></span></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="{{ route('dashboard.index.rate') }}" class="waves-effect {{ (request()->is('cdm/rates')) ? 'active' : '' }}"><i class="mdi mdi-settings fa-fw"></i><span class="hide-menu active">Taxas de Condomínio</span></a></li>
                             <li><a href="{{ route('dashboard.index.payment') }}" class="waves-effect {{ (request()->is('cdm/payments')) ? 'active' : '' }}"><i class="mdi mdi-cash-multiple fa-fw"></i><span class="hide-menu active">Pagamentos</span></a></li>
                            <li><a href="{{ route('dashboard.index.payment') }}" class="waves-effect {{ (request()->is('cdm/payments')) ? 'active' : '' }}"><i class="mdi mdi-cash-multiple fa-fw"></i><span class="hide-menu active">Lista de Pagamentos</span></a></li> 
                            <li><a href="#" class="waves-effect {{ (request()->is('cdm/logs')) ? 'active' : '' }}"><i class="mdi mdi-account-settings-variant fa-fw"></i><span class="hide-menu active">Logs</span></a></li>
                             <li> <a href="#" class="waves-effect {{ (request()->is('cdm/logs')) ? 'active' : '' }}"><i class="mdi mdi-history fa-fw"></i><span class="hide-menu">Logs</span></a> </li> 
                        </ul>
                    </li>
                    <li class="devider"></li>

                </ul>
            </div>
        </div>


        

        <!-- ============================================================== -->
        <!-- End Left Sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page Content -->
        <!-- ============================================================== -->

        <div id="page-wrapper">


            <div class="container-fluid">
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">@yield('title-page')</h4>
                    </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="javascript:void(0)">@yield('title-page')</a></li>
                            <li class="active">@yield('title-sub-page')</li>
                            
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <!-- ============================================================== -->
                <!-- Different data widgets -->
                <!-- ============================================================== -->
                <!-- /.row -->


                @yield('content')



            </div>


            <!-- /.container-fluid -->
            <footer class="footer text-center"> <?= date('Y') ?> &copy; Kavaltek </footer>
        </div>
        <!-- ============================================================== -->
        <!-- End Page Content -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->



    <script src="{{ asset('../dash/plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="{{ asset('../dash/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- Menu Plugin JavaScript -->
    <script src="{{ asset('../dash/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js') }}"></script>
    <!--slimscroll JavaScript -->
    <script src="{{ asset('../dash/js/jquery.slimscroll.js') }}"></script>
    <!--Wave Effects -->
    <script src="{{ asset('../dash/js/waves.js') }}"></script>
    <!--Counter js -->
    <script src="{{ asset('../dash/plugins/bower_components/waypoints/lib/jquery.waypoints.js') }}"></script>
    <script src="{{ asset('../dash/plugins/bower_components/counterup/jquery.counterup.min.js') }}"></script>
    <!--Morris JavaScript -->
    <script src="{{ asset('../dash/plugins/bower_components/raphael/raphael-min.js') }}"></script>
    <script src="{{ asset('../dash/plugins/bower_components/morrisjs/morris.js') }}"></script>
    <!-- chartist chart -->
    <script src="{{ asset('../dash/plugins/bower_components/chartist-js/dist/chartist.min.js') }}"></script>
    <script src="{{ asset('../dash/plugins/bower_components/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js') }}"></script>
    <!-- Calendar JavaScript -->
    <script src="{{ asset('../dash/plugins/bower_components/moment/moment.js') }}"></script>
    <script src="{{ asset('../dash/plugins/bower_components/calendar/dist/fullcalendar.min.js') }}"></script>
    <script src="{{ asset('../dash/plugins/bower_components/calendar/dist/cal-init.js') }}"></script>
    <!-- Custom Theme JavaScript -->
    <script src="{{ asset('../dash/js/custom.min.js') }}"></script>
    <script src="{{ asset('../dash/js/dashboard2.js') }}"></script>

    <!-- Custom tab JavaScript -->
    <script src="{{ asset('../dash/js/cbpFWTabs.js') }}"></script>
    <script type="text/javascript">
        (function() {
            [].slice.call(document.querySelectorAll('.sttabs')).forEach(function(el) {
                new CBPFWTabs(el);
            });
        })();
    </script>
    <script src="{{ asset('../dash/plugins/bower_components/toast-master/js/jquery.toast.js') }}"></script>
    <!--Style Switcher -->
    <script src="{{ asset('../dash/plugins/bower_components/styleswitcher/jQuery.style.switcher.js') }}"></script>


    <!-- Sparkline chart JavaScript -->
    <script src="{{ asset('../dash/plugins/bower_components/jquery-sparkline/jquery.sparkline.min.js') }}"></script>

    <!-- chartist chart -->
    <script src="{{ asset('../dash/plugins/bower_components/chartist-js/dist/chartist.min.js') }}"></script>
    <script src="{{ asset('../dash/plugins/bower_components/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js') }}"></script>


    <!-- Magnific popup JavaScript -->
    <script src="{{ asset('../dash/plugins/bower_components/Magnific-Popup-master/dist/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('../dash/plugins/bower_components/Magnific-Popup-master/dist/jquery.magnific-popup-init.js') }}"></script>

    <!-- Menu Plugin JavaScript -->
    <script src="{{ asset('../dash/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js') }}"></script>

    <!-- jQuery file upload -->
    <script src="{{ asset('../dash/plugins/bower_components/dropify/dist/js/dropify.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            $(".menu-button").click(function(){
                $(".menu-bar").toggleClass( "open" );
            })
            // Basic
            $('.dropify').dropify();
            // Translated
            $('.dropify-fr').dropify({
                messages: {
                    default: 'Glissez-déposez un fichier ici ou cliquez',
                    replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
                    remove: 'Supprimer',
                    error: 'Désolé, le fichier trop volumineux'
                }
            });
            // Used events
            var drEvent = $('#input-file-events').dropify();
            drEvent.on('dropify.beforeClear', function(event, element) {
                return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
            });
            drEvent.on('dropify.afterClear', function(event, element) {
                alert('File deleted');
            });
            drEvent.on('dropify.errors', function(event, element) {
                console.log('Has Errors');
            });
            var drDestroy = $('#input-file-to-destroy').dropify();
            drDestroy = drDestroy.data('dropify')
            $('#toggleDropify').on('click', function(e) {
                e.preventDefault();
                if (drDestroy.isDropified()) {
                    drDestroy.destroy();
                } else {
                    drDestroy.init();
                }
            })
        });
    </script>
</body>

</html>