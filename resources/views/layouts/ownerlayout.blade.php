<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>SITOKU - @yield('title')</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="{{asset('dark')}}/img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/975b4715b3.js" crossorigin="anonymous"></script>

    <!-- Libraries Stylesheet -->
    <link href="{{asset('dark')}}/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="{{asset('dark')}}/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{asset('dark')}}/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{asset('dark')}}/css/style.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Then load Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>

<body>
    <div class="container-fluid position-relative d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-secondary navbar-dark">
                <a href="{{route('owner.dashboard')}}" class="navbar-brand mx-4 mb-3">
                    <img src="{{ asset('dark/img/logositoku.png') }}" alt="Logo" style="height: 50px;">
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0">{{Auth::user()->name}}</h6>
                        <span>{{Auth::user()->role}}</span>
                    </div>
                </div>
                <div class="navbar-nav w-100">
                    <a href="{{route('owner.dashboard')}}" class="nav-item nav-link @yield('dashboard-link')"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link @yield('inventori-link') dropdown-toggle" data-bs-toggle="dropdown"><i class="fas fa-boxes me-2"></i>Inventori</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="{{route('owner.daftarbarang')}}" class="dropdown-item">Daftar Barang</a>
                            <a href="{{route('owner.barangmasuk')}}" class="dropdown-item">Barang Masuk</a>
                            <a href="{{route('owner.barangkeluar')}}" class="dropdown-item">Barang Keluar</a>
                            <a href="{{route('owner.returbarang')}}" class="dropdown-item">Barang Retur</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link @yield('laporan-link') dropdown-toggle" data-bs-toggle="dropdown"><i class="fa-solid fa-chart-line me-2"></i>Laporan</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="{{route('owner.stokbarang')}}" class="dropdown-item">Laporan Stok Barang</a>
                            <a href="{{route('owner.penjualan')}}" class="dropdown-item">Laporan Penjualan</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link @yield('lain-link') dropdown-toggle" data-bs-toggle="dropdown"><i class="fas fa-sliders-h me-2"></i>Lain-Lain</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="{{route('owner.satuanbarang')}}" class="dropdown-item">Tambah Satuan Barang</a>
                            <a href="{{route('owner.kategoribarang')}}" class="dropdown-item">Tambah Kategori Barang</a>
                            <a href="{{route('owner.kelolaakun')}}" class="dropdown-item">Kelola Akun</a>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="route('logout')" class="nav-item nav-link" onclick="event.preventDefault(); this.closest('form').submit();">
                            <i class="fas fa-sign-out-alt me-2"></i>
                            Logout
                        </a>
                    </form>

            </nav>
        </div>
        <!-- Sidebar End -->

        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0">
                <a href="#" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-user-edit"></i></h2>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
                <div class="ms-3 d-flex flex-column align-items-start">
                    <span class="inventory-title"> Sistem Inventori</span>
                    <span class="inventory-subtitle"> @yield('title')</span>
                </div>
                <div class="navbar-nav align-items-center ms-auto">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fa fa-bell me-lg-2"></i>
                            <span class="d-none d-lg-inline-flex">Notification</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0 justify-content-between">
                            <div class="d-flex flex-column align-items-stretch" style="max-height: 200px; min-width:20rem">
                                <div class="d-flex flex-column" style="overflow-y:scroll;">
                                    @if(auth()->user()->notifications->isNotEmpty())
                                    @foreach (auth()->user()->notifications as $notification)
                                    <a href="#" class="dropdown-item">
                                        <div class="d-flex flex-row justify-content-start align-items-center">
                                            <i class="fa fa-bell me-2"></i>
                                            <li class="fw-normal mb-0"> {{$notification->data['data']}}</li>
                                        </div>
                                    </a>
                                    <hr class="dropdown-divider">
                                    @endforeach
                                    @else
                                    <a href="#" class="dropdown-item">
                                        <li class="fw-normal mb-0">Tidak Ada Notifikasi</li>
                                    </a>
                                    <hr class="dropdown-divider">
                                    @endif
                                </div>


                                <div class="d-flex flex-column align-items-stretch">
                                    <hr class="dropdown-divider">
                                    <a href="{{route('owner.daftarbarang')}}" class="dropdown-item text-center " style="background-color:var(--secondary)">Periksa Daftar Barang</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fas fa-user-edit me-lg-2"></i>
                            <span class="d-none d-lg-inline-flex">{{Auth::user()->name}}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                            <a href="{{route('owner.kelolaakun')}}" class="dropdown-item">Kelola Akun</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="route('logout')" class="dropdown-item" onclick="event.preventDefault(); this.closest('form').submit();">
                                    Log Out
                                </a>
                            </form>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->

            @yield('content')

            <!-- Footer Start -->
            <div class="container-fluid pt-4 px-4 py-0">
                <div class="bg-secondary rounded-top p-4">
                    <div class="row">
                        <div class="text-center text-sm-start">
                            Copyright &copy; 2024 <a class="copyright" href="#">Toko Kurnia</a>, All Right Reserved.
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer End -->
        </div>
        <!-- Content End -->

        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('dark')}}/lib/chart/chart.min.js"></script>
    <script src="{{asset('dark')}}/lib/easing/easing.min.js"></script>
    <script src="{{asset('dark')}}/lib/waypoints/waypoints.min.js"></script>
    <script src="{{asset('dark')}}/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="{{asset('dark')}}/lib/tempusdominus/js/moment.min.js"></script>
    <script src="{{asset('dark')}}/lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="{{asset('dark')}}/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="{{asset('dark')}}/js/main.js"></script>
</body>

</html>