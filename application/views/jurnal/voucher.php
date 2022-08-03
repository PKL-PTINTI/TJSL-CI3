<section class="section">
    <div class="section-header">
        <h1>Tambah Data Transaksi Voucher</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="<?= base_url('admin/jurnal') ?>">Jurnal</a></div>
            <div class="breadcrumb-item">Tambah Data Transaksi Voucher</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Data Transaksi Voucher</h4>
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('admin/jurnal/addVoucher') ?>" method="post">
                            <div class="form-group">
                                <label>Nomor Bukti</label>
                                <input type="text" class="form-control" placeholder="Nomor Bukti" name="nomor_bukti">
                            </div>
                            <div class="form-group">
                                <label>Tanggal Transaksi</label>
                                <input type="text" class="form-control datepicker" name="tanggal_transaksi">
                            </div>
                            <div class="form-group">
                                <label>Kode Rekening</label>
                                <select class="form-control select2" name="korek">
                                    <option>Pilih Kode Rekening</option>
                                    <?php foreach ($korek as $row): ?>
                                    <option value="<?php echo $row->korek ?>">
                                        <?php echo $row->korek ?> - <?php echo $row->deskripsiAkun ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class=" form-group">
                                <label>Jumlah Pemasukan/Debet (Rp)</label>
                                <input type="text" class="form-control amount" placeholder="Jumlah Pemasukan"
                                    name="jumlah_pemasukan">
                            </div>
                            <div class="form-group">
                                <label>Keterangan</label>
                                <input type="text" class="form-control" placeholder="Keterangan" name="keterangan">
                            </div>

                            <div class="form-group">
                                <label>Kode Rekening Pasangan 1</label>
                                <select class="form-control select2" name="korekPasangan1">
                                    <option>Pilih Kode Rekening</option>
                                    <?php foreach ($korek as $row): ?>
                                    <option value="<?php echo $row->korek ?>">
                                        <?php echo $row->korek ?> - <?php echo $row->deskripsiAkun ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class=" form-group">
                                <label>Jumlah Pengeluaran/Kredit 1 (Rp)</label>
                                <input type="text" class="form-control amount" placeholder="Jumlah Pengeluaran"
                                    name="jumlah_pengeluaran1">
                            </div>
                            <div class="form-group">
                                <label>Keterangan 1</label>
                                <input type="text" class="form-control" placeholder="Keterangan" name="keterangan1">
                            </div>
                            
                            <div class="form-group">
                                <label>Kode Rekening Pasangan 2</label>
                                <select class="form-control select2" name="korekPasangan2">
                                    <option>Pilih Kode Rekening</option>
                                    <?php foreach ($korek as $row): ?>
                                    <option value="<?php echo $row->korek ?>">
                                        <?php echo $row->korek ?> - <?php echo $row->deskripsiAkun ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class=" form-group">
                                <label>Jumlah Pengeluaran/Kredit 2 (Rp)</label>
                                <input type="text" class="form-control amount" placeholder="Jumlah Pengeluaran"
                                    name="jumlah_pengeluaran2">
                            </div>
                            <div class="form-group">
                                <label>Keterangan 2</label>
                                <input type="text" class="form-control" placeholder="Keterangan" name="keterangan2">
                            </div>
                            
                            
                            <div class="form-group">
                                <label>Kode Rekening Pasangan 3</label>
                                <select class="form-control select2" name="korekPasangan3">
                                    <option>Pilih Kode Rekening</option>
                                    <?php foreach ($korek as $row): ?>
                                    <option value="<?php echo $row->korek ?>">
                                        <?php echo $row->korek ?> - <?php echo $row->deskripsiAkun ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class=" form-group">
                                <label>Jumlah Pengeluaran/Kredit 3 (Rp)</label>
                                <input type="text" class="form-control amount" placeholder="Jumlah Pengeluaran"
                                    name="jumlah_pengeluaran3">
                            </div>
                            <div class="form-group">
                                <label>Keterangan 3</label>
                                <input type="text" class="form-control" placeholder="Keterangan" name="keterangan3">
                            </div>
                            
                            
                            <!-- <div class="form-group">
                                <label>Kode Rekening Pasangan 4</label>
                                <select class="form-control select2" name="korekPasangan4">
                                    <option>Pilih Kode Rekening</option>
                                    <?php foreach ($korek as $row): ?>
                                    <option value="<?php echo $row->korek ?>">
                                        <?php echo $row->korek ?> - <?php echo $row->deskripsiAkun ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class=" form-group">
                                <label>Jumlah Pengeluaran/Kredit 4 (Rp)</label>
                                <input type="text" class="form-control amount" placeholder="Jumlah Pemasukan"
                                    name="jumlah_pengeluaran4">
                            </div>
                            <div class="form-group">
                                <label>Keterangan 4</label>
                                <input type="text" class="form-control" placeholder="Keterangan" name="keterangan4">
                            </div>
                            
                            <div class="form-group">
                                <label>Kode Rekening Pasangan 5</label>
                                <select class="form-control select2" name="korekPasangan5">
                                    <option>Pilih Kode Rekening</option>
                                    <?php foreach ($korek as $row): ?>
                                    <option value="<?php echo $row->korek ?>">
                                        <?php echo $row->korek ?> - <?php echo $row->deskripsiAkun ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class=" form-group">
                                <label>Jumlah Pengeluaran/Kredit 5 (Rp)</label>
                                <input type="text" class="form-control amount" placeholder="Jumlah Pengeluaran"
                                    name="jumlah_pengeluaran5">
                            </div>
                            <div class="form-group">
                                <label>Keterangan 5</label>
                                <input type="text" class="form-control" placeholder="Keterangan" name="keterangan5">
                            </div>
                            
                            <div class="form-group">
                                <label>Kode Rekening Pasangan 6</label>
                                <select class="form-control select2" name="korekPasangan6">
                                    <option>Pilih Kode Rekening</option>
                                    <?php foreach ($korek as $row): ?>
                                    <option value="<?php echo $row->korek ?>">
                                        <?php echo $row->korek ?> - <?php echo $row->deskripsiAkun ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class=" form-group">
                                <label>Jumlah Pengeluaran/Kredit 6 (Rp)</label>
                                <input type="text" class="form-control amount" placeholder="Jumlah Pengeluaran"
                                    name="jumlah_pengeluaran6">
                            </div>
                            <div class="form-group">
                                <label>Keterangan 6</label>
                                <input type="text" class="form-control" placeholder="Keterangan" name="keterangan6">
                            </div>
                            
                            
                            <div class="form-group">
                                <label>Kode Rekening Pasangan 7</label>
                                <select class="form-control select2" name="korekPasangan7">
                                    <option>Pilih Kode Rekening</option>
                                    <?php foreach ($korek as $row): ?>
                                    <option value="<?php echo $row->korek ?>">
                                        <?php echo $row->korek ?> - <?php echo $row->deskripsiAkun ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class=" form-group">
                                <label>Jumlah Pengeluaran/Kredit 7 (Rp)</label>
                                <input type="text" class="form-control amount" placeholder="Jumlah Pengeluaran"
                                    name="jumlah_pengeluaran7">
                            </div>
                            <div class="form-group">
                                <label>Keterangan 7</label>
                                <input type="text" class="form-control" placeholder="Keterangan" name="keterangan7">
                            </div> -->
                            
                            
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
