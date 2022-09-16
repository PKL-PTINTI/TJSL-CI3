<style>
    .btn-outline-primary, .btn-outline-primary.disabled {
        border-color: #004666;
        color: #e9ecef;
    }
</style>
<section class="section">
    <div class="section-header">
        <h1>Modules Permission</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="<?= base_url('Admin/dashboard') ?>">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="<?= base_url('Usersmanagement') ?>">Module</a></div>
            <div class="breadcrumb-item">Modules Permission</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Data Module</h4>
                    </div>
                    <form class="form-horizontal" role="form" action="<?php echo $action; ?>" method="POST">
                    <div class="card-body">
                        <div class="contanier">
                            <div class="row">
                                <div class="form-group">
                                    <input type="hidden" class="form-control" name="flag" placeholder="Permission" autocomplete="on" value="1">
                                        <select class="duallistbox" multiple="multiple" name="permission_id[]">
                                            <?php
                                            foreach ($listPermission->result() as $permission) {
                                                (in_array($permission->permission_id, $listPermissionByRoles)) ? $pilih = 'selected' : $pilih = '';
                                            ?>
                                                <option value="<?php echo $permission->permission_id ?>" <?php echo $pilih; ?>><?php echo $permission->description; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                  </form>
                </div>
            </div>
        </div>
    </div>
</section>