<?= $this->session->flashdata('message'); ?>
<section class="section">
    <div class="section-header">
        <h1>Alokasi Piutang Mitra</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="<?= base_url('Admin/agingRate') ?>">Aging rate</a></div>
            <div class="breadcrumb-item"><?= $header ?></div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4><?= $header; ?></h4>
                    </div>
                    <div class="card-body">
                        <a href="<?= base_url('Admin/agingrate/exportAlokasiPiutang') ?>" class="btn btn-primary mb-3">Export Alokasi Piutang</a>
                        <div>
                            <table class="table table-striped" id="table-piutang">
                                <thead>
                                    <tr>
                                        <th class="text-center">NO</th>
                                        <th>Nokontrak</th>
                                        <th>Saldo Pokok</th>
                                        <th>kolektibilitas</th>
                                        <th>Alokasi Sisih</th>
                                        <th>Sektor Usaha</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; foreach($piutangmitra as $piutang): ?>
                                    <tr>
                                        <td class="text-center"><?= $no++; ?></td>
                                        <td><?= $piutang['nokontrak']; ?></td>
                                        <td><?= number_format($piutang['sisapinjaman']); ?></td>
                                        <td><?= $piutang['status']; ?></td>
                                        <td><?= number_format($piutang['alokasisisih']); ?></td>
                                        <td><?= $piutang['sektor']; ?></td>
                                        <td><?= $piutang['masalah']; ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tr>
                                    <td class="text-center"></td>
                                    <td></td>
                                    <td><?= number_format($saldopiutang); ?></td>
                                    <td></td>
                                    <td><?= number_format($alokasisisih); ?></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</section>
