<section class="section">
    <div class="section-header">
        <h1>DataTables</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="#">Modules</a></div>
            <div class="breadcrumb-item">DataTables</div>
        </div>
    </div>

    <div class="section-body">
        <h2 class="section-title">DataTables</h2>
        <p class="section-lead">
            We use 'DataTables' made by @SpryMedia. You can check the full documentation <a
                href="https://datatables.net/">here</a>.
        </p>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Basic DataTables</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <th class="text-center">
                                            No
                                        </th>
                                        <th>Nama Mitra</th>
                                        <th>No Kontrak</th>
                                        <th>Lokasi Usaha</th>
                                        <th>Sektor Usaha</th>
                                        <th>Start Cicil</th>
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
                                        <th>Tdk Bermasalah</th>
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
                                        <td><?php if($row->kolektibilitas == 'LUNAS'){
											echo '<span class="badge badge-success">LUNAS</span>';
										} elseif($row->kolektibilitas == 'macet'){
											echo '<span class="badge badge-danger">MACET</span>';
										} else {
											echo '<span class="badge badge-warning">0</span>';
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
                                        <td><?= $row->tdkbermasalah; ?>
                                        <td>
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