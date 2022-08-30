<?= $this->session->flashdata('message'); ?>
<section class="section">
    <div class="section-header">
        <h1>Neraca Saldo</h1>
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
                                <div>
                                    <a class="btn btn-primary mb-3" 
                                        href="<?= base_url('Admin/NeracaSaldo/CreateExcel') ?>">Export Data</a>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">NO</th>
                                        <th>Kode Rekening</th>
                                        <th>Uraian</th>
                                        <th><?= 'Des ' . date('y', mktime(0, 0, 0, 0,0 , date("Y"))) ?></th>
                                        <th>Debet <?= $bulan ?></th>
                                        <th>Kredit <?= $bulan ?></th>
                                        <th>Saldo <?= $bulan ?></th>   
                                        <th>Selisih</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php foreach ($neracasaldo as $n): ?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td><?= $n['id_akun'] ?></td>
                                        <td><?= $n['nama_akun'] ?></td>
                                        <td><?= number_format($n['des' . date('y', mktime(0, 0, 0, 0,0 , date("Y")))]) ?></td>
                                        <td><?= number_format($n['debet' . $perioda]) ?></td>
                                        <td><?= number_format($n['kredit' . $perioda]) ?></td>
                                        <td><?= number_format($n['saldo' . $perioda]) ?></td>
                                        <td><?= $n['selisih'] ?></td>
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