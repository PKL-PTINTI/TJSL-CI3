<?= $this->session->flashdata('message'); ?>
<section class="section">
    <div class="section-header">
        <h1>Catatan Atas Laporan Keuangan</h1>
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
                                <?php if(uri_string() == 'admin/laporan/Catatan'): ?>
                                <?php endif; ?>
                                <div>
                                    <a class="btn btn-primary mb-3" 
                                        href="<?= base_url('admin/laporan') ?>">Import Data</a>
                                    <a class="btn btn-primary mb-3 "
                                        href="<?= base_url('admin/aporan') ?>">Cetak Laporan</a>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-laporan">
                                <thead>
                                    <tr>
                                        <th class="text-center">NO</th>
                                        <th>keterangan</th>
                                        <th>Akhir DES 2021</th>
                                        <th>Akhir JUL 2022</th>
                                        <th>RKA JUL 2022 (1)</th>
                                        <th>RKA SD JUL 2022 (2)</th>
                                        <th>Realisasi JUL 2022 (3)</th>
                                        <th>Realisasi SD JUL 2022 (4)</th>
                                        <th>RKA JUL 2021 (5)</th>
                                        <th>RKA SD JUL 2021 (6)</th>
                                        <th>(3:1) % RKA JAN 2022</th>
                                        <th>(4:2) % RKA SD JAN 2022</th>
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