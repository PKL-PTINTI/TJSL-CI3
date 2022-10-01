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
        <h1>Management Data Menu</h1>
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
                                        href="<?= base_url('menu/add') ?>">Tambah Menu</a>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                    <th>No</th>
                                    <th>Nama Menu</th>
                                    <th>Parent Menu</th>
                                    <th>icon</th>
                                    <th>kategori</th>
                                    <th>Link</th>
                                    <th>Urutan Menu</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; foreach($listMenu->result() as $menu): ?>
                                    <tr>
                                        <td class="text-center"><?= $no++; ?></td>
                                        <td><?= $menu->nama_menu; ?></td>
                                        <td><?= $menu->nama_menu_parent; ?></td>
                                        <td>
                                            <i class="<?= $menu->icon; ?>"></i> &nbsp - &nbsp <?= $menu->icon; ?>
                                        </td>
                                        <td><?= $menu->kategori; ?></td>
                                        <td><?= $menu->href; ?></td>
                                        <td><?= $menu->sort; ?></td>
                                        <td><?= ($menu->status == 'Y') ? '<span class="badge badge-light-success">Aktif</span>' : '<span class="badge badge-light-danger">Tidak Aktif</span>'; ?></td>
                                        <td>
                                            <div class="dropdown">
                                                <a id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="<?php echo site_url('menu/update/' . $menu->id_menu); ?>"><i class="fa-solid fa-pen-to-square text-primary pr-2"></i> Update </a>
                                                    <a class="dropdown-item" href="<?php echo site_url('menu/delete/' . $menu->id_menu); ?>"><i class="fa-solid fa-user-lock text-danger pr-2"></i> Delete </a>
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
