<?= $this->session->flashdata('message');?>
<section class="section">
    <div class="section-header">
        <h1>Management Data Jurnal</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item"><?= $type == 'perkiraan' ? 'Kartu Perkiraan' : 'Perioda' ?></div>
        </div>
    </div>

    <div class="section-body">
    <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4><?= $type == 'perkiraan' ? 'Kartu Perkiraan' : 'Perioda' ?> Tanggal Jurnal</h4>
                    </div>
                    <div class="card-body">
                        <form id="form-perioda" action="<?= base_url('Admin/jurnal/Perioda_data') ?>" method="post">
                            <div class="row">
                                <?php if($id_akun == '' AND $type == ''): ?>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Tanggal Awal</label>
                                            <input type="text" class="form-control datepicker" value="<?= date('Y-m-01') ?>" name="tanggal_awal">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Tanggal Akhir</label>
                                            <input type="text" class="form-control datepicker" name="tanggal_akhir">
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Tanggal Awal</label>
                                            <input type="text" class="form-control datepicker" value="<?= date('Y-m-d') ?>" name="tanggal_awal">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Tanggal Akhir</label>
                                            <input type="text" class="form-control datepicker" value="<?= date('Y-m-d', mktime(0, 0, 0, date("m")  , date("d")+1, date("Y"))) ?>" name="tanggal_akhir">
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <?= ($type != 'perkiraan') ? '<label>Isi \'0\' untuk \'Semua Korek/Akun ID\', \'1\' = KAS, \'2\' = Mandiri, \'3\' = BRI atau Isi Korek/Akun tertentu :</label>' : null ?>
                                <?php
                                    if($type == 'perkiraan'){
                                        echo '<input type="text" class="form-control d-none" value="'.trim($id_akun).'" name="korek">';
                                    } else {
                                        echo '<input type="text" class="form-control" placeholder="Korek" name="korek">';
                                    }
                                ?>
                            </div>
                            <button type="submit" class="btn btn-primary">Cari</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4><?= $header; ?> <span id="header"></span></h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-jurnal-perioda">
                                <thead>
                                    <tr>
                                        <th class="text-center">NO</th>
                                        <th>No ID</th>
                                        <th>No Akun</th>
                                        <th>Tanggal</th>
                                        <th>Pemasukan</th>
                                        <th>Pengeluaran</th>
                                        <th>Saldo</th>
                                        <th>Deskripsi</th>
                                        <th>Keterangan</th>
                                        <th>No bukti</th>
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