<?= $this->session->flashdata('message'); ?>
<?php
    if(date('Y-m-d') >= date('Y-m-01', mktime(0, 0, 0, date("m"), date("d"), date("Y"))) AND date('Y-m-d') < date('Y-m-01', mktime(0, 0, 0, date("m")+1, date("d"),   date("Y")))){
        $bulanTahun =  date('M Y', mktime(0, 0, 0, date("m")-1, date("d"), date("Y") - 1));
    }
?>
<section class="section">
    <div class="section-header">
        <h1>Catatan Atas Laporan Keuangan</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item"><?= $header ?></div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4><?= $header; ?> <span id="header"></span></h4>
                        <div class="dropdown d-inline">
                            <a class="font-weight-600 dropdown-toggle" data-toggle="dropdown" href="#" id="orders-month" aria-expanded="false">August</a>
                            <ul class="dropdown-menu dropdown-menu-sm" x-placement="bootom-end" style="position: absolute; transform: translate3d(0px, -86px, 0px); top: 0px; right: 0px; will-change: transform;">
                                <li class="dropdown-title">Select Month</li>
                                <li><a href="#" class="dropdown-item">January</a></li>
                                <li><a href="#" class="dropdown-item">February</a></li>
                                <li><a href="#" class="dropdown-item">March</a></li>
                                <li><a href="#" class="dropdown-item">April</a></li>
                                <li><a href="#" class="dropdown-item">May</a></li>
                                <li><a href="#" class="dropdown-item">June</a></li>
                                <li><a href="#" class="dropdown-item">July</a></li>
                                <li><a href="#" class="dropdown-item active">August</a></li>
                                <li><a href="#" class="dropdown-item">September</a></li>
                                <li><a href="#" class="dropdown-item">October</a></li>
                                <li><a href="#" class="dropdown-item">November</a></li>
                                <li><a href="#" class="dropdown-item">December</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col d-flex justify-content-between">
                                <div class="d-flex">
                                    <a class="btn btn-primary mb-3 mr-2" 
                                        href="<?= base_url('admin/laporan/catatan/createexcel') ?>">Export Data</a>
                                    <a class="btn btn-primary mb-3 mr-3"
                                        href="<?= base_url('admin/laporan/catatan/cetak') ?>" target="_blank">Cetak Laporan</a>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-laporan">
                                <thead>
                                    <tr>
                                        <th class="text-center">NO</th>
                                        <th>Keterangan</th>
                                        <th>Akhir <?= 'DES ' . date('Y', mktime(0, 0, 0, 0,0 , date("Y"))) ?></th>
                                        <th>Akhir <?= $perioda ?></th>
                                        <th>RKA <?= $perioda ?> (1)</th>
                                        <th>RKA SD <?= $perioda ?> (2)</th>
                                        <th>Realisasi <?= $perioda ?> (3)</th>
                                        <th>Realisasi SD <?= $perioda ?> (4)</th>
                                        <th>RKA <?= $bulanTahun ?> (5)</th>
                                        <th>RKA SD <?= $bulanTahun ?> (6)</th>
                                        <th>(3:1) % RKA JAN <?= date('y') ?></th>
                                        <th>(4:2) % RKA SD JAN <?= date('y') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php foreach ($catatan as $c): ?>
                                    <tr>
                                        <td class="text-center"><?= $c['id'] ?></td>
                                        <td><?= $c['keterangan'] ?></td>
                                        <td><?= number_format($c['des' . date('y', mktime(0, 0, 0, 0,0 , date("Y")))]) ?></td>
                                        <td><?= number_format($c[$perioda]) ?></td>
                                        <td><?= number_format($c['rkajan' . date('y')]) ?></td>
                                        <td><?= number_format($c['rkasdjan' . date('y')]) ?></td>
                                        <td><?= number_format($c[$perioda]) ?></td>
                                        <td><?= number_format($c[$perioda]) ?></td>
                                        <td><?= number_format($c['rkajan' . date('y', mktime(0, 0, 0, 0,0 , date("Y")))]) ?></td>
                                        <td><?= number_format($c['rkasdjan' . date('y', mktime(0, 0, 0, 0,0 , date("Y")))]) ?></td>
                                        <td><?= number_format($c['prosen' . $perioda]) ?></td>
                                        <td><?= number_format($c['prosensd' . $perioda]) ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>