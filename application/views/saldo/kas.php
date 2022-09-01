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
                                <?php if(uri_string() == 'admin/saldo'): ?>
                                <?php endif; ?>
                                <div>
                                    <a class="btn btn-primary mb-3" 
                                        href="<?= base_url('Admin/Saldo/KartuPerkiraan?id_akun=' . $id_akun) ?>">Kartu Perkiraan</a>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <th class="text-center">NO</th>
                                        <th>No ID</th>
                                        <th>Kode Rekening</th>
                                        <th>Tanggal</th>
                                        <th>Pemasukan</th>
                                        <th>Pengeluaran</th>
                                        <th>Saldo</th>
                                        <th>Keterangan</th>
                                        <th>No bukti</th>
                                        <th>Total Pemasukan</th>
                                        <th>Total Pengeluaran</th>
                                        <th>Updated</th>
                                        <th>Tanggal Updated</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; $saldo = 0;?>
                                    <?php foreach($jurnal as $j): ?>
                                    <?php $saldo += $j->pemasukan - $j->pengeluaran ?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td><?= $j->id_opex ?></td>
                                        <td><?= $j->id_akun ?></td>
                                        <td><?= $j->tanggal ?></td>
                                        <td><?= number_format($j->pemasukan) ?></td>
                                        <td><?= number_format($j->pengeluaran) ?></td>
                                        <td><?= number_format($saldo + $saldoawal) ?></td>
                                        <td><?= $j->keterangan ?></td>
                                        <td><?= $j->nobukti ?></td>
                                        <td><?= $j->tot_pemasukan ?></td>
                                        <td><?= $j->tot_pengeluaran ?></td>
                                        <td><?= $j->updated ?></td>
                                        <td><?= $j->tglUpdate ?></td>
                                        <td>
                                            <a href="<?= base_url('Admin/Saldo/Edit/'.$j->id_opex) ?>" 
                                                class="btn btn-primary btn-sm">Edit</a>
                                            <a href="<?= base_url('Admin/Saldo/Delete/'.$j->id_opex) ?>" 
                                                class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                                        </td>
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