<?= $this->session->flashdata('message'); ?>
<?php
    if(date('Y-m-d') >= date('Y-m-01', mktime(0, 0, 0, date("m"), date("d"), date("Y"))) AND date('Y-m-d') < date('Y-m-01', mktime(0, 0, 0, date("m")+1, date("d"),   date("Y")))){
        $bulanTahun =  date('M Y', mktime(0, 0, 0, date("m")-1, date("d"), date("Y") - 1));
    }
?>
<section class="section">
    <div class="section-header">
        <h1>Management Data Laporan</h1>
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
                        <h4>1. TINGKAT PENGEMBALIAN PINJAMAN MITRA BINAAN</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col d-flex justify-content-between">
                                <?php if(uri_string() == 'admin/laporan/Kinerja'): ?>
                                <?php endif; ?>
                                <div>
                                    <a class="btn btn-primary mb-3" 
                                        href="<?= base_url('Admin/Laporan/Kinerja/CreateExcel') ?>">Export Data</a>
                                    <a class="btn btn-primary mb-3 "
                                        href="<?= base_url('Admin/Laporan/Kinerja/Cetak') ?>">Cetak Laporan</a>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">NO</th>
                                        <th>Sektor</th>
                                        <th><?= $bulan ?> (Rp.)</th>
                                        <th>Prosen (%)</th>
                                        <th>Timbang (Rp) </th>
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
                                    <?php
                                    $no = 1;
                                    foreach ($dataRow as $value) {
                                        ?>
                                        <tr>
                                            <td class="text-center"><?= $no++ ?></td>
                                            <td><?= $value['sektor'] ?></td>
                                            <td><?= number_format($value['perioda'], 0, ',', '.') ?></td>
                                            <td><?= number_format($value['prosen'], 2, ',', '.') ?></td>
                                            <td><?= number_format($value['timbang'], 0, ',', '.') ?></td>
                                            <td><?= number_format($value['rkajan22'], 0, ',', '.') ?></td>
                                            <td><?= number_format($value['rkasdjan22'], 0, ',', '.') ?></td>
                                            <td><?= number_format($value['totsaldo'], 0, ',', '.') ?></td>
                                            <td><?= number_format($value['totsaldo2'], 0, ',', '.') ?></td>
                                            <td><?= number_format($value['rkajan21'], 0, ',', '.') ?></td>
                                            <td><?= number_format($value['rkasdjan21'], 0, ',', '.') ?></td>
                                            <td><?= number_format($value['prosen1'], 0, ',', '.') ?></td>
                                            <td><?= number_format($value['prosensd'], 0, ',', '.') ?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>

                            <div class="pb-3">
                            <th>Kolektibilitas   </th>
                                <th> = </th>
                            <th><?php echo number_format( $timbang);?></th>
                                <th> / </th>
                                <th> <?php echo number_format( $totsaldo);?> </th>
                                <th>  = </th>
                                <th> <?php echo number_format( $kolex);?></th>
                                <th>%</th> 
                                
                                <font color="blue">
                                <th> SKOR  </th>
                                <th> =  </th>
                                <th><?php echo number_format( $skor);?></th>
                                </font>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>2. EFFEKTIVITAS PENYALURAN DANA</h4>
                    </div>
                    <div class="card-body">
                        <h6>2.1 DANA YANG DISALURKAN </h6>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">NO</th>
                                        <th>Keterangan</th>
                                        <th><?= $bulan ?> (Rp.)</th>
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
                                    <?php
                                    $no = 1;
                                    foreach ($dana as $value) {
                                        ?>
                                        <tr>
                                            <td class="text-center"><?= $no++ ?></td>
                                            <td><?= $value[0] ?></td>
                                            <td><?= number_format($value[1], 0, ',', '.') ?></td>
                                            <td><?= number_format($value[2], 0, ',', '.') ?></td>
                                            <td><?= number_format($value[3], 0, ',', '.') ?></td>
                                            <td><?= number_format($value[4], 0, ',', '.') ?></td>
                                            <td><?= number_format($value[5], 0, ',', '.') ?></td>
                                            <td><?= number_format($value[6], 0, ',', '.') ?></td>
                                            <td><?= number_format($value[7], 0, ',', '.') ?></td>
                                            <td><?= number_format($value[8], 0, ',', '.') ?></td>
                                            <td><?= number_format($value[9], 0, ',', '.') ?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <h6 class="pt-5">2.2 DANA TERSEDIA </h6>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">NO</th>
                                        <th>Keterangan</th>
                                        <th><?= $bulan ?> (Rp.)</th>
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
                                    <?php
                                    $no = 1;
                                    foreach ($danatersedia as $value) {
                                        ?>
                                        <tr>
                                            <td class="text-center"><?= $no++ ?></td>
                                            <td><?= $value[0] ?></td>
                                            <td><?= number_format($value[1], 0, ',', '.') ?></td>
                                            <td><?= number_format($value[2], 0, ',', '.') ?></td>
                                            <td><?= number_format($value[3], 0, ',', '.') ?></td>
                                            <td><?= number_format($value[4], 0, ',', '.') ?></td>
                                            <td><?= number_format($value[5], 0, ',', '.') ?></td>
                                            <td><?= number_format($value[6], 0, ',', '.') ?></td>
                                            <td><?= number_format($value[7], 0, ',', '.') ?></td>
                                            <td><?= number_format($value[8], 0, ',', '.') ?></td>
                                            <td><?= number_format($value[9], 0, ',', '.') ?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <div class="pb-3">
                            <th>Prosentase Efektivitas Penyaluran Dana = Jumlah Dana Yg Disalurkan / Jumlah Dana tersedia = 
<?php  echo number_format($JumlahDanaYgDisalurkan); ?> / <?php echo number_format($jumlahDanaTersedia); ?> = <?php  echo number_format($prosenDanaDisalurkan); ?> % 
</th>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</section>
