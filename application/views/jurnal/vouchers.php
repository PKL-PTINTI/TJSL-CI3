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
                        <h4 class="card-title">Data Transaksi Voucher</h4>
                    </div>
                    <div class="card-body">
                    <form action="<?= base_url('Admin/jurnal/AddVoucher') ?>" method="post" class="repeater">
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
                                <input type="text" class="form-control amount" placeholder="Jumlah Pemasukan" name="jumlah_pemasukan">
                            </div>
                            <div class="form-group">
                                <label>Keterangan</label>
                                <input type="text" class="form-control" placeholder="Keterangan" name="keterangan">
                            </div>

                            
                        <div data-repeater-list="vouchers">
                        <div data-repeater-item>
                            <div class="row d-flex align-items-end">

                            <div class="col-md-6 col-12">
                                <div class="mb-1">
                                <label class="form-grup">Kode Rekening Pasangan</label>
                                <select class="form-control select2" name="korek_pasangan">
                                    <option>Pilih Kode Rekening</option>
                                    <?php foreach ($korek as $row): ?>
                                    <option value="<?php echo $row->korek ?>">
                                        <?php echo $row->korek ?> - <?php echo $row->deskripsiAkun ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="mb-1">
                                <label class="form-grup">Jumlah Pengeluaran/Kredit (Rp)</label>
                                <input
                                    type="text"
                                    class="form-control amount"
                                    name="jumlah_pengeluaran"
                                    placeholder="Jumlah pengeluaran"
                                />
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="mb-1">
                                <label class="form-grup">Keterangan</label>
                                <input
                                    type="text"
                                    class="form-control" 
                                    name="keterangan_pasangan"
                                    placeholder="Keterangan"
                                />
                                </div>
                            </div>

                            <div class="col-md-1 col-12">
                                <button class="btn btn-outline-danger text-nowrap mb-2" data-repeater-delete type="button">
                                    <span>Delete</span>
                                </button>
                            </div>
                            </div>
                            <hr />
                        </div>
                        </div>
                        <div class="row">
                        <div class="col-12">
                            <button class="btn btn-icon btn-primary" type="button" data-repeater-create>
                            <i data-feather="plus" class="me-25"></i>
                            <span>Add New</span>
                            </button>
                            <button class="btn btn-icon btn-primary" type="submit">
                            <i data-feather="plus" class="me-25"></i>
                            <span>Submit</span>
                            </button>
                        </div>
                        </div>
                    </form>
                    </div>
                </div>
                </div>
    