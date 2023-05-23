<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ isset($title) && $title ? "$title - " : '' }} SIM TUNJANGAN</title>
    <!-- Favicons -->
    <link href="{{ asset('media/img/logo-tanjabar.png') }}" rel="icon">
    <link href="{{ asset('media/img/logo-tanjabar.png') }}" rel="apple-touch-icon">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('templates/adminlte') }}/plugins/fontawesome-free/css/all.min.css">
    <!-- pace-progress -->
    <link rel="stylesheet" href="{{ asset('templates/adminlte') }}/plugins/pace-progress/themes/black/pace-theme-flat-top.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('templates/adminlte') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('templates/adminlte') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('templates/adminlte') }}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('templates/adminlte') }}/dist/css/adminlte.min.css">

    <link rel="stylesheet" href="{{ asset('templates/adminlte') }}/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="{{ asset('templates/adminlte') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">


    <style>
        .nowrap {
            white-space: nowrap !important;
        }

        .table td {
            padding-top: 3px !important;
            padding-bottom: 3px !important;
            vertical-align: middle !important;
        }
    </style>

    <!-- jQuery -->
    <script src="{{ asset('templates/adminlte') }}/plugins/jquery/jquery.min.js"></script>
    <script src="{{ asset('templates/adminlte') }}/plugins/select2/js/select2.full.min.js"></script>
</head>

<body class="hold-transition sidebar-mini layout-navbar-fixed layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item bg-danger">
                    <a class="nav-link" href="{{ route('logout') }}" role="button">
                        <i class="fa fa-power-off"></i> LOGOUT
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar bg-white elevation-4">
            <!-- Brand Logo -->
            <a href="/dashboard" class="brand-link #text-center text-dark">
                <img src="{{ asset('media/img/logo-tanjabar.jpg') }}" alt="SIM-TUN Logo" class="brand-image #img-circle #elevation-3" style="#opacity: .8">
                <span class="brand-text font-weight-dark h4">SIM TUNJANGAN</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        @if (session('image') && file_exists('files/users/' . session('image')))
                            <img src="{{ asset('files/users/' . session('image')) }}" class="img-circle elevation-2" alt="User Image">
                        @elseif (session('avatar'))
                            <img src="{{ session('avatar') }}" class="img-circle elevation-2" alt="User Avatar">
                        @else
                            <img src="{{ asset('media/img/no-user.png') }}" class="img-circle elevation-2" alt="User Image Default">
                        @endif
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{ session('name') }}</a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent #nav-flat #nav-compact" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ url('/') }}" class="nav-link">
                                <i class="nav-icon fa fa-home"></i>
                                <p> Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('profile.index') }}" class="nav-link">
                                <i class="nav-icon fa fa-user"></i>
                                <p> Profile</p>
                            </a>
                        </li>

                        @if (session('op'))
                            <li class="nav-item">
                                <a href="{{ route('user-ops.index') }}" class="nav-link">
                                    <i class="fa fa-users nav-icon"></i>
                                    <p>Operator Sekolah</p>
                                </a>
                            </li>
                        @endif

                        @if (session('admin'))
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-user"></i>
                                    <p>
                                        Managemen User
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('admin.index') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Administrator</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('user-op.index') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Admin Wilayah</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('user-ops.index') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Operator Sekolah</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-list"></i>
                                    <p>
                                        Data Master
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('jenis-tpp.index') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Jenis TPP</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('tpp-perbulan.index') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>TPP Perbulan</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif

                        @if (session('ops'))
                            {{-- <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-user"></i>
                                    <p>
                                        Managemen User
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('user.index') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>User List</p>
                                        </a>
                                    </li>
                                </ul>
                            </li> --}}
                        @endif

                        <li class="nav-item">
                            <a href="{{ route('sekolah.index') }}" class="nav-link">
                                <i class="nav-icon fa fa-home"></i>
                                <p> Data Sekolah</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-graduation-cap"></i>
                                <p>Data PTK <i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('ptk.index') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Data PTK</p>
                                    </a>
                                </li>
                                {{-- <li class="nav-item">
                                    <a href="{{ route('tugas-tambahan-ptk.index') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Tugas Tambahan</p>
                                    </a>
                                </li> --}}
                                <li class="nav-item">
                                    <a href="{{ route('ptk-nonaktif.index') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>PTK Non-Aktif</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('input-tpp.index') }}" class="nav-link">
                                <i class="far fa-edit nav-icon"></i>
                                <p>Input TPP Manual</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-list"></i>
                                <p>Laporan TPP <i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('rekap-tpp.index') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Rekap TPP</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
                <script>
                    $('[href="{{ url()->current() }}"]').addClass('active');
                    $('[href="{{ url()->current() }}"]').parent().parent().parent().addClass('menu-is-opening menu-open');
                    $('.menu-is-opening>.nav-link').addClass('active')
                </script>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            @if (isset($title))
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>{{ $title }}</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                                    <li class="breadcrumb-item active">{{ $title }}</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </section>
            @else
                <div class="mb-4"></div>
            @endif

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                    @yield('content')

                </div>
                <!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                {{-- <b>Version</b> 3.2.0 --}}
            </div>
            <strong>Copyright &copy; 2023 <a href="#">SIM-TUN</a>.</strong> All rights reserved.
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- Bootstrap 4 -->
    <script src="{{ asset('templates/adminlte') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- pace-progress -->
    <script src="{{ asset('templates/adminlte') }}/plugins/pace-progress/pace.min.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('templates/adminlte') }}/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('templates/adminlte') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('templates/adminlte') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('templates/adminlte') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="{{ asset('templates/adminlte') }}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('templates/adminlte') }}/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="{{ asset('templates/adminlte') }}/plugins/jszip/jszip.min.js"></script>
    <script src="{{ asset('templates/adminlte') }}/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="{{ asset('templates/adminlte') }}/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="{{ asset('templates/adminlte') }}/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="{{ asset('templates/adminlte') }}/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="{{ asset('templates/adminlte') }}/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('templates/adminlte') }}/dist/js/adminlte.min.js"></script>

    <script>
        $(document).ajaxStart(function() {
            Pace.restart();
        }).ajaxStop(function() {
            Pace.stop();
        });
    </script>
</body>

</html>
