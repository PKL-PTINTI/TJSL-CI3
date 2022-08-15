<?= $this->session->flashdata('message'); ?>
<section class="section">
    <div class="section-header">
        <h1>Management Data COA</h1>
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
                                <?php if(uri_string() == 'admin/coa/'): ?>
                                <?php endif; ?>
                                <div>
                                    <a class="btn btn-primary mb-3" 
                                        href="<?= base_url('admin/') ?>">Export Data</a>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <th class="text-center">NO</th>
                                        <th>Kode Rekening</th>
                                        <th>Deskripsi Akun</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; foreach($coa as $row): ?>
                                    <tr>
                                        <td class="text-center"><?= $no++; ?></td>
                                        <td><?= $row->korek ?></td>
                                        <?php if($no % 2 == 0): ?>
                                        <td class="text-danger"><?= $row->deskripsiAkun ?></td>
                                        <?php else: ?>
                                        <td class="text-success"><?= $row->deskripsiAkun ?></td>
                                        <?php endif; ?>
                                        <td></td>
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
