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
                                    <a class="btn btn-primary mb-3" 
                                        href="<?= base_url('Admin/saldo/kartuperkiraan?id_akun=' . $id_akun) ?>">Kartu Perkiraan</a>
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
                                    <?php $no = 1;?>
                                    <?php foreach($jurnal as $j): ?>
                                    <?php $saldoawal += $j->pemasukan - $j->pengeluaran ?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td><?= $j->id_opex ?></td>
                                        <td><?= $j->id_akun ?></td>
                                        <td><?= $j->tanggal ?></td>
                                        <td><?= number_format($j->pemasukan) ?></td>
                                        <td><?= number_format($j->pengeluaran) ?></td>
                                        <td><?= number_format($saldoawal) ?></td>
                                        <td><?= $j->keterangan ?></td>
                                        <td><?= $j->nobukti ?></td>
                                        <td><?= number_format($j->tot_pemasukan) ?></td>
                                        <td><?= number_format($j->tot_pengeluaran) ?></td>
                                        <td><?= $j->updated ?></td>
                                        <td><?= $j->tglUpdate ?></td>
                                        <td>
                                            <div class="dropdown">
					                            <a id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						                            <i class="fas fa-ellipsis-v"></i>
					                            </a>
					                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
						                        <a class="dropdown-item btndelete" id="button_delete" href="#" onclick="delete_jurnal(this)" data-opex="<?= $j->nobukti ?>">
                                                    <i class="fas fa-trash text-danger pr-2"></i> Delete </a>
					                        </div>
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