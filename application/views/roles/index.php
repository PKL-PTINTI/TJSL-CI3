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
        <h1>Management Data Roles</h1>
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
                                        href="<?= base_url('Roles/add') ?>">Tambah Hak Akses</a>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                    <th>No</th>
                                    <th>Hak Akses</th>
                                    <th>Nama Lengkap Hak Akses</th>
                                    <th>Default</th>
                                    <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; foreach($listRoles->result() as $role): ?>
                                    <tr>
                                        <td class="text-center"><?= $no++; ?></td>
                                        <td><?php echo $role->role; ?></td>
                                        <td><?php echo $role->full; ?></td>
                                        <td><?php if ($role->default == '1') {
                                                echo '<span class="badge badge-light-success">Aktif</span>';
                                            } else {
                                                echo '<span class="badge badge-light-danger">Tidak Aktif</span>';
                                            }; ?></td>
                                        <td>
                                            <div class="dropdown">
                                                <a id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="<?php echo site_url('Roles/change_default/' . $role->role_id); ?>"><i class="fa-solid fa-square-check text-primary"></i>&nbsp Default</a>
                                                    <a class="dropdown-item" href="<?php echo site_url('Roles/role_permission/' . $role->role_id); ?>"><i class="fa-solid fa-hands-holding-circle text-sucsess"></i>&nbsp Modul</a>
                                                    <a class="dropdown-item" href="<?php echo site_url('Roles/update/' . $role->role_id); ?>"><i class="fa-solid fa-pen-to-square text-warning"></i>&nbsp Update</a>
                                                    <a class="dropdown-item" href="<?php echo site_url('Roles/delete/' . $role->role_id); ?>" onclick="return confirm('Apakah Anda Yakin UntuK Menghapus Data?')"><i class="fa-solid fa-trash-can text-danger"></i>&nbsp Hapus</a>
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
