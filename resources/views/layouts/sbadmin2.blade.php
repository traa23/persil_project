<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Admin Persil - SBAdmin2</title>
    <!-- Custom fonts for this template-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"
        type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="https://cdn.jsdelivr.net/npm/startbootstrap-sb-admin-2@4.1.4/css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/admin/persil') }}">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-landmark"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Persil Admin</div>
            </a>
            <!-- Divider -->
            <hr class="sidebar-divider my-0">
            <!-- Nav Item - Dashboard -->
            <li class="nav-item {{ request()->is('admin/persil') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/admin/persil') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Persil</span>
                </a>
            </li>
            <!-- Nav Item - Dokumen Persil -->
            <li class="nav-item {{ request()->is('admin/dokumen-persil*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/admin/dokumen-persil') }}">
                    <i class="fas fa-fw fa-file-alt"></i>
                    <span>Dokumen Persil</span>
                </a>
            </li>
            <!-- Nav Item - Peta Persil -->
            <li class="nav-item {{ request()->is('admin/peta-persil*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/admin/peta-persil') }}">
                    <i class="fas fa-fw fa-map"></i>
                    <span>Peta Persil</span>
                </a>
            </li>
            <!-- Nav Item - Sengketa Persil -->
            <li class="nav-item {{ request()->is('admin/sengketa-persil*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/admin/sengketa-persil') }}">
                    <i class="fas fa-fw fa-exclamation-triangle"></i>
                    <span>Sengketa Persil</span>
                </a>
            </li>
            <!-- Nav Item - Jenis Penggunaan -->
            <li class="nav-item {{ request()->is('admin/jenis-penggunaan*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/admin/jenis-penggunaan') }}">
                    <i class="fas fa-fw fa-list"></i>
                    <span>Jenis Penggunaan</span>
                </a>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">
            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <!-- End of Sidebar -->
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Admin</span>
                                <img class="img-profile rounded-circle" src="https://via.placeholder.com/40x40">
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    @yield('content')
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->
            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Persil Admin {{ date('Y') }}</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <!-- Bootstrap core JavaScript-->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="https://cdn.jsdelivr.net/npm/jquery-easing@1.4.1/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="https://cdn.jsdelivr.net/npm/startbootstrap-sb-admin-2@4.1.4/js/sb-admin-2.min.js"></script>
</body>

</html>