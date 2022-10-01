<?= $this->session->flashdata('message'); ?>
<section class="section">
    <div class="section-header">
        <h1>Saldo Kas dan Bank <?= date("M Y", mktime(0, 0, 0, date('m'), 0, date('Y'))) ?></h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item"><?= $header ?></div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">NO</th>
                                        <th>Rekening</th>
                                        <th>Jumlah</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center">1</td>
                                        <td>Kas Kecil Jurnal</td>
                                        <td><?= number_format($saldokasbank[0]->kaskecil) ?></td>
                                        <td>
                                            <a class="btn btn-danger" href="<?= base_url('admin/saldo/update/kas') ?>">Update Saldo Kas</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">3</td>
                                        <td>Kas BRI Jurnal</td>
                                        <td><?= number_format($saldokasbank[0]->bri) ?></td>
                                        <td>
                                            <a class="btn btn-primary" href="<?= base_url('admin/saldo/update/bri') ?>">Update Saldo BRI</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">2</td>
                                        <td>Mandiri Jurnal</td>
                                        <td><?= number_format($saldokasbank[0]->mandiri) ?></td>
                                        <td>
                                            <a class="btn btn-primary" href="<?= base_url('admin/saldo/update/mandiri') ?>">Update Saldo Mandiri</a>
                                        </td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php
                        $totbank = $saldokasbank[0]->mandiri + $saldokasbank[0]->bri;
                        $all = $totbank + $saldokasbank[0]->kaskecil;
                    ?>
                    <div class="card-footer">
                        <p>
                            Saldo Bank : Rp. <?= number_format($totbank) ?>
                            <br>
                            Saldo Total : Rp. <?= number_format($all) ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>


</section>
