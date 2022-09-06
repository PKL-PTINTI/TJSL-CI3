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
                                <div>
                                    <a class="btn btn-primary mb-3" 
                                        href="<?= base_url('Admin/Jurnal/Create') ?>">Tambah Data Jurnal</a>
                                    <a class="btn btn-primary mb-3 "
                                        href="<?= base_url('Admin/Jurnal/Voucher') ?>">Tambah Data Voucher</a>
                                    <a class="btn btn-primary mb-3 "
                                        href="<?= base_url('Admin/Jurnal/Periodaopex') ?>">Perioda</a>
                                    <a class="btn btn-primary mb-3 "
                                        href="<?= base_url('Admin/Jurnal/CreateExcel') ?>">Export Excel</a>
                                    <a class="btn btn-primary mb-3 btndeletejurnal"
                                        href="#">TEST SWALL</a>

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