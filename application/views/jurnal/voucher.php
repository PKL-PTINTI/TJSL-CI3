<section class="section">
    <div class="section-header">
        <h1>Tambah Data Transaksi Voucher</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="<?= base_url('Admin/dashboard') ?>">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="<?= base_url('Admin/jurnal') ?>">Jurnal</a></div>
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
                        <form action="<?= base_url('Admin/jurnal/AddVoucher') ?>" method="post" class="repeater">
                            <div class="form-group">
                                <label>Nomor Bukti</label>
                                <input type="text" class="form-control" placeholder="Nomor Bukti" name="nomor_bukti" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label>Tanggal Transaksi</label>
                                <input type="text" class="form-control datepicker" name="tanggal_transaksi" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label>Kode Rekening</label>
                                <select class="form-control select2" name="korek" autocomplete="off">
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
                                <input type="text" class="form-control amount" placeholder="Jumlah Pemasukan" name="jumlah_pemasukan" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label>Keterangan</label>
                                <input type="text" class="form-control" placeholder="Keterangan" name="keterangan" autocomplete="off">
                            </div>

                            <div class="form-group">
                                <label>Kode Rekening Pasangan <span class="index_loop"></span></label>
                                <select class="form-control select2" name="korekPasangan" autocomplete="off">
                                    <option>Pilih Kode Rekening</option>
                                    <?php foreach ($korek as $row): ?>
                                    <option value="<?php echo $row->korek ?>">
                                        <?php echo $row->korek ?> - <?php echo $row->deskripsiAkun ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class=" form-group">
                                <label>Jumlah Pengeluaran/Kredit (Rp) <span class="index_loop"></span></label>
                                <input type="text" class="form-control amount" placeholder="Jumlah Pengeluaran" name="jumlah_pengeluaran" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label>Keterangan <span class="index_loop"></span></label>
                                <input type="text" class="form-control" placeholder="Keterangan" name="keteranganPasangan" autocomplete="off">
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
