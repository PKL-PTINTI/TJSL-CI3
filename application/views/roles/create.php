<section class="section">
    <div class="section-header">
        <h1>Roles Permission</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="<?= base_url('Admin/dashboard') ?>">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="<?= base_url('Roles') ?>">Role</a></div>
            <div class="breadcrumb-item">Create Roles</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Data Role</h4>
                    </div>
                    <form class="form-horizontal" role="form" action="<?php echo $action; ?>" method="POST">
                    <div class="card-body">
                        <div class="form-group">
							<label for="inputPassword">Name Hak Akses :</label>
								<input type="text" class="form-control" name="role" placeholder="Name Hak Akses" autocomplete="off" value="<?php if (isset($role)) {
																																					echo $role;
																																				} ?>">
						</div>
						<div class="form-group">
							<label for="inputPassword">Nama Lengkap Hak Akses :</label>
								<input type="text" class="form-control" name="full" placeholder="Nama Lengkap Hak Akses" autocomplete="off" value="<?php if (isset($full)) {
																																					echo $full;
																																				} ?>">
						</div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                  </form>
                </div>
            </div>
        </div>
    </div>
</section>