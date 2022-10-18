<?= $this->session->flashdata('message'); ?>
<?php
    $bulanTahun =  month_name(periode_to_month($perioda)) . ' ' .date('M Y', mktime(0, 0, 0, date("m")-1, date("d"), date("Y") - 1));
?>
<section class="section">
    <div class="section-header">
        <h1>Laporan Aktivitas</h1>
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
                            <a class="font-weight-600 dropdown-toggle" data-toggle="dropdown" href="#" id="orders-month" aria-expanded="false"><?= month_name(periode_to_month($perioda)) ?></a>
                            <ul class="dropdown-menu dropdown-menu-sm periode" x-placement="bootom-start">
                                <li class="dropdown-title">Select Month</li>
                                <li><a href="<?= base_url('Admin/laporan/aktivitas?periode=jan' . date('y')) ?>" class="dropdown-item <?= periode_to_month($perioda) == '1' ? 'active' : '' ?>">January</a></li>
                                <li><a href="<?= base_url('Admin/laporan/aktivitas?periode=feb' . date('y')) ?>" class="dropdown-item <?= periode_to_month($perioda) == '2' ? 'active' : '' ?>">February</a></li>
                                <li><a href="<?= base_url('Admin/laporan/aktivitas?periode=mar' . date('y')) ?>" class="dropdown-item <?= periode_to_month($perioda) == '3' ? 'active' : '' ?>">March</a></li>
                                <li><a href="<?= base_url('Admin/laporan/aktivitas?periode=apr' . date('y')) ?>" class="dropdown-item <?= periode_to_month($perioda) == '4' ? 'active' : '' ?>">April</a></li>
                                <li><a href="<?= base_url('Admin/laporan/aktivitas?periode=mei' . date('y')) ?>" class="dropdown-item <?= periode_to_month($perioda) == '5' ? 'active' : '' ?>">May</a></li>
                                <li><a href="<?= base_url('Admin/laporan/aktivitas?periode=jun' . date('y')) ?>" class="dropdown-item <?= periode_to_month($perioda) == '6' ? 'active' : '' ?>">June</a></li>
                                <li><a href="<?= base_url('Admin/laporan/aktivitas?periode=jul' . date('y')) ?>" class="dropdown-item <?= periode_to_month($perioda) == '7' ? 'active' : '' ?>">July</a></li>
                                <li><a href="<?= base_url('Admin/laporan/aktivitas?periode=ags' . date('y')) ?>" class="dropdown-item <?= periode_to_month($perioda) == '8' ? 'active' : '' ?>">August</a></li>
                                <li><a href="<?= base_url('Admin/laporan/aktivitas?periode=sep' . date('y')) ?>" class="dropdown-item <?= periode_to_month($perioda) == '9' ? 'active' : '' ?>">September</a></li>
                                <li><a href="<?= base_url('Admin/laporan/aktivitas?periode=okt' . date('y')) ?>" class="dropdown-item <?= periode_to_month($perioda) == '10' ? 'active' : '' ?>">October</a></li>
                                <li><a href="<?= base_url('Admin/laporan/aktivitas?periode=nov' . date('y')) ?>" class="dropdown-item <?= periode_to_month($perioda) == '11' ? 'active' : '' ?>">November</a></li>
                                <li><a href="<?= base_url('Admin/laporan/aktivitas?periode=des' . date('y')) ?>" class="dropdown-item <?= periode_to_month($perioda) == '12' ? 'active' : '' ?>">December</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col d-flex justify-content-between">
                                <div>
                                    <a class="btn btn-primary mb-3" 
                                        href="<?= base_url('Admin/laporan/aktivitas/createexcel?periode=' . $perioda) ?>">Export Data</a>
                                    <a class="btn btn-primary mb-3 "
                                        href="<?= base_url('Admin/laporan/aktivitas/cetak?periode=' . $perioda) ?>" target="_blank">Cetak Laporan</a>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-laporan">
                                <thead>
                                    <tr>
                                    <th class="text-center">NO</th>
                                        <th>Uraian</th>
                                        <th><?= 'Des ' . date('Y', mktime(0, 0, 0, 0,0 , date("Y")))?></th>
                                        <th>SD <?= 'Des ' . date('Y', mktime(0, 0, 0, 0,0 , date("Y")))?></th>
                                        <th><?= month_name(periode_to_month($perioda)) . ' ' . date('Y') ?></th>
                                        <th>SD <?= month_name(periode_to_month($perioda)) . ' ' . date('Y') ?></th>
                                        <th>RKA <?= month_name(periode_to_month($perioda)) . ' ' . date('Y') ?> (1)</th>
                                        <th>RKA SD <?= month_name(periode_to_month($perioda)) . ' ' . date('Y') ?> (2)</th>
                                        <th>Realisasi <?= month_name(periode_to_month($perioda)) . ' ' . date('Y') ?> (3)</th>
                                        <th>Realisasi SD <?= month_name(periode_to_month($perioda)) . ' ' . date('Y') ?> (4)</th>
                                        <th>RKA <?= $bulanTahun ?> (5)</th>
                                        <th>RKA SD <?= $bulanTahun ?> (6)</th>
                                        <th>(3:1) % RKA <?= month_name(periode_to_month($perioda)) . ' ' . date('Y') ?></th>
                                        <th>(4:2) % RKA SD <?= month_name(periode_to_month($perioda)) . ' ' . date('Y') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php foreach($aktivitas as $a): ?>
                                    <?php
                                        echo $no == 1 ? '<tr><td colspan="14">PERUBAHAN ASET NETO TIDAK TERIKAT</td></tr>' : '';
                                        echo $no == 1 ? '<tr><td colspan="14">PENDAPATAN</td></tr>' : '';
                                        echo $no == 4 ? '<tr><td colspan="14">ALOKASI BUMN PEDULI DAN ASET NETO YANG BERAKHIR</td></tr>' : '';
                                        echo $no == 10 ? '<tr><td colspan="14">BEBAN</td></tr>' : '';
                                        echo $no == 19 ? '<tr><td colspan="14">PERUBAHAN ASET NETO TERIKAT TEMPORER</td></tr>' : '';
                                        echo $no == 22 ? '<tr><td colspan="14">PERUBAHAN ASET NETO TERIKAT PERMANEN</td></tr>' : '';
                                    ?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td><?= $a['keterangan'] ?></td>
                                        <td><?= number_format($a['des' . date('y', mktime(0, 0, 0, 0,0 , date("Y"))) ]) ?></td>
                                        <td><?= number_format($a['sddes' . date('y', mktime(0, 0, 0, 0,0 , date("Y"))) ]) ?></td>
                                        <td><?= number_format($a[$perioda]) ?></td>
                                        <td><?= number_format($a['sd' . $perioda]) ?></td>
                                        <td><?= number_format($a['rkajan' . date('y')]) ?></td>
                                        <td><?= number_format($a['rkasdjan' . date('y')]) ?></td>
                                        <td><?= number_format($a[$perioda]) ?></td>
                                        <td><?= number_format($a['sd' . $perioda]) ?></td>
                                        <td><?= number_format($a['rkajan' . date('y', mktime(0, 0, 0, 0,0 , date("Y")))]) ?></td>
                                        <td><?= number_format($a['rkasdjan' . date('y', mktime(0, 0, 0, 0,0 , date("Y")))]) ?></td>
                                        <td><?= number_format($a['prosen' . $perioda]) ?></td>
                                        <td><?= number_format($a['prosensd' . $perioda]) ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>