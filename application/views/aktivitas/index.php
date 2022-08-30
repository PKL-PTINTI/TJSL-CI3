<?= $this->session->flashdata('message'); ?>
<?php
    if(date('Y-m-d') >= date('Y-m-01', mktime(0, 0, 0, date("m"), date("d"), date("Y"))) AND date('Y-m-d') < date('Y-m-01', mktime(0, 0, 0, date("m")+1, date("d"),   date("Y")))){
        $bulanTahun =  date('M Y', mktime(0, 0, 0, date("m")-1, date("d"), date("Y") - 1));
    }
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
                    <div class="card-header">
                        <h4><?= $header; ?> <span id="header"></span></h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col d-flex justify-content-between">
                                <div>
                                    <a class="btn btn-primary mb-3" 
                                        href="<?= base_url('Admin/Laporan/Aktivitas/CreateExcel') ?>">Export Data</a>
                                    <a class="btn btn-primary mb-3 "
                                        href="<?= base_url('Admin/Laporan/Aktivitas/Cetak') ?>" target="_blank">Cetak Laporan</a>
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
                                        <th><?= $bulan ?></th>
                                        <th>SD <?= $bulan ?></th>
                                        <th>RKA <?= $bulan ?> (1)</th>
                                        <th>RKA SD <?= $bulan ?> (2)</th>
                                        <th>Realisasi <?= $bulan ?> (3)</th>
                                        <th>Realisasi SD <?= $bulan ?> (4)</th>
                                        <th>RKA <?= $bulanTahun ?> (5)</th>
                                        <th>RKA SD <?= $bulanTahun ?> (6)</th>
                                        <th>(3:1) % RKA <?= $bulan ?></th>
                                        <th>(4:2) % RKA SD <?= $bulan ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <tr>
                                        <td colspan="14">PERUBAHAN ASET NETO TIDAK TERIKAT <br> PENDAPATAN</td>
                                    </tr>
                                    <?php foreach($aktivitas as $a): ?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td><?= $a['keterangan'] ?></td>
                                        <td><?= $a['des' . date('y', mktime(0, 0, 0, 0,0 , date("Y"))) ] ?></td>
                                        <td><?= $a['sddes' . date('y', mktime(0, 0, 0, 0,0 , date("Y"))) ] ?></td>
                                        <td><?= $a[$perioda] ?></td>
                                        <td><?= $a['sd' . $perioda] ?></td>
                                        <td><?= $a['rkajan' . date('y')] ?></td>
                                        <td><?= $a['rkasdjan' . date('y')] ?></td>
                                        <td><?= $a[$perioda] ?></td>
                                        <td><?= $a['sd' . $perioda] ?></td>
                                        <td><?= $a['rkajan' . date('y', mktime(0, 0, 0, 0,0 , date("Y")))] ?></td>
                                        <td><?= $a['rkasdjan' . date('y', mktime(0, 0, 0, 0,0 , date("Y")))] ?></td>
                                        <td><?= $a['prosen' . $perioda] ?></td>
                                        <td><?= $a['prosensd' . $perioda] ?></td>
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