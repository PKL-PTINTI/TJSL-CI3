<section class="section">
    <div class="section-header">
        <h1>Data Mitra <?= $mitra->nama_peminjam ?></h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="<?= base_url('Admin/dashboard') ?>">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="<?= base_url('Admin/mitra') ?>">Mitra</a></div>
            <div class="breadcrumb-item">Update Data Mitra</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Update Data Mitra A.N <?= $mitra->nama_peminjam ?></h4>
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('Admin/mitra/storeupdate') ?>" method="post">
                            <div class="form-group">
                                <label>ID Mitra</label>
                                <input type="text" class="form-control" placeholder="Nomor Kontrak"
                                    value="<?= $mitra->id ?>" readonly>
                            </div> 
                            <div class="form-group">
                                <label>Nomor Kontrak</label>
                                <input type="text" name="nokontrak" class="form-control" placeholder="Nomor Kontrak"
                                    value="<?= $mitra->nokontrak ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Nama Mitra</label>
                                <input type="text" class="form-control" placeholder="Nama Mitra"
                                    value="<?= $mitra->nama_peminjam ?>" name="nama_peminjam">
                            </div>
                            <div class=" form-group">
                                <label>Nama Perusahaan</label>
                                <input type="text" class="form-control" placeholder="Nama Perusahaan"
                                    value="<?= $mitra->namaPerusahaan ?>" name="namaPerusahaan">
                            </div>
                            <div class="form-group">
                                <label>No Handphone</label>
                                <input type="text" class="form-control" placeholder="No Handphone"
                                    value="<?= $mitra->hp ?>" name="hp">
                            </div>

                            <div class="form-group">
                                <label>Status Mitra</label>
                                <select class="form-control select2" name="barulanjutan">
                                    <option>Pilih Status Mitra</option>
                                    <?php foreach ($statusmitra as $status): ?>
                                    <option <?= ($status->status == $mitra->barulanjutan) ? 'selected' : null  ?> value="<?= $status->status ?>"><?= $status->id ?> -
                                        <?= ucfirst($status->status) ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Sektor Usaha</label>
                                <select class="form-control select2" name="sektor_usaha">
                                    <option>Pilih Sektor Usaha</option>
                                    <?php foreach ($sektor as $sktr): ?>
                                    <option <?= ($status->status == $mitra->barulanjutan) ? 'selected' : null  ?> value="<?= $sktr->sektor ?>"><?= $sktr->id ?> -
                                        <?= ucfirst($sktr->sektor) ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Nomor KTP Mitra</label>
                                <input type="text" class="form-control" placeholder="Nomor KTP Mitra"
                                    value="<?= $mitra->ktp ?>" name="ktp">
                            </div>

                            <div class="form-group">
                                <label>No Rekening Bank Mitra</label>
                                <input type="text" class="form-control" placeholder="No Rekening Bank Mitra"
                                    value="<?= $mitra->noRekBank ?>" name="noRekBank">
                            </div>

                            <div class="form-group">
                                <label>Rekondisi (1=rekondisi)</label>
                                <input type="text" class="form-control" placeholder="Rekondisi (1=rekondisi)"
                                    value="<?= $mitra->rekondisi ?>" name="rekondisi">
                            </div>

                            <div class="form-group">
                                <label>Tanggal rekondisi</label>
                                <input type="date" class="form-control date" placeholder="Tanggal rekondisi"
                                    value="<?= $mitra->tgl_rekondisi ?>" name="tgl_rekondisi">
                            </div>

                            <div class="form-group">
                                <label>Produk/Jasa Mitra</label>
                                <input type="text" class="form-control" placeholder="Produk/Jasa Mitra"
                                    value="<?= $mitra->prodJasa ?>" name="prodJasa">
                            </div>

                            <div class="form-group">
                                <label>Produk Unggulan</label>
                                <input type="text" class="form-control" placeholder="Produk Unggulan"
                                    value="<?= $mitra->noRekBank ?>" name="prodUnggul">
                            </div>

                            <?php
                                $kolektibilitas = $this->db->query("SELECT * FROM kolektibilitas")->result();   
                            ?>

                            <div class="form-group">
                                <label>Kolektibilitas</label>
                                <select class="form-control select2" name="kolektibilitas">
                                    <option>Pilih Kolektibilitas</option>
                                    <?php foreach ($kolektibilitas as $kode): ?>
                                    <option <?= ($kode->status == $mitra->kolektibilitas) ? 'selected' : null  ?> value="<?= $kode->status ?>"><?= $kode->id ?> -
                                        <?= ucfirst($kode->status) ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Pinjaman Pokok</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            Rp.
                                        </div>
                                    </div>
                                    <input type="text" class="form-control currency" value="<?= $mitra->pinjpokok ?>"
                                        name="pinjpokok">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Pinjaman Jasa</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            Rp.
                                        </div>
                                    </div>
                                    <input type="text" class="form-control currency" value="<?= $mitra->pinjjasa ?>"
                                        name="pinjjasa">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
