<section class="section">
    <div class="section-header">
        <h1>Ubah Hak Akses</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="<?= base_url('Admin/dashboard') ?>">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="<?= base_url('usersmanagement') ?>">User</a></div>
            <div class="breadcrumb-item">Ubah Hak Akses</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Data User</h4>
                    </div>
                    <form class="form-horizontal" role="form" action="<?php echo $action; ?>" method="POST">
                    <div class="card-body">
                        <div class="mb-3 row">
							<label for="inputPassword" class="col-sm-2 col-form-label text-end">Hak Akses<span style="color:red;">*</span></label>
							<div class="col-sm-10">
								<select class="form-control role select2" name="role_id" tabindex="2">
									<?php
									foreach ($listRoles->result() as $role) {
										?>
										<option value="<?php echo $role->role_id ?>" <?php if ($role->role_id == $role_id_change) {
											echo 'selected="selected"';
										} ?>><?php echo $role->full; ?></option>
										<?php
									}
									?>
								</select>
								<span style="color: red;"><?php echo form_error('role_id'); ?></span>
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