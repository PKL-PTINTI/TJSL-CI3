<?= $this->session->flashdata('message'); ?>
<?php
    $bulanTahun =  date('M Y', mktime(0, 0, 0, date("m")-1, date("d"), date("Y") - 1));
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
                    <div class="card-header d-flex justify-content-between">
                        <h4>1. TINGKAT PENGEMBALIAN PINJAMAN MITRA BINAAN</h4>
                        <div class="dropdown d-inline">
                            <a class="font-weight-600 dropdown-toggle" data-toggle="dropdown" href="#" id="orders-month" aria-expanded="false"><?= month_name(periode_to_month($perioda)) ?></a>
                            <ul class="dropdown-menu dropdown-menu-sm periode" x-placement="bootom-start">
                                <li class="dropdown-title">Select Month</li>
                                <li><a href="<?= base_url('Admin/laporan/kinerja?periode=jan' . date('y')) ?>" class="dropdown-item <?= periode_to_month($perioda) == '1' ? 'active' : '' ?>">January</a></li>
                                <li><a href="<?= base_url('Admin/laporan/kinerja?periode=feb' . date('y')) ?>" class="dropdown-item <?= periode_to_month($perioda) == '2' ? 'active' : '' ?>">February</a></li>
                                <li><a href="<?= base_url('Admin/laporan/kinerja?periode=mar' . date('y')) ?>" class="dropdown-item <?= periode_to_month($perioda) == '3' ? 'active' : '' ?>">March</a></li>
                                <li><a href="<?= base_url('Admin/laporan/kinerja?periode=apr' . date('y')) ?>" class="dropdown-item <?= periode_to_month($perioda) == '4' ? 'active' : '' ?>">April</a></li>
                                <li><a href="<?= base_url('Admin/laporan/kinerja?periode=mei' . date('y')) ?>" class="dropdown-item <?= periode_to_month($perioda) == '5' ? 'active' : '' ?>">May</a></li>
                                <li><a href="<?= base_url('Admin/laporan/kinerja?periode=jun' . date('y')) ?>" class="dropdown-item <?= periode_to_month($perioda) == '6' ? 'active' : '' ?>">June</a></li>
                                <li><a href="<?= base_url('Admin/laporan/kinerja?periode=jul' . date('y')) ?>" class="dropdown-item <?= periode_to_month($perioda) == '7' ? 'active' : '' ?>">July</a></li>
                                <li><a href="<?= base_url('Admin/laporan/kinerja?periode=ags' . date('y')) ?>" class="dropdown-item <?= periode_to_month($perioda) == '8' ? 'active' : '' ?>">August</a></li>
                                <li><a href="<?= base_url('Admin/laporan/kinerja?periode=sep' . date('y')) ?>" class="dropdown-item <?= periode_to_month($perioda) == '9' ? 'active' : '' ?>">September</a></li>
                                <li><a href="<?= base_url('Admin/laporan/kinerja?periode=okt' . date('y')) ?>" class="dropdown-item <?= periode_to_month($perioda) == '10' ? 'active' : '' ?>">October</a></li>
                                <li><a href="<?= base_url('Admin/laporan/kinerja?periode=nov' . date('y')) ?>" class="dropdown-item <?= periode_to_month($perioda) == '11' ? 'active' : '' ?>">November</a></li>
                                <li><a href="<?= base_url('Admin/laporan/kinerja?periode=des' . date('y')) ?>" class="dropdown-item <?= periode_to_month($perioda) == '12' ? 'active' : '' ?>">December</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col d-flex justify-content-between">
                                <div>
                                    <a class="btn btn-primary mb-3" 
                                        href="<?= base_url('Admin/laporan/kinerja/createexcel?periode=' . $perioda) ?>">Export Data</a>
                                    <a class="btn btn-primary mb-3 "
                                        href="<?= base_url('Admin/laporan/kinerja/cetak?periode=' . $perioda) ?>" target="_blank">Cetak Laporan</a>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">NO</th>
                                        <th>Sektor</th>
                                        <th><?= month_name(periode_to_month($perioda)) . ' ' . date('Y') ?> (Rp.)</th>
                                        <th>Prosen (%)</th>
                                        <th>Timbang (Rp) </th>
                                        <th>RKA <?= month_name(periode_to_month($perioda)) . ' ' . date('Y') ?> (1)</th>
                                        <th>RKA SD <?= month_name(periode_to_month($perioda)) . ' ' . date('Y') ?> (2)</th>
                                        <th>Realisasi <?= month_name(periode_to_month($perioda)) . ' ' . date('Y') ?> (3)</th>
                                        <th>Realisasi SD <?= month_name(periode_to_month($perioda)) . ' ' . date('Y') ?> (4)</th>
                                        <th>RKA <?= month_name(periode_to_month($perioda)) . ' ' . date('Y') . ' Tahun' ?> (5)</th>
                                        <th>RKA SD <?= month_name(periode_to_month($perioda)) . ' ' . date('Y') . ' Tahun' ?> (6)</th>
                                        <th>(3:1) % RKA <?= month_name(periode_to_month($perioda)) . ' ' . date('Y') ?></th>
                                        <th>(4:2) % RKA SD <?= month_name(periode_to_month($perioda)) . ' ' . date('Y') ?></th>
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
                                        <th><?= month_name(periode_to_month($perioda)) . ' ' . date('Y') ?> (Rp.)</th>
                                        <th>RKA <?= month_name(periode_to_month($perioda)) . ' ' . date('Y') ?> (1)</th>
                                        <th>RKA SD <?= month_name(periode_to_month($perioda)) . ' ' . date('Y') ?> (2)</th>
                                        <th>Realisasi <?= month_name(periode_to_month($perioda)) . ' ' . date('Y') ?> (3)</th>
                                        <th>Realisasi SD <?= month_name(periode_to_month($perioda)) . ' ' . date('Y') ?> (4)</th>
                                        <th>RKA <?= month_name(periode_to_month($perioda)) . ' ' . date('Y') . ' Tahun' ?> (5)</th>
                                        <th>RKA SD <?= month_name(periode_to_month($perioda)) . ' ' . date('Y') . ' Tahun' ?> (6)</th>
                                        <th>(3:1) % RKA <?= month_name(periode_to_month($perioda)) . ' ' . date('Y') ?></th>
                                        <th>(4:2) % RKA SD <?= month_name(periode_to_month($perioda)) . ' ' . date('Y') ?></th>
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
                                        <th><?= month_name(periode_to_month($perioda)) . ' ' . date('Y') ?> (Rp.)</th>
                                        <th>RKA <?= month_name(periode_to_month($perioda)) . ' ' . date('Y') ?> (1)</th>
                                        <th>RKA SD <?= month_name(periode_to_month($perioda)) . ' ' . date('Y') ?> (2)</th>
                                        <th>Realisasi <?= month_name(periode_to_month($perioda)) . ' ' . date('Y') ?> (3)</th>
                                        <th>Realisasi SD <?= month_name(periode_to_month($perioda)) . ' ' . date('Y') ?> (4)</th>
                                        <th>RKA <?= month_name(periode_to_month($perioda)) . ' ' . date('Y') . ' Tahun' ?> (5)</th>
                                        <th>RKA SD <?= month_name(periode_to_month($perioda)) . ' ' . date('Y') . ' Tahun' ?> (6)</th>
                                        <th>(3:1) % RKA <?= month_name(periode_to_month($perioda)) . ' ' . date('Y') ?></th>
                                        <th>(4:2) % RKA SD <?= month_name(periode_to_month($perioda)) . ' ' . date('Y') ?></th>
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
