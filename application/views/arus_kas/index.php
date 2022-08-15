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
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">No ID</th>
                                        <th>Keterangan</th>
                                        <th><?= 'DES ' . date('y', mktime(0, 0, 0, 0,0 , date("Y"))) ?></th>
                                        <th>SD <?= 'DES ' . date('y', mktime(0, 0, 0, 0,0 , date("Y"))) ?></th>
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
                                                if($no == 1){
                                                    echo '<td colspan="14">I. AKTIVITAS OPERASI <br class="pt-1"> KAS DITERIMA DARI</td>';
                                                }
                                                if($no == 15){
                                                    echo '<td colspan="14">	II. AKTIVITAS INVESTASI <br class="pt-1"> KAS DIKELUARKAN UNTUK</td>';
                                                }
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