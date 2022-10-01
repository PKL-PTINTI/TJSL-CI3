<?= $this->session->flashdata('message'); ?>
<section class="section">
    <div class="section-header">
        <h1>Aging Rate</h1>
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
                        <h4><?= $header; ?></h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col d-flex justify-content-between">
                                <?php if(uri_string() == 'admin/aging_rate/'): ?>
                                <?php endif; ?>
                                <div>
                                    <a class="btn btn-primary mb-3" 
                                        href="<?= base_url('admin/agingrate/createexcel') ?>">Export Data</a>
                                    <a class="btn btn-primary mb-3" 
                                        href="<?= base_url('admin/agingrate/hitungagingrate') ?>">Hitung Aging Rate</a>
                                </div>
                            </div>
                        </div>
                        <div>
                            <table class="table table-striped" id="table-agingrate">
                                <thead>
                                    <tr>
                                        <th class="text-center">NO</th>
                                        <th>Tanggal</th>
                                        <th>Lancar</th>
                                        <th>Kurang Lancar</th>
                                        <th>Diragukan</th>
                                        <th>Macet</th>
                                        <th>Selisih</th>
                                        <th>Jumlah</th>
                                        <th>Lancar Ke Kurang Lancar</th>
                                        <th>Kurang Lancar Ke Diragukan</th>
                                        <th>Diragukan Ke Macet</th>
                                        <th>Prodef Lancar</th>
                                        <th>Prodef Kurang Lancar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; foreach($agingrate as $jurnal): ?>
                                    <tr>
                                        <td class="text-center"><?= $no++; ?></td>
                                        <td><?= $jurnal->bulan; ?></td>
                                        <td><?= number_format($jurnal->lancar); ?></td>
                                        <td><?= number_format($jurnal->kuranglancar); ?></td>
                                        <td><?= number_format($jurnal->diragukan); ?></td>
                                        <td><?= number_format($jurnal->macet); ?></td>
                                        <td><?= number_format($jurnal->selisih); ?></td>
                                        <td><?= number_format($jurnal->jumlah); ?></td>
                                        <td><?= $jurnal->lankekrglan; ?></td>
                                        <td><?= $jurnal->krglankediragu; ?></td>
                                        <td><?= $jurnal->diragukemacet; ?></td>
                                        <td><?= $jurnal->prodeflancar; ?></td>
                                        <td><?= $jurnal->prodefkuranglancar; ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</section>
