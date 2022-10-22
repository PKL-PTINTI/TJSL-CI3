<?= $this->session->flashdata('message'); ?>
<?php
    $bulanTahun =  month_name(periode_to_month($perioda)) . ' ' .date('M Y', mktime(0, 0, 0, date("m")-1, date("d"), date("Y") - 1));
?>
<section class="section">
    <div class="section-header">
        <h1>Laporan Posisi Keuangan</h1>
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
                                <li><a href="<?= base_url('Admin/laporan/posisiKeuangan?periode=jan' . date('y')) ?>" class="dropdown-item <?= periode_to_month($perioda) == '1' ? 'active' : '' ?>">January</a></li>
                                <li><a href="<?= base_url('Admin/laporan/posisiKeuangan?periode=feb' . date('y')) ?>" class="dropdown-item <?= periode_to_month($perioda) == '2' ? 'active' : '' ?>">February</a></li>
                                <li><a href="<?= base_url('Admin/laporan/posisiKeuangan?periode=mar' . date('y')) ?>" class="dropdown-item <?= periode_to_month($perioda) == '3' ? 'active' : '' ?>">March</a></li>
                                <li><a href="<?= base_url('Admin/laporan/posisiKeuangan?periode=apr' . date('y')) ?>" class="dropdown-item <?= periode_to_month($perioda) == '4' ? 'active' : '' ?>">April</a></li>
                                <li><a href="<?= base_url('Admin/laporan/posisiKeuangan?periode=mei' . date('y')) ?>" class="dropdown-item <?= periode_to_month($perioda) == '5' ? 'active' : '' ?>">May</a></li>
                                <li><a href="<?= base_url('Admin/laporan/posisiKeuangan?periode=jun' . date('y')) ?>" class="dropdown-item <?= periode_to_month($perioda) == '6' ? 'active' : '' ?>">June</a></li>
                                <li><a href="<?= base_url('Admin/laporan/posisiKeuangan?periode=jul' . date('y')) ?>" class="dropdown-item <?= periode_to_month($perioda) == '7' ? 'active' : '' ?>">July</a></li>
                                <li><a href="<?= base_url('Admin/laporan/posisiKeuangan?periode=ags' . date('y')) ?>" class="dropdown-item <?= periode_to_month($perioda) == '8' ? 'active' : '' ?>">August</a></li>
                                <li><a href="<?= base_url('Admin/laporan/posisiKeuangan?periode=sep' . date('y')) ?>" class="dropdown-item <?= periode_to_month($perioda) == '9' ? 'active' : '' ?>">September</a></li>
                                <li><a href="<?= base_url('Admin/laporan/posisiKeuangan?periode=okt' . date('y')) ?>" class="dropdown-item <?= periode_to_month($perioda) == '10' ? 'active' : '' ?>">October</a></li>
                                <li><a href="<?= base_url('Admin/laporan/posisiKeuangan?periode=nov' . date('y')) ?>" class="dropdown-item <?= periode_to_month($perioda) == '11' ? 'active' : '' ?>">November</a></li>
                                <li><a href="<?= base_url('Admin/laporan/posisiKeuangan?periode=des' . date('y')) ?>" class="dropdown-item <?= periode_to_month($perioda) == '12' ? 'active' : '' ?>">December</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col d-flex justify-content-between">
                                <div>
                                    <a class="btn btn-primary mb-3" 
                                        href="<?= base_url('Admin/laporan/posisiKeuangan/createexcel?periode=' . $perioda) ?>">Export Data</a>
                                    <a class="btn btn-primary mb-3 "
                                        href="<?= base_url('Admin/laporan/posisiKeuangan/cetak?periode=' . $perioda) ?>" target="_blank">Cetak Laporan</a>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">NO</th>
                                        <th>Nama</th>
                                        <th><?= 'Des' . date('Y', mktime(0, 0, 0, 0,0 , date("Y")))?></th>
                                        <th><?= month_name(periode_to_month($perioda)) . ' ' . date('Y') ?></th>
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
                                    <?php foreach($neraca_deskripsi as $d): ?>
                                    <tr>
                                        <?php
                                            echo $no == 1 ? '<td colspan="4"> ASET <br class="pt-1"></td></tr>' : '';
                                            echo $no == 1 ? '<td colspan="4"> ASET LANCAR <br class="pt-1"></td></tr>' : '';
                                            echo $no == 6 ? '<td colspan="4"> ASET TETAP BERSIH <br class="pt-1"></td></tr>' : '';
                                            echo $no == 9 ? '<td colspan="4"> ASET LAIN-LAIN <br class="pt-1"></td></tr>' : '';
                                            echo $no == 13 ? '<td colspan="4"> LIABILITAS DAN ASET NETO <br class="pt-1"></td></tr>' : '';
                                            echo $no == 13 ? '<td colspan="4"> LIABILITAS <br class="pt-1"></td></tr>' : '';
                                            echo $no == 13 ? '<td colspan="4"> LIABILITAS JANGKA PENDEK <br class="pt-1"></td></tr>' : '';
                                            echo $no == 15 ? '<td colspan="4"> LIABILITAS JANGKA PANJANG <br class="pt-1"></td></tr>' : '';
                                            echo $no == 17 ? '<td colspan="4"> ASET NETO <br class="pt-1"></td></tr>' : '';
                                        ?>
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td><?= $d['nama'] ?></td>
                                        <td><?= number_format($neraca_des[$d['nama_field']]) ?></td>
                                        <td><?= number_format($neraca_perioda[$d['nama_field']]) ?></td>
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