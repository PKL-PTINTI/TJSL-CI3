<?= $this->session->flashdata('message'); ?>
<?php
    if(date('Y-m-d') >= date('Y-m-01', mktime(0, 0, 0, date("m"), date("d"), date("Y"))) AND date('Y-m-d') < date('Y-m-01', mktime(0, 0, 0, date("m")+1, date("d"),   date("Y")))){
        $bulanTahun =  date('M Y', mktime(0, 0, 0, date("m")-1, date("d"), date("Y") - 1));
    }
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
                    <div class="card-header">
                        <h4><?= $header; ?> <span id="header"></span></h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col d-flex justify-content-between">
                                <div>
                                    <a class="btn btn-primary mb-3" 
                                        href="<?= base_url('Admin/laporan/Posisikeuangan/CreateExcel') ?>">Export Data</a>
                                    <a class="btn btn-primary mb-3 "
                                        href="<?= base_url('Admin/laporan/Posisikeuangan/Cetak') ?>" target="_blank">Cetak Laporan</a>
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
                                        <th><?= $bulan ?></th>
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
                                    <?php foreach($neraca as $d): ?>
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
                                        <td><?= $d['nama_akun'] ?></td>
                                        <td><?= number_format($d['des' . date('y', mktime(0, 0, 0, 0,0 , date("Y")))]) ?></td>
                                        <td><?= number_format($d[$perioda]) ?></td>
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