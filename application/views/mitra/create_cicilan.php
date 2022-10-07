<section class="section">
    <div class="section-header">
        <h1>Input Data Cicilan Baru</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="<?= base_url('Admin/dashboard') ?>">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="<?= base_url('Admin/Mitra') ?>">Mitra</a></div>
            <div class="breadcrumb-item">Input Data Cicilan Baru</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Cicilan <?= $mitra->nama_peminjam ?> </h4>
                    </div>
                    <div class="card-body">
                        <div class="pb-3">
                            <div class="row">
                                <div class="col-md-3 col-6 font-weight-bold">Nama Mitra</div>
                                <div class="col-md-3 col-6"><?= $mitra->nama_peminjam ?></div>
                            </div>
                            <div class="row pt-2">
                                <div class="col-md-3 col-6 font-weight-bold">No Kontrak</div>
                                <div class="col-md-3 col-6"><?= $mitra->nokontrak ?></div>
                            </div>
                            <div class="row pt-2">
                                <div class="col-md-3 col-6 font-weight-bold">Sektor</div>
                                <div class="col-md-3 col-6"><?= $mitra->sektorUsaha ?></div>
                            </div>
                            <div class="row pt-2">
                                <div class="col-md-3 col-6 font-weight-bold">Status</div>
                                <div class="col-md-3 col-6"><?= $mitra->tdkbermasalah ?>
                                </div>
                            </div>
                            <div class="row pt-2">
                                <div class="col-md-3 col-6 font-weight-bold">Cicilan Perbulan</div>
                                <div class="col-md-3 col-6"><?= number_format($mitra->cicilanperbln) ?>
                                </div>
                            </div>
                        </div>
                        <form action="<?= base_url('Admin/mitra/tambahcicilan') ?>" method="post">
                            <input type="hidden" name="no_kontrak" value="<?= $mitra->nokontrak ?>">
                            <div class="form-group">
                                <label>Jumlah Cicilan Pokok</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            Rp.
                                        </div>
                                    </div>
                                    <input type="text" class="form-control currency amount" name="cicilan_pokok">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Jumlah Cicilan Jasa</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            Rp.
                                        </div>
                                    </div>
                                    <input type="text" class="form-control currency amount" name="cicilan_jasa">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Uang Cicilan Dimasukan ke Rekening</label>
                                <select class="form-control select2" name="rekening">
                                    <option>Pilih Bank</option>
                                    <?php foreach ($kasbrimandiri as $bank): ?>
                                    <option value="<?= $bank->korek ?>"><?= $bank->korek ?> -
                                        <?= ucfirst($bank->kasmasuk) ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Tanggal</label>
                                <input type="text" class="form-control datepicker" name="tanggal">
                            </div>
                            <div class="form-group">
                                <label>Keterangan</label>
                                <input type="text" class="form-control" name="keterangan">
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>