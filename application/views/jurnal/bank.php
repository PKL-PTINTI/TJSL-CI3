<?= $this->session->flashdata('message'); ?>
<section class="section">
    <div class="section-header">
        <h1>Management Data Jurnal</h1>
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
                                    <a class="btn btn-primary mb-3 "
                                        href="<?= base_url('admin/jurnal/periodaopex?id_akun=' . $id_akun . '&type=perioda') ?>">Perioda</a>
                                    <a class="btn btn-primary mb-3 "
                                        href="<?= base_url('admin/jurnal/periodaopex?id_akun=' . $id_akun . ' &type=perkiraan') ?>">Kartu Perkiraan</a>
                                    <a class="btn btn-primary mb-3 "
                                        href="<?= base_url('admin/jurnal/createExcel') ?>">Export Excel</a>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-jurnal-bank">
                                <thead>
                                    <tr>
                                        <th class="text-center">NO</th>
                                        <th>No ID</th>
                                        <th>ID Akun</th>
                                        <th>Tanggal</th>
                                        <th>No bukti</th>
                                        <th>Pemasukan</th>
                                        <th>Pengeluaran</th>
                                        <th>Saldo</th>
                                        <th>Keterangan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><?= number_format($saldoawal); ?></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php $i = 1; ?>
                                    <?php foreach ($opex as $j) : ?>
                                    <?php $saldoawal += $j->pemasukan - $j->pengeluaran; ?>
                                    <tr>
                                        <td class="text-center"><?= $i; ?></td>
                                        <td><?= $j->id_opex; ?></td>
                                        <td><?= $j->id_akun; ?></td>
                                        <td><?= $j->tanggal; ?></td>
                                        <td><?= $j->nobukti; ?></td>
                                        <td><?= number_format($j->pemasukan); ?></td>
                                        <td><?= number_format($j->pengeluaran); ?></td>
                                        <td><?= number_format($saldoawal); ?></td>
                                        <td><?= $j->keterangan; ?></td>
                                        <td>
                                            aksi
                                        </td>
                                    </tr>
                                    <?php $i++; ?>
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