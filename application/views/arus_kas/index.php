<?= $this->session->flashdata('message'); ?>
<section class="section">
    <div class="section-header">
        <h1>Laporan Arus Kas</h1>
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
                                <li><a href="<?= base_url('Admin/laporan/arusKas?periode=jan' . date('y')) ?>" class="dropdown-item <?= periode_to_month($perioda) == '1' ? 'active' : '' ?>">January</a></li>
                                <li><a href="<?= base_url('Admin/laporan/arusKas?periode=feb' . date('y')) ?>" class="dropdown-item <?= periode_to_month($perioda) == '2' ? 'active' : '' ?>">February</a></li>
                                <li><a href="<?= base_url('Admin/laporan/arusKas?periode=mar' . date('y')) ?>" class="dropdown-item <?= periode_to_month($perioda) == '3' ? 'active' : '' ?>">March</a></li>
                                <li><a href="<?= base_url('Admin/laporan/arusKas?periode=apr' . date('y')) ?>" class="dropdown-item <?= periode_to_month($perioda) == '4' ? 'active' : '' ?>">April</a></li>
                                <li><a href="<?= base_url('Admin/laporan/arusKas?periode=mei' . date('y')) ?>" class="dropdown-item <?= periode_to_month($perioda) == '5' ? 'active' : '' ?>">May</a></li>
                                <li><a href="<?= base_url('Admin/laporan/arusKas?periode=jun' . date('y')) ?>" class="dropdown-item <?= periode_to_month($perioda) == '6' ? 'active' : '' ?>">June</a></li>
                                <li><a href="<?= base_url('Admin/laporan/arusKas?periode=jul' . date('y')) ?>" class="dropdown-item <?= periode_to_month($perioda) == '7' ? 'active' : '' ?>">July</a></li>
                                <li><a href="<?= base_url('Admin/laporan/arusKas?periode=ags' . date('y')) ?>" class="dropdown-item <?= periode_to_month($perioda) == '8' ? 'active' : '' ?>">August</a></li>
                                <li><a href="<?= base_url('Admin/laporan/arusKas?periode=sep' . date('y')) ?>" class="dropdown-item <?= periode_to_month($perioda) == '9' ? 'active' : '' ?>">September</a></li>
                                <li><a href="<?= base_url('Admin/laporan/arusKas?periode=okt' . date('y')) ?>" class="dropdown-item <?= periode_to_month($perioda) == '10' ? 'active' : '' ?>">October</a></li>
                                <li><a href="<?= base_url('Admin/laporan/arusKas?periode=nov' . date('y')) ?>" class="dropdown-item <?= periode_to_month($perioda) == '11' ? 'active' : '' ?>">November</a></li>
                                <li><a href="<?= base_url('Admin/laporan/arusKas?periode=des' . date('y')) ?>" class="dropdown-item <?= periode_to_month($perioda) == '12' ? 'active' : '' ?>">December</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col d-flex justify-content-between">
                                <div>
                                    <a class="btn btn-primary mb-3" 
                                        href="<?= base_url('Admin/laporan/arusKas/createexcel?periode=' . $perioda) ?>">Export Data</a>
                                    <a class="btn btn-primary mb-3" 
                                        href="<?= base_url('Admin/laporan/arusKas/cetak?periode=' . $perioda) ?>" target="_blank">Cetak Laporan</a>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Keterangan</th>
                                        <th><?= 'Des ' . date('y', mktime(0, 0, 0, 0,0 , date("Y"))) ?></th>
                                        <th>SD <?= 'Des ' . date('y', mktime(0, 0, 0, 0,0 , date("Y"))) ?></th>
                                        <th><?= month_name(periode_to_month($perioda)) . ' ' . date('Y') ?></th>
                                        <th>SD <?= month_name(periode_to_month($perioda)) . ' ' . date('Y') ?></th>
                                        <th>RKA <?= month_name(periode_to_month($perioda)) . ' ' . date('Y') ?>(1)</th>
                                        <th>RKA-<?= month_name(periode_to_month($perioda)) . ' ' . date('Y') ?>(2)</th>
                                        <th>Realisasi <?= month_name(periode_to_month($perioda)) . ' ' . date('Y') ?>(3)</th>
                                        <th>Realisasi <?= month_name(periode_to_month($perioda)) . ' ' . date('Y') ?>(4)</th>
                                        <th>RKA Juni 2021(5)</th>
                                        <th>RKA-Juni 2021(6)</th>
                                        <th>(3:1)% RKA <?= month_name(periode_to_month($perioda)) . ' ' . date('Y') ?></th>
                                        <th>(4:2)% RKA-<?= month_name(periode_to_month($perioda)) . ' ' . date('Y') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
                                    foreach ($aruskas as $ak) : ?>
                                        <tr>
                                            <?php
                                                echo $no == 1 ? '<td colspan="14"> I. AKTIVITAS OPERASI <br class="pt-1"></td></tr>' : '';
                                                echo $no == 1 ? '<td colspan="14"> KAS DITERIMA DARI <br class="pt-1"></td></tr>' : '';
                                                echo $no == 6 ? '<td colspan="14"> KAS DIKELUARKAN UNTUK <br class="pt-1"></td></tr>' : '';
                                                echo $no == 15 ? '<td colspan="14"> II. AKTIVITAS INVESTASI <br class="pt-1"></td></tr>' : '';
                                                echo $no == 15 ? '<td colspan="14"> KAS DIKELUARKAN UNTUK <br class="pt-1"></td></tr>' : '';  
                                            ?>
                                            <td class="text-center"><?= $ak['id'] ?></td>
                                            <td><?= $ak['keterangan'] ?></td>
                                            <td><?= number_format($ak['des' . date('y', mktime(0, 0, 0, 0,0 , date("Y")))]) ?></td>
                                            <td><?= number_format($ak['sddes' . date('y', mktime(0, 0, 0, 0,0 , date("Y")))]) ?></td>
                                            <td><?= number_format($ak[$perioda]) ?></td>
                                            <td><?= number_format($ak['sd' . $perioda]) ?></td>
                                            <td><?= number_format($ak['rkajan' . date('y')]) ?></td>
                                            <td><?= number_format($ak['rkasdjan' . date('y')]) ?></td>
                                            <td><?= number_format($ak[$perioda]) ?></td>
                                            <td><?= number_format($ak['sd' . $perioda]) ?></td>
                                            <td><?= number_format($ak['rkajan' . date('y', mktime(0, 0, 0, 0,0 , date("Y")))]) ?></td>
                                            <td><?= number_format($ak['rkasdjan' . date('y', mktime(0, 0, 0, 0,0 , date("Y")))]) ?></td>
                                            <td><?= number_format($ak['prosen' . $perioda]) ?></td>
                                            <td><?= number_format($ak['prosensd' . $perioda]) ?></td>
                                        </tr>
                                    <?php  $no++; endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>