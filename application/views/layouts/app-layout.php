<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title><?= $title; ?></title>

    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('assets/img/apple-touch-icon.png') ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('assets/img/favicon-32x32.png') ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('assets/img/favicon-16x16.png') ?>">
    <link rel="manifest" href="<?= base_url('assets/img/site.webmanifest') ?>">
    <link rel="mask-icon" href="safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <!-- General CSS Files -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/85cafb174a.js" crossorigin="anonymous"></script>

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/vendor/jqvmap/dist/jqvmap.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
    
    <link rel="stylesheet" href="<?= base_url() ?>assets/vendor/bootstrap-daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/vendor/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/vendor/izitoast/dist/css/iziToast.min.css">
    <script src="<?= base_url() ?>assets/vendor/izitoast/dist/js/iziToast.min.js"></script>

    <!-- Template CSS -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/style.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/components.css">
</head>

<body data-base_url="<?= base_url() ?>">
    <div id="app">
        <div class="main-wrapper">
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar">
                <form class="form-inline mr-auto">
                    <ul class="navbar-nav mr-3">
                        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i
                                    class="fas fa-bars"></i></a></li>
                        <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i
                                    class="fas fa-search"></i></a></li>
                    </ul>
                    <div class="search-element">
                        <input class="form-control" type="search" placeholder="Search" aria-label="Search"
                            data-width="250">
                        <button class="btn" type="submit"><i class="fas fa-search"></i></button>
                        <div class="search-backdrop"></div>
                        <div class="search-result">
                            <div class="search-header">
                                Histories
                            </div>
                            <div class="search-item">
                                <a href="#">How to hack NASA using CSS</a>
                                <a href="#" class="search-close"><i class="fas fa-times"></i></a>
                            </div>
                            <div class="search-header">
                                Result
                            </div>
                            <div class="search-item">
                                <a href="#">
                                    <img class="mr-3 rounded" width="30"
                                        src="<?= base_url() ?>assets/img/products/product-3-50.png" alt="product">
                                    oPhone S9 Limited Edition
                                </a>
                            </div>
                            <div class="search-header">
                                Projects
                            </div>
                            <div class="search-item">
                                <a href="#">
                                    <div class="search-icon bg-danger text-white mr-3">
                                        <i class="fas fa-code"></i>
                                    </div>
                                    Stisla Admin Template
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
                <ul class="navbar-nav navbar-right">
                    <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
                            class="nav-link nav-link-lg message-toggle beep"><i class="far fa-envelope"></i></a>
                        <div class="dropdown-menu dropdown-list dropdown-menu-right">
                            <div class="dropdown-header">Messages
                                <div class="float-right">
                                    <a href="#">Mark All As Read</a>
                                </div>
                            </div>
                            <div class="dropdown-list-content dropdown-list-message">
                                <a href="#" class="dropdown-item dropdown-item-unread">
                                    <div class="dropdown-item-avatar">
                                        <img alt="image" src="<?= base_url() ?>assets/img/avatar/avatar-1.png"
                                            class="rounded-circle">
                                        <div class="is-online"></div>
                                    </div>
                                    <div class="dropdown-item-desc">
                                        <b>Kusnaedi</b>
                                        <p>Hello, Bro!</p>
                                        <div class="time">10 Hours Ago</div>
                                    </div>
                                </a>
                                <a href="#" class="dropdown-item dropdown-item-unread">
                                    <div class="dropdown-item-avatar">
                                        <img alt="image" src="<?= base_url() ?>assets/img/avatar/avatar-2.png"
                                            class="rounded-circle">
                                    </div>
                                    <div class="dropdown-item-desc">
                                        <b>Dedik Sugiharto</b>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit</p>
                                        <div class="time">12 Hours Ago</div>
                                    </div>
                                </a>
                            </div>
                            <div class="dropdown-footer text-center">
                                <a href="#">View All <i class="fas fa-chevron-right"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
                            class="nav-link notification-toggle nav-link-lg beep"><i class="far fa-bell"></i></a>
                        <div class="dropdown-menu dropdown-list dropdown-menu-right">
                            <div class="dropdown-header">Notifications
                                <div class="float-right">
                                    <a href="#">Mark All As Read</a>
                                </div>
                            </div>
                            <div class="dropdown-list-content dropdown-list-icons">
                                <a href="#" class="dropdown-item dropdown-item-unread">
                                    <div class="dropdown-item-icon bg-primary text-white">
                                        <i class="fas fa-code"></i>
                                    </div>
                                    <div class="dropdown-item-desc">
                                        Template update is available now!
                                        <div class="time text-primary">2 Min Ago</div>
                                    </div>
                                </a>
                                <a href="#" class="dropdown-item">
                                    <div class="dropdown-item-icon bg-info text-white">
                                        <i class="far fa-user"></i>
                                    </div>
                                    <div class="dropdown-item-desc">
                                        <b>You</b> and <b>Dedik Sugiharto</b> are now friends
                                        <div class="time">10 Hours Ago</div>
                                    </div>
                                </a>
                            </div>
                            <div class="dropdown-footer text-center">
                                <a href="#">View All <i class="fas fa-chevron-right"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="dropdown"><a href="#" data-toggle="dropdown"
                            class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                            <img alt="image" src="<?= base_url() ?>assets/img/avatar/avatar-1.png"
                                class="rounded-circle mr-1">
                            <div class="d-sm-none d-lg-inline-block">Hi,
                                <?= $this->session->userdata('nama_lengkap'); ?></div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="dropdown-title">Logged in
                                <?php use Carbon\Carbon; echo Carbon::parse($this->session->userdata('loggedin'))->diffForHumans(); ?>
                            </div>
                            <a href="features-profile.html" class="dropdown-item has-icon">
                                <i class="far fa-user"></i> Profile
                            </a>
                            <a href="features-activities.html" class="dropdown-item has-icon">
                                <i class="fas fa-bolt"></i> Activities
                            </a>
                            <a href="features-settings.html" class="dropdown-item has-icon">
                                <i class="fas fa-cog"></i> Settings
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="<?= base_url('auth/logout'); ?>" class="dropdown-item has-icon text-danger">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>
            <div class="main-sidebar sidebar-style-2">
                <aside id="sidebar-wrapper">
                    <div class="sidebar-brand">
                        <a href="<?= base_url('/admin/dashboard') ?>">TJSL</a>
                    </div>
                    <div class="sidebar-brand sidebar-brand-sm">
                        <a href="<?= base_url('/admin/dashboard') ?>">INTI</a>
                    </div>
                    <ul class="sidebar-menu">
                        <li class="menu-header">
                            Dashboard</li>
                        <li class="nav-item <?php if($this->uri->segment(2) == 'dashboard') { echo 'active'; } ?>">
                            <a href="<?= base_url('/admin/dashboard') ?>" class="nav-link"><i
                                    class="fa-solid fa-house-chimney"></i><span>Dashboard</span></a>
                        </li>
                        <li class="menu-header">Management Data</li>
                        <li class="nav-item dropdown <?php if($this->uri->segment(2) == 'mitra') { echo 'active'; } ?>">
                            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                                    class="fa-solid fa-people-roof"></i> <span>Mitra Binaan</span></a>
                            <ul class="dropdown-menu">
                                <li><a class="nav-link" href="<?= base_url('/admin/mitra') ?>">Semua Mitra</a></li>
                                <li><a class="nav-link" onclick="
                                        changeUrlMitra('http://localhost:3000/admin/mitra/get_data_mitra/kolektibilitas/lancar', 'Lancar'
                                        )">Lancar</a>
                                </li>
                                <li><a class="nav-link" onclick="
                                        changeUrlMitra('http://localhost:3000/admin/mitra/get_data_mitra/kolektibilitas/kuranglancar', 'Kurang Lancar'
                                        )">Kurang
                                        Lancar</a></li>
                                <li><a class="nav-link" onclick="
                                        changeUrlMitra('http://localhost:3000/admin/mitra/get_data_mitra/kolektibilitas/diragukan', 'Diragukan'
                                        )">Diragukan</a>
                                </li>
                                <li><a class="nav-link" onclick="
                                        changeUrlMitra('http://localhost:3000/admin/mitra/get_data_mitra/kolektibilitas/macet', 'Macet'
                                        )">Macet</a>
                                </li>
                            </ul>
                        </li>
                        <li class="<?php if($this->uri->segment(2) == 'saldo') { echo 'active'; } ?>">
                            <a class="nav-link" href="<?= base_url('/admin/saldo') ?>"><i class="fa-solid fa-building-columns"></i>
                                <span>Saldo Kas dan Bank</span>
                            </a>
                        </li>
                        <li class="menu-header">Laporan</li>
                        <li class="nav-item dropdown <?php if($this->uri->segment(2) == 'jurnal') { echo 'active'; } ?>">
                            <a href="#" class="nav-link has-dropdown"><i class="fa-solid fa-book-open"></i>
                                <span>Jurnal</span></a>
                            <ul class="dropdown-menu">
                                <li><a class="nav-link" href="<?= base_url('/admin/jurnal') ?>">Transaksi Jurnal</a>
                                </li>
                                <li><a class="nav-link" href="#"
                                        onclick="changeUrlJurnal('http://localhost:3000/admin/jurnal/transaksi/kas', 'Transaksi Kas')">Transaksi
                                        Kas</a></li>
                                <li><a class="nav-link" href="#"
                                        onclick="changeUrlJurnal('http://localhost:3000/admin/jurnal/transaksi/bri', 'Transaksi BRI')">Transaksi
                                        BRI</a></li>
                                <li><a class="nav-link" href="#"
                                        onclick="changeUrlJurnal('http://localhost:3000/admin/jurnal/transaksi/mandiri', 'Transaksi Mandiri')">Transaksi
                                        Mandiri</a></li>
                                <li><a class="nav-link" href="#"
                                        onclick="changeUrlJurnal('http://localhost:3000/admin/jurnal/transaksi/bank', 'Transaksi Bank')">Transaksi
                                        Bank</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link has-dropdown"><i class="fa-solid fa-magnifying-glass-chart"></i>
                                <span>Laporan Keuangan</span></a>
                            <ul class="dropdown-menu">
                                <li><a class="nav-link" href="<?= base_url('admin/laporan/posisikeuangan') ?>">Posisi Keuangan</a></li>
                                <li><a class="nav-link" href="<?= base_url('admin/laporan/aruskas') ?>">Arus Kas</a></li>
                                <li><a class="nav-link" href="<?= base_url('admin/laporan/kinerja') ?>">Kinerja</a></li>
                                <li><a class="nav-link" href="<?= base_url('admin/laporan/catatan') ?>">Catatan</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown <?php if($this->uri->segment(2) == 'coa') { echo 'active'; } ?>">
                            <a href="#" class="nav-link has-dropdown"><i class="fa-solid fa-bars"></i>
                                <span>Lainnya</span></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?= base_url('admin/coa') ?>">COA</a></li>
                                <li><a href="<?= base_url('admin/agingrate') ?>">Aging Rate</a></li>
                                <li><a href="<?= base_url('admin') ?>">RKA</a></li>
                                <li><a href="<?= base_url('admin') ?>">Neraca Saldo</a></li>
                            </ul>
                        </li>
                </aside>
            </div>

            <!-- Main Content -->
            <div class="main-content">
                <?php echo $contents;?>
            </div>
            <footer class="main-footer">
                <div class="footer-left">
                    Copyright &copy; <?= date('Y') ?> <div class="bullet"></div> Develop By RPL SMKN 1 CIAMIS</a>
                </div>
                <div class="footer-right">
                    1.0.0
                </div>
            </footer>
        </div>
    </div>

    <!-- General JS Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="<?= base_url() ?>assets/js/stisla.js"></script>

    <!-- JS Libraies -->
    <script src="<?= base_url() ?>assets/vendor/jquery-sparkline/jquery.sparkline.min.js"></script>
    <script src="<?= base_url() ?>assets/vendor/chart.js/dist/Chart.min.js"></script>

    <script src="<?= base_url() ?>assets/vendor/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="<?= base_url() ?>assets/vendor/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>

    <script src="<?= base_url() ?>assets/vendor/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script src="<?= base_url() ?>assets/vendor/select2/dist/js/select2.full.min.js"></script>

    <script src="<?= base_url() ?>assets/vendor/price-format-jquery/jquery.priceformat.js"></script>

    <!-- Template JS File -->
    <script src="<?= base_url() ?>assets/js/scripts.js"></script>
    <script src="<?= base_url() ?>assets/js/custom.js"></script>

    <script src="<?= base_url() ?>assets/js/page/index.js"></script>
    <script src="<?= base_url() ?>assets/js/page/modules-datatables.js"></script>
</body>
</html>
