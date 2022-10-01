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
        <h1>Management Data Users</h1>
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
                                        href="<?= base_url('usersmanagement/create') ?>">Tambah User</a>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <th class="text-center">NO</th>
                                        <th>Username</th>
                                        <th>Nama lengkap</th>
                                        <th>Status</th>
                                        <th>Banned</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; foreach($listuser->result() as $user): ?>
                                    <tr>
                                        <td class="text-center"><?= $no++; ?></td>
                                        <td><?= $user->username; ?></td>
                                        <td><?= $user->name; ?></td>
                                        <td><?php echo ($user->activated == '1') ? '<span class="badge badge-light-success">Aktif</span>' : '<span class="badge badge-light-danger">Tidak Aktif</span>'; ?></td>
                                        <td><?php echo ($user->banned == '1') ? '<span class="badge badge-light-danger">Banned</span>' : '<span class="badge badge-light-success">Unbanned</span>'; ?></td>
                                        <td>
                                            <div class="dropdown">
                                                <a id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <?php if ($user->activated != 0): ?>
                                                        <a class="dropdown-item" href="<?php echo site_url('usersmanagement/update/' . $user->id_user); ?>"><i class="fa-solid fa-pen-to-square text-primary pr-2"></i> Update </a>
                                                    <?php endif ?>
                                                    <?php if ($user->banned == '1'): ?>
                                                        <a class="dropdown-item" href="<?php echo site_url('usersmanagement/unbanned/' . $user->id_user); ?>"><i class="fa-solid fa-user-check text-warning pr-2"></i> Unbanned </a>
                                                    <?php else: ?>
                                                        <?php if ($user->activated != 0): ?>
                                                            <a class="dropdown-item" href="<?php echo site_url('usersmanagement/banned/' . $user->id_user); ?>"><i class="fa-solid fa-user-lock text-danger pr-2"></i> Banned </a>
                                                        <?php endif ?>
                                                    <?php endif ?>
                                                    <?php if ($user->activated == '0'): ?>
                                                        <a class="dropdown-item" href="<?php echo site_url('usersmanagement/activate/' . $user->id_user); ?>"><i class="fa-solid fa-check-to-slot text-success pr-2"></i> Aktifasi </a>
                                                    <?php endif ?>
                                                    <?php if ($user->activated != 0): ?>
                                                        <a class="dropdown-item" href="<?php echo site_url('usersmanagement/change_role/' . $user->id_user); ?>"><i class="fa-solid fa-user-shield text-info pr-2"></i> Hak Akses </a>
                                                    <?php endif ?>
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
