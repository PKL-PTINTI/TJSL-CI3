<section class="section">
    <div class="section-header">
        <h1>Modules Permission</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="<?= base_url('Admin/dashboard') ?>">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="<?= base_url('usersmanagement') ?>">Modul</a></div>
            <div class="breadcrumb-item">Modules Permission</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Data Modul</h4>
                    </div>
                    <form class="form-horizontal" role="form" action="<?php echo $action; ?>" method="POST">
                    <div class="card-body">
                        <div class="form-group">
							<label for="inputPassword">Permission : </label>
								<input type="text" class="form-control" name="description" placeholder="Permission" autocomplete="off" value="<?php if (isset($description)) {
																																					echo $description;
																																				} ?>">
						</div>
						<div class="form-group">
							<label for="inputPassword">Controller : </label>
								<input type="text" class="form-control" name="permission" placeholder="Controller" autocomplete="off" value="<?php if (isset($permission)) {
																																					echo $permission;
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