<?php
	$totalPokokOpex=0;
	$totalJasaOpex=0;
	$totalJumlahOpex=0;
	$totalPokokCicilan=0;
	$totalJasaCicilan=0;
	$totalJumlahCicilan=0;
?>
<?= $this->session->flashdata('message'); ?>
<section class="section">
    <div class="section-header">
        <h1>Rincian Cicilan</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="<?= base_url('admin/mitra') ?>">Mitra</a></div>
            <div class="breadcrumb-item"><?= $header ?></div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Detail Data Mitra</h4>
                        <div class="card-header-action">
                            <a data-collapse="#mycard-collapse" class="btn btn-icon btn-info" href="#"><i
                                class="fas fa-plus"></i></a>
                        </div>
                    </div>
                    <div class="collapse" id="mycard-collapse">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 col-6 font-weight-bold">Nama Mitra</div>
                                <div class="col-md-3 col-6"><?= $mitra->nama_peminjam ?></div>
                            </div>
                            <div class="row pt-2">
                                <div class="col-md-3 col-6 font-weight-bold">Pinjaman Pokok</div>
                                <div class="col-md-3 col-6 text-danger"><?= number_format($mitra->pinjpokok) ?></div>
                            </div>
                            <div class="row pt-2">
                                <div class="col-md-3 col-6 font-weight-bold">Pinjaman Jasa</div>
                                <div class="col-md-3 col-6 text-danger"><?= number_format($mitra->pinjjasa) ?></div>
                            </div>
                            <div class="row pt-2">
                                <div class="col-md-3 col-6 font-weight-bold">Pinjaman Jumlah</div>
                                <div class="col-md-3 col-6 text-danger"><?= number_format($mitra->pinjjumlah) ?></div>
                            </div>
                            <div class="row pt-2">
                                <div class="col-md-3 col-6 font-weight-bold">Angsuran Pokok</div>
                                <div class="col-md-3 col-6 text-success"><?= number_format($mitra->angpokok) ?></div>
                            </div>
                            <div class="row pt-2">
                                <div class="col-md-3 col-6 font-weight-bold">Angsuran Jasa</div>
                                <div class="col-md-3 col-6 text-success"><?= number_format($mitra->angjasa) ?></div>
                            </div>
                            <div class="row pt-2">
                                <div class="col-md-3 col-6 font-weight-bold">Angsuran Jumlah</div>
                                <div class="col-md-3 col-6 text-success"><?= number_format($mitra->angjumlah) ?></div>
                            </div>
                            <div class="row pt-2">
                                <div class="col-md-3 col-6 font-weight-bold">Saldo Pokok</div>
                                <div class="col-md-3 col-6 text-primary"><?= number_format($mitra->saldopokok) ?></div>
                            </div>
                            <div class="row pt-2">
                                <div class="col-md-3 col-6 font-weight-bold">Saldo Jasa</div>
                                <div class="col-md-3 col-6 text-primary"><?= number_format($mitra->saldojasa) ?></div>
                            </div>
                            <div class="row pt-2">
                                <div class="col-md-3 col-6 font-weight-bold">Saldo Jumlah</div>
                                <div class="col-md-3 col-6 text-primary"><?= number_format($mitra->saldojumlah) ?></div>
                            </div>
                            <div class="row pt-2">
                                <div class="col-md-3 col-6 font-weight-bold">Kolektibilitas</div>
                                <div class="col-md-3 col-6">
                                    <?php if($mitra->kolektibilitas == 'LANCAR' || $mitra->kolektibilitas == 'Lancar' || $mitra->kolektibilitas == 'lancar'){
											echo '<span class="badge badge-success">LANCAR</span>';
										} elseif($mitra->kolektibilitas == 'macet' || $mitra->kolektibilitas == 'Macet' || $mitra->kolektibilitas == 'MACET'){
											echo '<span class="badge badge-danger">MACET</span>';
										} elseif($mitra->kolektibilitas == 'KURANG LANCAR' || $mitra->kolektibilitas == 'Kurang Lancar' || $mitra->kolektibilitas == 'kurang lancar'){
											echo '<span class="badge badge-warning">KURANG LANCAR</span>';
										}else {
											echo '<span class="badge badge-warning">DIRAGUKAN</span>';
										}; ?>
                                </div>
                            </div>
                            <div class="row pt-2">
                                <div class="col-md-3 col-6 font-weight-bold">Jasa (%)</div>
                                <div class="col-md-3 col-6"><?= $mitra->jasa ?></div>
                            </div>
                            <div class="row pt-2">
                                <div class="col-md-3 col-6 font-weight-bold">Tanggal Kontrak</div>
                                <div class="col-md-3 col-6"><?= $mitra->tglkontrak ?></div>
                            </div>
                            <div class="row pt-2">
                                <div class="col-md-3 col-6 font-weight-bold">Cicilan per Bulan</div>
                                <div class="col-md-3 col-6"><?= number_format($mitra->cicilanperbln) ?></div>
                            </div>
                            <div class="row pt-2">
                                <div class="col-md-3 col-6 font-weight-bold">Tanggal Jatuh Tempo</div>
                                <div class="col-md-3 col-6"><?= $mitra->tgljatuhtempo ?></div>
                            </div>
                            <div class="row pt-2">
                                <div class="col-md-3 col-6 font-weight-bold">Tanggal Cicilan Terakhir</div>
                                <div class="col-md-3 col-6"><?= $mitra->tglcicilanterakhir ?></div>
                            </div>
                            <div class="row pt-2">
                                <div class="col-md-3 col-6 font-weight-bold">Rekondisi</div>
                                <div class="col-md-3 col-6"><?= $mitra->rekondisi ?></div>
                            </div>
                            <div class="row pt-2">
                                <div class="col-md-3 col-6 font-weight-bold">Tanggal Rekondisi</div>
                                <div class="col-md-3 col-6"><?= $mitra->tgl_rekondisi ?></div>
                            </div>
                            <div class="row pt-2">
                                <div class="col-md-3 col-6 font-weight-bold">Tidak Bermasalah</div>
                                <div class="col-md-3 col-6">
                                    <?php 
										if($mitra->tdkbermasalah == 'NORMAL' || $mitra->tdkbermasalah == 'normal' || $mitra->tdkbermasalah == 'Normal'){
											echo '<span class="badge badge-success">NORMAL</span>';
										} elseif($mitra->tdkbermasalah == 'WO'){
											echo '<span class="badge badge-info">WO</span>';
										} elseif($mitra->tdkbermasalah == 'masalah' || $mitra->tdkbermasalah == 'MASALAH' || $mitra->tdkbermasalah == 'Masalah'){
											echo '<span class="badge badge-warning">MASALAH</span>';
										}elseif($mitra->tdkbermasalah == 'khusus' || $mitra->tdkbermasalah == 'Khusus' || $mitra->tdkbermasalah == 'KHUSUS'){
											echo '<span class="badge badge-danger">KHUSUS</span>';
										}; 
									?>
                                </div>
                            </div>
                            <div class="row pt-2">
                                <div class="col-md-3 col-6 font-weight-bold">Sektor Usaha</div>
                                <div class="col-md-3 col-6"><?= $mitra->sektorUsaha ?></div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4><?= $header; ?> Jurnal</h4>
                        <div>
                            <a class="btn btn-primary" href="<?= base_url('admin/mitra/cicilan/create/' . $mitra->nokontrak) ?>">Tambah Cicilan</a>
                            <a class="btn btn-primary d-none" href="<?= base_url('admin/mitra/copytojurnal/' . $mitra->nokontrak) ?>">Copy Cicilan Ke Jurnal</a>
                            <a class="btn btn-primary" href="<?= base_url('admin/mitra/cetakcicilan/' . $mitra->nokontrak) ?>">Cetak Cicilan</a>
                            <a class="btn btn-primary" href="<?= base_url('admin/mitra/createexcel/') ?>">Export Cicilan</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-cicilan-1">
                                <thead>
                                    <tr>
                                        <th class="text-center">NO</th>
                                        <th>Tanggal</th>
                                        <th>Deskripsi</th>
                                        <th>Keterangan</th>
                                        <th>Pokok</th>
                                        <th>Jasa</th>
                                        <th>Jumlah</th>
                                        <th>Saldo</th>
                                        <th>Kode Rekening</th>
                                        <th>No Bukti</th>
                                        <th>ID OPEX</th>
                                        <th>Updated By</th>
                                        <th>Tampil</th>
                                        <th>Tanggal Update</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
									foreach ($dataOpex as $c): ?>
                                    <tr>
                                        <td class="text-center"><?= $no++; ?></td>
                                        <td><?= $c['tanggal'] ?></td>
                                        <td><?= $c['deskripsi'] ?></td>
                                        <td><?= $c['keterangan'] ?></td>
                                        <td><?= number_format($c['cicil_pokok']) ?></td>
                                        <td><?= number_format($c['cicil_jasa']) ?></td>
                                        <td><?= number_format($c['jumlah']) ?></td>
                                        <td><?= number_format($c['sisaPinjamanJumlah']) ?></td>
                                        <td><?= $c['id_akun'] ?></td>
                                        <td><?= $c['nobukti'] ?></td>
                                        <td><?= $c['id_opex'] ?></td>
                                        <td><?= $c['updated'] ?></td>
                                        <td><?= $c['tampil'] ?></td>
                                        <td><?= $c['tglUpdate'] ?></td>
                                        <td>
                                            <div class="dropdown">
                                                <a id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item btndelete" onclick="delete_jurnal(this)" data-opex="<?= $c['nobukti'] ?>"><i
                                                        class="fas fa-trash text-danger pr-2"></i> Delete </a>
                                                    <a class="dropdown-item"><i class="fas fa-print text-sucess pr-2"></i> Cetak Bukti </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <td colspan="3"></td>
                                <td> T O T A L : </td>
                                <td><?= number_format($pokok); ?></td>
                                <td><?= number_format($jasa); ?></td>
                                <td><?= number_format($total); ?></td>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="d-none 
                card">
                    <div class="card-header">
                        <h4><?= $header; ?></h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-cicilan-2">
                                <thead>
                                    <tr>
                                        <th class="text-center">NO</th>
                                        <th>ID</th>
                                        <th>Tanggal</th>
                                        <th>Keterangan</th>
                                        <th>Pokok</th>
                                        <th>Jasa</th>
                                        <th>Jumlah</th>
                                        <th>Saldo</th>
                                        <th>Kode Rekening</th>
                                        <th>No Bukti</th>
                                        <th>Updated By</th>
                                        <th>Tanggal Update</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
									foreach ($cicilan as $c): ?>
                                    <tr>
                                        <td class="text-center"><?= $no++; ?></td>
                                        <td><?= $c->id ?></td>
                                        <td><?= $c->tgl ?></td>
                                        <td><?= $c->ket ?></td>
                                        <td><?= number_format($c->pokok) ?></td>
                                        <td><?= number_format($c->jasa) ?></td>
                                        <td><?= number_format($c->jumlah) ?></td>
                                        <td><?= number_format($c->saldo) ?></td>
                                        <td><?= $c->korek ?></td>
                                        <td><?= $c->nobukti ?></td>
                                        <td><?= $c->updated ?></td>
                                        <td><?= $c->tglUpdate ?></td>
                                        <td>

                                        </td>
                                    </tr>
                                    <?php
										$totalPokokCicilan += $c->pokok;
										$totalJasaCicilan += $c->jasa;
										$totalJumlahCicilan += $c->jumlah;
									?>
                                    <?php endforeach; ?>
                                </tbody>
                                <td colspan="3"></td>
                                <td> T O T A L : </td>
                                <td><?= number_format($totalPokokCicilan); ?></td>
                                <td><?= number_format($totalJasaCicilan); ?></td>
                                <td><?= number_format($totalJumlahCicilan); ?></td>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</section>