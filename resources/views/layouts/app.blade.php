<!DOCTYPE html>
<html lang="en" dir="ltr" data-startbar="light" data-bs-theme="light">

<head>
    <meta charset="utf-8" />
    <title>Baznas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="https://tulangbawangkab.go.id/img/logo/favicon.png">

    <link rel="stylesheet" href="/assets/libs/jsvectormap/css/jsvectormap.min.css">

    <!-- font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- App css -->
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>

<body>

    <!-- Top Bar Start -->
    <div class="topbar d-print-none">
        <div class="container-xxl">
            <nav class="topbar-custom d-flex justify-content-between" id="topbar-custom">
                <ul class="topbar-item list-unstyled d-inline-flex align-items-center mb-0">
                    <li>
                        <button class="nav-link mobile-menu-btn nav-icon" id="togglemenu">
                            <i class="iconoir-menu-scale"></i>
                        </button>
                    </li>
                    <li class="mx-3 welcome-text">
                        <h3 class="mb-0 fw-bold text-truncate">Profile</h3>
                    </li>
                </ul>
                <ul class="topbar-item list-unstyled d-inline-flex align-items-center mb-0">
                    <li class="hide-phone app-search">
                        <form role="search" action="#" method="get">
                            <input type="search" name="search" class="form-control top-search mb-0" placeholder="Search here...">
                            <button type="button"><i class="iconoir-search"></i></button>
                        </form>
                    </li>
                    <li class="topbar-item">
                        <a class="nav-link nav-icon" href="javascript:void(0);" id="light-dark-mode">
                            <i class="icofont-sun dark-mode"></i>
                            <i class="icofont-moon light-mode"></i>
                        </a>
                    </li>
                    <li class="dropdown topbar-item">
                        <a class="nav-link dropdown-toggle arrow-none nav-icon" data-bs-toggle="dropdown" href="#" role="button"
                            aria-haspopup="false" aria-expanded="false">
                            <i class="icofont-bell-alt"></i>
                            <span class="alert-badge"></span>
                        </a>
                    </li>
                    <li class="dropdown topbar-item">
                        <a class="nav-link dropdown-toggle arrow-none nav-icon" data-bs-toggle="dropdown" href="#" role="button"
                            aria-haspopup="false" aria-expanded="false">
                            <i class="fas fa-user-circle"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end py-0">
                            <div class="d-flex align-items-center dropdown-item py-2 bg-secondary-subtle">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-user-circle" style="font-size: 24px;"></i>
                                </div>
                                <h6 class="my-0 fw-medium text-dark fs-13">Admin</h6>
                                <div class="flex-grow-1 ms-2 text-truncate align-self-center">
                                    <small class="text-muted mb-0">Baznas</small>
                                </div>
                            </div>
                            <div class="dropdown-divider mt-0"></div>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                            <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="las la-power-off fs-18 me-1 align-text-bottom"></i> Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    <!-- Top Bar End -->

    <!-- leftbar-tab-menu -->
    <div class="startbar d-print-none">
        <div class="brand">
            <a href="index" class="logo d-flex align-items-center text-decoration-none text-dark fw-bold">
            <img loading="lazy" src="https://tulangbawangkab.go.id/img/logo/favicon.png" alt="Logo" width="40px" class="img-fluid">
            {{-- <span class="mx-3 welcome-text">
                <h4 class="mb-0 fw-bold text-truncate" style="color: rgb(34, 197, 94);">Baznas</h4>
            </span> --}}
            </a>
        </div>
        <div class="startbar-menu">
            <div class="startbar-collapse" id="startbarCollapse" data-simplebar>
                <div class="d-flex align-items-start flex-column w-100">
                    <ul class="navbar-nav mb-auto w-100">
                        <li class="menu-label pt-0 mt-0">
                            <small class="label-border">
                                <div class="border_left hidden-xs"></div>
                                <div class="border_right"></div>
                            </small>
                            <span>Menu</span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard">
                                <i class="iconoir-home-simple menu-icon"></i>
                                <span>Dashboards</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="category">
                                <i class="iconoir-view-grid menu-icon"></i>
                                <span>Kategori</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="campaign">
                                <i class="iconoir-journal-page menu-icon"></i>
                                <span>Program</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="donatur">
                                <i class="fas fa-user-friends menu-icon"></i>
                                <span>Muzakki</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="donation">
                                <i class="fas fa-chart-line menu-icon"></i>
                                <span>Donasi</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="profile">
                                <i class="iconoir-fingerprint-lock-circle menu-icon"></i>
                                <span>Profile</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="slider">
                                <i class="fas fa-chalkboard menu-icon"></i>
                                <span>Sidebar</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="startbar-overlay d-print-none"></div>
    <!-- end leftbar-tab-menu -->

    <div class="page-wrapper">
        <!-- Konten Halaman -->
        <div class="page-content">

            @yield('content')
            <footer class="footer text-center text-sm-start d-print-none">
                <div class="container-xxl">
                    <div class="row">
                        <div class="col-12">
                            <div class="card mb-0 rounded-bottom-0">
                                <div class="card-body">
                                    <p class="text-muted mb-0">
                                        ©
                                        <script> document.write(new Date().getFullYear()) </script>
                                        Haldian
                                        <span
                                            class="text-muted d-none d-sm-inline-block float-end">
                                            Crafted with
                                            <i class="iconoir-heart text-danger"></i>
                                            by All Tim Dinas Komunikasi Tulang Bawang</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>

            <!--end footer-->

        </div>
    </div>



    <!-- Javascript  -->
    <script src="/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/libs/simplebar/simplebar.min.js"></script>
    <script src="/assets/libs/apexcharts/apexcharts.min.js"></script>
    <script src="/assets/data/stock-prices.js"></script>
    <script src="/assets/libs/jsvectormap/js/jsvectormap.min.js"></script>
    <script src="/assets/libs/jsvectormap/maps/world.js"></script>
    <script src="/assets/js/pages/index.init.js"></script>
    <script src="/assets/js/app.js"></script>
</body>

</html>
