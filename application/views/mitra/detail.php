<?= $this->session->flashdata('message'); ?>
<section class="section">
    <div class="section-header">
        <h1>Show Data Mitra</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item">Detail Data Mitra</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Data Mitra <?= $mitra->nama_peminjam ?></h4>
                    </div>
                    <div class="row">
                        <div class="container">
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
                </div>
            </div>
        </div>
    </div>
</section>
