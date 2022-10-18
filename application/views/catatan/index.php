<?= $this->session->flashdata('message'); ?>
<style>
.periode {
    position: absolute;
    right: 0px;
    will-change: transform;
    top: 0px;
    left: -200px;
    transform: translate3d(-5px, -189px, 0px);
}
</style>
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
                            <a class="font-weight-600 dropdown-toggle" data-toggle="dropdown" href="#" id="orders-month" aria-expanded="false"><?= month_name(periode_to_month($perioda)) ?></a>
                            <ul class="dropdown-menu dropdown-menu-sm periode" x-placement="bootom-start">
                                <li class="dropdown-title">Select Month</li>
                                <li><a href="<?= base_url('Admin/laporan/catatan?periode=jan' . date('y')) ?>" class="dropdown-item <?= periode_to_month($perioda) == '1' ? 'active' : '' ?>">January</a></li>
                                <li><a href="<?= base_url('Admin/laporan/catatan?periode=feb' . date('y')) ?>" class="dropdown-item <?= periode_to_month($perioda) == '2' ? 'active' : '' ?>">February</a></li>
                                <li><a href="<?= base_url('Admin/laporan/catatan?periode=mar' . date('y')) ?>" class="dropdown-item <?= periode_to_month($perioda) == '3' ? 'active' : '' ?>">March</a></li>
                                <li><a href="<?= base_url('Admin/laporan/catatan?periode=apr' . date('y')) ?>" class="dropdown-item <?= periode_to_month($perioda) == '4' ? 'active' : '' ?>">April</a></li>
                                <li><a href="<?= base_url('Admin/laporan/catatan?periode=mei' . date('y')) ?>" class="dropdown-item <?= periode_to_month($perioda) == '5' ? 'active' : '' ?>">May</a></li>
                                <li><a href="<?= base_url('Admin/laporan/catatan?periode=jun' . date('y')) ?>" class="dropdown-item <?= periode_to_month($perioda) == '6' ? 'active' : '' ?>">June</a></li>
                                <li><a href="<?= base_url('Admin/laporan/catatan?periode=jul' . date('y')) ?>" class="dropdown-item <?= periode_to_month($perioda) == '7' ? 'active' : '' ?>">July</a></li>
                                <li><a href="<?= base_url('Admin/laporan/catatan?periode=ags' . date('y')) ?>" class="dropdown-item <?= periode_to_month($perioda) == '8' ? 'active' : '' ?>">August</a></li>
                                <li><a href="<?= base_url('Admin/laporan/catatan?periode=sep' . date('y')) ?>" class="dropdown-item <?= periode_to_month($perioda) == '9' ? 'active' : '' ?>">September</a></li>
                                <li><a href="<?= base_url('Admin/laporan/catatan?periode=okt' . date('y')) ?>" class="dropdown-item <?= periode_to_month($perioda) == '10' ? 'active' : '' ?>">October</a></li>
                                <li><a href="<?= base_url('Admin/laporan/catatan?periode=nov' . date('y')) ?>" class="dropdown-item <?= periode_to_month($perioda) == '11' ? 'active' : '' ?>">November</a></li>
                                <li><a href="<?= base_url('Admin/laporan/catatan?periode=des' . date('y')) ?>" class="dropdown-item <?= periode_to_month($perioda) == '12' ? 'active' : '' ?>">December</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col d-flex justify-content-between">
                                <div class="d-flex">
                                    <a class="btn btn-primary mb-3 mr-2" 
                                        href="<?= base_url('Admin/laporan/catatan/createexcel?periode=' . $perioda) ?>">Export Data</a>
                                    <a class="btn btn-primary mb-3 mr-3"
                                        href="<?= base_url('Admin/laporan/catatan/cetak?periode=' . $perioda) ?>" target="_blank">Cetak Laporan</a>
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
                                        <th>Akhir <?= month_name(periode_to_month($perioda)) . ' ' . date('Y') ?></th>
                                        <th>RKA <?= month_name(periode_to_month($perioda)) . ' ' . date('Y') ?> (1)</th>
                                        <th>RKA SD <?= month_name(periode_to_month($perioda)) . ' ' . date('Y') ?> (2)</th>
                                        <th>Realisasi <?= month_name(periode_to_month($perioda)) . ' ' . date('Y') ?> (3)</th>
                                        <th>Realisasi SD <?= month_name(periode_to_month($perioda)) . ' ' . date('Y') ?> (4)</th>
                                        <th>RKA <?= month_name(periode_to_month($perioda)) . ' ' . date('Y', mktime(0, 0, 0, 0, date("d"), date("Y"))) ?> (5)</th>
                                        <th>RKA SD <?= month_name(periode_to_month($perioda)) . ' ' . date('Y', mktime(0, 0, 0, 0, date("d"), date("Y"))) ?> (6)</th>
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