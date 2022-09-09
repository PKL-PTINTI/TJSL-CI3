<?= $this->session->flashdata('message'); ?>
<style>
    .badge-light-success {
        color: #50CD89;
        background-color: #E8FFF3;
    }
    .badge-light-danger {
        color: #F1416C;
        background-color: #FFF5F8;
    }
</style>
<section class="section">
    <div class="section-header">
        <h1>Management Data Modules</h1>
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
                                        href="<?= base_url('Permission/add') ?>">Tambah Module</a>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Modul</th>
                                        <th>Controller</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; foreach($listPermission->result() as $permission): ?>
                                    <tr>
                                        <td class="text-center"><?= $no++; ?></td>
                                        <td><?php echo $permission->description; ?></td>
                                        <td><?php echo $permission->permission; ?></td>
                                        <td>
                                            <div class="dropdown">
                                                <a id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="<?php echo site_url('Permission/update/' . $permission->permission_id); ?>"><i class="fa-solid fa-pen-to-square text-primary pr-2"></i> Update </a>
                                                    <a class="dropdown-item" href="<?php echo site_url('Permission/delete/' . $permission->permission_id); ?>"><i class="fa-solid fa-user-lock text-danger pr-2"></i> Delete </a>
                                                </div>
                                            </div>
                                        </td>
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
