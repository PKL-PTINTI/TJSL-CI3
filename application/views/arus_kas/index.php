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
                    <div class="card-header">
                        <h4><?= $header; ?></h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col d-flex justify-content-between">
                                <div>
                                    <a class="btn btn-primary mb-3" 
                                        href="<?= base_url('Admin/Laporan/Aruskas/CreateExcel') ?>">Export Data</a>
                                    <a class="btn btn-primary mb-3" 
                                        href="<?= base_url('Admin/Laporan/Aruskas/Cetak') ?>" target="_blank">Cetak Laporan</a>
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
                                        <th><?= $bulan ?></th>
                                        <th>SD <?= $bulan ?></th>
                                        <th>RKA <?= $bulan ?>(1)</th>
                                        <th>RKA-<?= $bulan ?>(2)</th>
                                        <th>Realisasi <?= $bulan ?>(3)</th>
                                        <th>Realisasi <?= $bulan ?>(4)</th>
                                        <th>RKA Juni 2021(5)</th>
                                        <th>RKA-Juni 2021(6)</th>
                                        <th>(3:1)% RKA <?= $bulan ?></th>
                                        <th>(4:2)% RKA-<?= $bulan ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
                                    foreach ($aruskas as $ak) : ?>
                                        <tr>
                                            <?php
                                                echo $no == 1 ? '<td colspan="14"> I. AKTIVITAS OPERASI <br class="pt-1"></td></tr>' : '';
                                                echo $no == 1 ? '<td colspan="14"> KAS DITERIMA DARI <br class="pt-1"></td></tr>' : '';
                                                echo $no == 7 ? '<td colspan="14"> KAS DIKELUARKAN UNTUK <br class="pt-1"></td></tr>' : '';
                                                echo $no == 15 ? '<td colspan="14"> II. AKTIVITAS INVESTASI <br class="pt-1"></td></tr>' : '';
                                                echo $no == 15 ? '<td colspan="14"> KAS DIKELUARKAN UNTUK <br class="pt-1"></td></tr>' : '';  
                                            ?>
                                            <td class="text-center"><?= $ak['id'] ?></td>
                                            <td><?= $ak['keterangan'] ?></td>
                                            <td><?= $ak['des' . date('y', mktime(0, 0, 0, 0,0 , date("Y")))] ?></td>
                                            <td><?= $ak['sddes' . date('y', mktime(0, 0, 0, 0,0 , date("Y")))] ?></td>
                                            <td><?= $ak[$perioda] ?></td>
                                            <td><?= $ak['sd' . $perioda] ?></td>
                                            <td><?= $ak['rkajan' . date('y')] ?></td>
                                            <td><?= $ak['rkasdjan' . date('y')] ?></td>
                                            <td><?= $ak[$perioda] ?></td>
                                            <td><?= $ak['sd' . $perioda] ?></td>
                                            <td><?= $ak['rkajan' . date('y', mktime(0, 0, 0, 0,0 , date("Y")))] ?></td>
                                            <td><?= $ak['rkasdjan' . date('y', mktime(0, 0, 0, 0,0 , date("Y")))] ?></td>
                                            <td><?= $ak['prosen' . $perioda] ?></td>
                                            <td><?= $ak['prosensd' . $perioda] ?></td>
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