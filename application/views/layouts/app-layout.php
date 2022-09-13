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
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/vendor/jqvmap/dist/jqvmap.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
    
    <link rel="stylesheet" href="<?= base_url() ?>assets/vendor/bootstrap-daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/vendor/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/vendor/izitoast/dist/css/iziToast.min.css">
    <script src="<?= base_url() ?>assets/vendor/izitoast/dist/js/iziToast.min.js"></script>
    <script type='text/javascript' src='https://www.gstatic.com/charts/loader.js'></script>
    <script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAOVYRIgupAurZup5y1PRh8Ismb1A3lLao&libraries=visualization&callback=initMap"></script>

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
                            <?php
                                $images="https://source.boringavatars.com/beam/120/" . urlencode($profile_name) . "?square&colors=FAD089,FF9C5B,F5634A,ED303C,3B8183";
                            ?>
                            <img alt="image" src="<?php echo ($profile_foto != 'no_image.jpg') ? base_url('/assets/media/profiles/') . $profile_foto : $images ; ?>"
                                class="rounded-circle mr-1">
                            <div class="d-sm-none d-lg-inline-block">Hi,
                                <?= $profile_name; ?></div>
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
                            <a href="<?= site_url('Auth/logout'); ?>" class="dropdown-item has-icon text-danger">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>
            <div class="main-sidebar sidebar-style-2">
                <aside id="sidebar-wrapper">
                    <div class="sidebar-brand">
                        <a href="<?= base_url('/Admin/Dashboard') ?>">TJSL</a>
                    </div>
                    <div class="sidebar-brand sidebar-brand-sm">
                        <a href="<?= base_url('/Admin/Dashboard') ?>">INTI</a>
                    </div>
                    <ul class="sidebar-menu">
                        <li class="menu-header">
                            Dashboard</li>
                        <li class="nav-item <?php if($this->uri->segment(2) == 'Dashboard') { echo 'active'; } ?>">
                            <a href="<?= base_url('/Admin/Dashboard') ?>" class="nav-link"><i
                                    class="fa-solid fa-house-chimney"></i><span>Dashboard</span></a>
                        </li>
                        <li class="menu-header">Management Data</li>
                        <li class="nav-item dropdown <?php if($this->uri->segment(2) == 'Mitra') { echo 'active'; } ?>">
                            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                                    class="fa-solid fa-people-roof"></i> <span>Mitra Binaan</span></a>
                            <ul class="dropdown-menu">
                                <?php $domain = 'tjslptinti.test' ?>
                                <li><a class="nav-link" href="<?= base_url('/Admin/Mitra') ?>">Semua Mitra</a></li>
                                <li><a class="nav-link" onclick="
                                        changeUrlMitra('Admin/Mitra/Get_data_mitra/Kolektibilitas/lancar', 'Lancar'
                                        )">Lancar</a>
                                </li>
                                <li><a class="nav-link" onclick="
                                        changeUrlMitra('Admin/Mitra/Get_data_mitra/Kolektibilitas/kuranglancar', 'Kurang Lancar'
                                        )">Kurang
                                        Lancar</a></li>
                                <li><a class="nav-link" onclick="
                                        changeUrlMitra('Admin/Mitra/Get_data_mitra/Kolektibilitas/diragukan', 'Diragukan'
                                        )">Diragukan</a>
                                </li>
                                <li><a class="nav-link" onclick="
                                        changeUrlMitra('Admin/Mitra/Get_data_mitra/Kolektibilitas/macet', 'Macet'
                                        )">Macet</a>
                                </li>
                            </ul>
                        </li>
                        <li class="<?php if($this->uri->segment(2) == 'Saldo') { echo 'active'; } ?>">
                            <a class="nav-link" href="<?= base_url('/Admin/Saldo') ?>"><i class="fa-solid fa-building-columns"></i>
                                <span>Saldo Kas dan Bank</span>
                            </a>
                        </li>
                        <li class="menu-header">Laporan</li>
                        <li class="nav-item dropdown <?php if($this->uri->segment(2) == 'Jurnal') { echo 'active'; } ?>">
                            <a href="#" class="nav-link has-dropdown"><i class="fa-solid fa-book-open"></i>
                                <span>Jurnal</span></a>
                            <ul class="dropdown-menu">
                                <li><a class="nav-link" href="<?= base_url('/Admin/Jurnal') ?>">Transaksi Jurnal</a>
                                </li>
                                <li><a class="nav-link" href="#"
                                        onclick="changeUrlJurnal('Admin/Jurnal/Transaksi/kas', 'Transaksi Kas')">Transaksi Kas</a></li>
                                <li><a class="nav-link" href="#"
                                        onclick="changeUrlJurnal('Admin/Jurnal/Transaksi/bri', 'Transaksi BRI')">Transaksi BRI</a></li>
                                <li><a class="nav-link" href="#"
                                        onclick="changeUrlJurnal('Admin/Jurnal/Transaksi/mandiri', 'Transaksi Mandiri')">Transaksi Mandiri</a></li>
                                <li><a class="nav-link" href="#"
                                        onclick="changeUrlJurnal('Admin/Jurnal/Transaksi/bank', 'Transaksi Bank')">Transaksi Bank</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown <?php if($this->uri->segment(2) == 'Laporan') { echo 'active'; } ?>">
                            <a href="#" class="nav-link has-dropdown"><i class="fa-solid fa-magnifying-glass-chart"></i>
                                <span>Laporan Keuangan</span></a>
                            <ul class="dropdown-menu">
                                <li><a class="nav-link" href="<?= base_url('Admin/Laporan/Posisikeuangan') ?>">Posisi Keuangan</a></li>
                                <li><a class="nav-link" href="<?= base_url('Admin/Laporan/Aktivitas') ?>">Aktivitas</a></li>
                                <li><a class="nav-link" href="<?= base_url('Admin/Laporan/Aruskas') ?>">Arus Kas</a></li>
                                <li><a class="nav-link" href="<?= base_url('Admin/Laporan/Kinerja') ?>">Kinerja</a></li>
                                <li><a class="nav-link" href="<?= base_url('Admin/Laporan/Catatan') ?>">Catatan </a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown <?php if($this->uri->segment(2) == 'Lainnya') { echo 'active'; } ?>">
                            <a href="#" class="nav-link has-dropdown"><i class="fa-solid fa-bars"></i>
                                <span>Lainnya</span></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?= base_url('Admin/Coa') ?>">COA</a></li>
                                <li><a href="<?= base_url('Admin/Agingrate') ?>">Aging Rate</a></li>
                                <li><a href="<?= base_url('Admin/RKA') ?>">RKA</a></li>
                                <li><a href="<?= base_url('Admin/NeracaSaldo') ?>">Neraca Saldo</a></li>
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
    <script src="https://pixinvent.com/demo/vuexy-html-bootstrap-admin-template/app-assets/vendors/js/forms/repeater/jquery.repeater.min.js"></script>
    <script src="<?= base_url() ?>assets/js/stisla.js"></script>

    <!-- JS Libraies -->
    <script src="<?= base_url() ?>assets/vendor/sweetalert/dist/sweetalert.min.js"></script>
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

    <script type='text/javascript'>
     google.charts.load('current', {
       'packages': ['geochart'],
       // Note: Because markers require geocoding, you'll need a mapsApiKey.
       // See: https://developers.google.com/chart/interactive/docs/basic_load_libs#load-settings
       'mapsApiKey': 'AIzaSyAOVYRIgupAurZup5y1PRh8Ismb1A3lLao'
     });
     google.charts.setOnLoadCallback(drawMarkersMap);

      function drawMarkersMap() {
      var data = google.visualization.arrayToDataTable([
        ['City',   'Population', 'Area'],
        ['Rome',      2761477,    1285.31],
        ['Milan',     1324110,    181.76],
        ['Naples',    959574,     117.27],
        ['Turin',     907563,     130.17],
        ['Palermo',   655875,     158.9],
        ['Genoa',     607906,     243.60],
        ['Bologna',   380181,     140.7],
        ['Florence',  371282,     102.41],
        ['Fiumicino', 67370,      213.44],
        ['Anzio',     52192,      43.43],
        ['Ciampino',  38262,      11]
      ]);

      var options = {
        region: 'IT',
        displayMode: 'markers',
        colorAxis: {colors: ['green', 'blue']}
      };

      var chart = new google.visualization.GeoChart(document.getElementById('chart_div'));
      chart.draw(data, options);
    };
    </script>

    <script>
        <?php
            function _tanggal($tanggal){
                $bulan = array (
                    1 =>   'Januari',
                    'Ferbuari',
                    'Maret',
                    'April',
                    'Mei',
                    'Juni',
                    'Juli',
                    'Agustus',
                    'September',
                    'Oktober',
                    'November',
                    'Desember'
                );
             
                return $bulan[(int)$tanggal];
            }
        ?>

        function number_format(number, decimals, dec_point, thousands_sep) {
        // *     example: number_format(1234.56, 2, ',', ' ');
        // *     return: '1 234,56'
            number = (number + '').replace(',', '').replace(' ', '');
            var n = !isFinite(+number) ? 0 : +number,
                    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                    s = '',
                    toFixedFix = function (n, prec) {
                        var k = Math.pow(10, prec);
                        return '' + Math.round(n * k) / k;
                    };
            // Fix for IE parseFloat(0.55).toFixed(0) = 0;
            s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
            if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
            }
            if ((s[1] || '').length < prec) {
                s[1] = s[1] || '';
                s[1] += new Array(prec - s[1].length + 1).join('0');
            }
            return s.join(dec);
        }

        var statistics_chart = document.getElementById("myChart2").getContext('2d');
        if(statistics_chart){
            var myChart = new Chart(statistics_chart, {
            type: 'line',
            data: {
                labels: [<?php foreach($data_chart_opex as $value) { echo '"'._tanggal($value->month).'",'; } ?>],
                datasets: [{
                label: 'Pemasukan',
                data: [<?php foreach($data_chart_opex as $value) { echo $value->pemasukan.','; } ?>],
                borderWidth: 5,
                borderColor: '#6777ef',
                backgroundColor: 'transparent',
                pointBackgroundColor: '#fff',
                pointBorderColor: '#6777ef',
                pointRadius: 4
                }]
            },
            options: {
                legend: {
                display: false
                },
                scales: {
                    yAxes: [{
                        gridLines: {
                        display: false,
                        drawBorder: false,
                        },
                        ticks: {
                            beginAtZero:true,
                            callback: function(value, index, values) {
                                return 'RP. ' + number_format(value);
                            }
                        }
                    }],
                    xAxes: [{
                        gridLines: {
                        color: '#fbfbfb',
                        lineWidth: 2
                        }
                    }]
                },
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, chart){
                            var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                            return datasetLabel + ': RP. ' + number_format(tooltipItem.yLabel, 2);
                        }
                    }
                },
            }
            });
        }
    </script>
</body>
</html>
