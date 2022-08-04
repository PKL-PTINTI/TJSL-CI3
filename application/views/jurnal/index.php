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
                                <?php if(uri_string() == 'admin/jurnal'): ?>
                                <?php endif; ?>
                                <div>
                                    <a class="btn btn-primary mb-3" 
                                        href="<?= base_url('admin/jurnal/create') ?>">Tambah Data Jurnal</a>
                                    <a class="btn btn-primary mb-3 "
                                        href="<?= base_url('admin/jurnal/voucher') ?>">Tambah Data Voucher</a>
                                    <a class="btn btn-primary mb-3 "
                                        href="<?= base_url('admin/jurnal/periodaopex') ?>">Perioda</a>
                                    <a class="btn btn-primary mb-3 "
                                        href="<?= base_url('admin/jurnal/createExcel') ?>">Export Excel</a>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-jurnal">
                                <thead>
                                    <tr>
                                        <th class="text-center">NO</th>
                                        <th>No ID</th>
                                        <th>No Akun</th>
                                        <th>Tanggal</th>
                                        <th>Pemasukan</th>
                                        <th>Pengeluaran</th>
                                        <th>Saldo</th>
                                        <th>Status Balance</th>
                                        <th>Deskripsi</th>
                                        <th>Keterangan</th>
                                        <th>No bukti</th>
                                        <th>Total Pemasukan</th>
                                        <th>Total Pengeluaran</th>
                                        <th>Tampil</th>
                                        <th>Updated</th>
                                        <th>Tanggal Updated</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>