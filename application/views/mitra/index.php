<?php
	$totalPinjPokok = 0;
	$totalPinjJasa = 0;
	$totalPinjJumlah = 0;
	$totalAngPokok = 0;
	$totalAngJasa = 0;
	$totalAngJumlah = 0;
	$totalSaldoPokok = 0;
	$totalSaldoJasa = 0;
	$totalSaldoJumlah = 0;
?>
<section class="section">
    <div class="section-header">
        <h1>Management Data Mitra</h1>
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
                                <?php if(uri_string() == 'admin/mitra'): ?>
                                <?= null; ?>
                                <?php else: ?>
                                <div class="dropdown pr-4">
                                    <button class="btn btn-primary dropdown-toggle" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        Sektor
                                    </button>
                                    <div class="dropdown-menu" x-placement="bottom-start"
                                        style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 29px, 0px);">
                                        <a class="dropdown-item"
                                            href="<?= base_url('admin/mitra/kolektibilitas/' . $this->uri->segment(4) . '/industri'); ?>">Sektor
                                            Industri</a>
                                        <a class="dropdown-item"
                                            href="<?= base_url('admin/mitra/kolektibilitas/' . $this->uri->segment(4) . '/perdagangan'); ?>">Sektor
                                            Perdagangan</a>
                                        <a class="dropdown-item"
                                            href="<?= base_url('admin/mitra/kolektibilitas/' . $this->uri->segment(4) . '/pertanian'); ?>">Sektor
                                            Pertanian</a>
                                        <a class="dropdown-item"
                                            href="<?= base_url('admin/mitra/kolektibilitas/' . $this->uri->segment(4) . '/perkebunan'); ?>">Sektor
                                            Perkebunan</a>
                                        <a class="dropdown-item"
                                            href="<?= base_url('admin/mitra/kolektibilitas/' . $this->uri->segment(4) . '/perikanan'); ?>">Sektor
                                            Perikanan</a>
                                        <a class="dropdown-item"
                                            href="<?= base_url('admin/mitra/kolektibilitas/' . $this->uri->segment(4) . '/peternakan'); ?>">Sektor
                                            Peternakan</a>
                                        <a class="dropdown-item"
                                            href="<?= base_url('admin/mitra/kolektibilitas/' . $this->uri->segment(4) . '/jasa'); ?>">Sektor
                                            Jasa</a>
                                        <a class="dropdown-item" href="#">Sektor Lain-lain</a>
                                    </div>
                                </div>
                                <?php endif; ?>
                                <a class="btn btn-primary mb-3" href="<?= base_url('admin/mitra/create') ?>">Tambah
                                    Data Mitra</a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <th class="text-center">NO</th>
                                        <th>Nama Mitra</th>
                                        <th>No Kontrak</th>
                                        <th>Lokasi Usaha</th>
                                        <th>Sektor Usaha</th>
                                        <th>Mulai Cicil</th>
                                        <th>Kolektibilitas</th>
                                        <th>Pinjaman Pokok</th>
                                        <th>Pinjaman Jasa</th>
                                        <th>Pinjaman Jumlah</th>
                                        <th>Angsuran Pokok</th>
                                        <th>Angsuran Jasa</th>
                                        <th>Angsuran Jumlah</th>
                                        <th>Saldo Pokok</th>
                                        <th>Saldo Jasa</th>
                                        <th>Saldo Jumlah</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; 
										foreach($mitra as $row):
									?>
                                    <?php $jumlah = $row->pinjpokok + $row->pinjjasa; ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $row->nama_peminjam; ?></td>
                                        <td><?= $row->nokontrak; ?></td>

                                        <td><?= $row->lokasiUsaha; ?></td>
                                        <td><?= $row->sektorUsaha; ?></td>
                                        <td><?= $row->startcicil; ?></td>
                                        <td><?php if($row->kolektibilitas == 'LANCAR' || $row->kolektibilitas == 'Lancar' || $row->kolektibilitas == 'lancar'){
											echo '<span class="badge badge-success">LANCAR</span>';
										} elseif($row->kolektibilitas == 'macet' || $row->kolektibilitas == 'Macet' || $row->kolektibilitas == 'MACET'){
											echo '<span class="badge badge-danger">MACET</span>';
										} elseif($row->kolektibilitas == 'KURANG LANCAR' || $row->kolektibilitas == 'Kurang Lancar' || $row->kolektibilitas == 'kurang lancar'){
											echo '<span class="badge badge-warning">KURANG LANCAR</span>';
										}else {
											echo '<span class="badge badge-warning">DIRAGUKAN</span>';
										}; ?></td>

                                        <td><?= number_format($row->pinjpokok) ; ?></td>
                                        <td><?= number_format($row->pinjjasa); ?></td>
                                        <td><?= number_format($jumlah); ?></td>
                                        <td><?= number_format($row->angpokok); ?></td>
                                        <td><?= number_format($row->angjasa); ?></td>
                                        <td><?= number_format($row->angjumlah); ?></td>
                                        <td><?= number_format($row->saldopokok); ?></td>
                                        <td><?= number_format($row->saldojasa); ?></td>
                                        <td><?= number_format($row->saldojumlah); ?></td>
                                        <td><?php if($row->tdkbermasalah == 'NORMAL' || $row->tdkbermasalah == 'normal' || $row->tdkbermasalah == 'Normal'){
											echo '<span class="badge badge-success">NORMAL</span>';
										} elseif($row->tdkbermasalah == 'WO'){
											echo '<span class="badge badge-info">WO</span>';
										} elseif($row->tdkbermasalah == 'masalah' || $row->tdkbermasalah == 'MASALAH' || $row->tdkbermasalah == 'Masalah'){
											echo '<span class="badge badge-warning">MASALAH</span>';
										}elseif($row->tdkbermasalah == 'khusus' || $row->tdkbermasalah == 'Khusus' || $row->tdkbermasalah == 'KHUSUS'){
											echo '<span class="badge badge-danger">KHUSUS</span>';
										}; ?></td>
                                        <td>
                                            <div class="dropdown">
                                                <div id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </div>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="#">Update</a>
                                                    <a class="dropdown-item" href="#">Cicilan</a>
                                                    <a class="dropdown-item" href="#">Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
										$totalPinjPokok += $row->pinjpokok;
										$totalPinjJasa += $row->pinjjasa;
										$totalPinjJumlah += $row->pinjjumlah;

										$totalAngPokok += $row->angpokok;
										$totalAngJasa += $row->angjasa;
										$totalAngJumlah += $row->angjumlah;

										$totalSaldoPokok += $row->saldopokok;
										$totalSaldoJasa += $row->saldojasa;
										$totalSaldoJumlah += $row->saldojumlah;
									?>
                                    <?php endforeach; ?>
                                </tbody>
                                <td colspan="6"> </td>
                                <td> T O T A L : </td>
                                <td><?= number_format( $totalPinjPokok); ?></td>
                                <td><?= number_format( $totalPinjJasa); ?></td>
                                <td><?= number_format( $totalPinjJumlah); ?></td>
                                <td><?= number_format( $totalAngPokok); ?></td>
                                <td><?= number_format( $totalAngJasa); ?></td>
                                <td><?= number_format( $totalAngJumlah); ?></td>
                                <td><?= number_format( $totalSaldoPokok); ?></td>
                                <td><?= number_format( $totalSaldoJasa); ?></td>
                                <td><?= number_format( $totalSaldoJumlah); ?></td>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</section>