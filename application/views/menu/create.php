<section class="section">
    <div class="section-header">
        <h1>Modules Permission</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="<?= base_url('usersmanagement') ?>">Module</a></div>
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
                    <div class="card-body pt-0">
						<div class="form-group">
							<label for="inputPassword">Nama Menu</label>
								<input type="text" class="form-control" name="nama_menu" placeholder="Nama Menu" autocomplete="off" value="<?php if (isset($nama_menu)) {
																																				echo $nama_menu;
																																			} ?>">
						</div>
						<div class="form-group">
							<label for="inputPassword">Icon Menu</label>
								<input type="text" class="form-control" name="icon" placeholder="Icon Menu" autocomplete="off" value="<?php if (isset($icon)) {
																																			echo $icon;
																																		} ?>">
						</div>
						<div class="form-group">
							<label for="inputPassword">Parent Menu</label>
								<select class="form-select select2" data-control="select2" data-placeholder="Pilih Parent Menu..." name="id_menu_parent">
									<option value="">Pilih Parent Menu</option>
									<?php
									foreach ($listMenu->result() as $menu) {
										if ($menu->id_menu == $id_menu_parent) {
											echo '<option value="' . $menu->id_menu . '" selected >' . $menu->nama_menu . '</option>';
										} else {
											echo '<option value="' . $menu->id_menu . '">' . $menu->nama_menu . '</option>';
										}
									}
									?>
								</select>
						</div>
						<div class="form-group">
							<label for="inputPassword">Kategori</label>
								<?php
								if (isset($kategori) && $kategori == "Link") {
								?>
									<label class="radio-inline radio-primary">
										<input type="radio" name="kategori" value="Controller" class="form-check-input">
										Controllers
									</label>
									&nbsp
									<label class="radio-inline radio-primary">
										<input type="radio" name="kategori" value="Link" class="form-check-input" checked="checked">
										Link
									</label>
								<?php
								} else {
								?>
									<label class="radio-inline radio-primary">
										<input type="radio" name="kategori" value="Controller" class="form-check-input" checked="checked">
										Controllers
									</label>
									&nbsp
									<label class="radio-inline radio-primary">
										<input type="radio" name="kategori" value="Link" class="form-check-input">
										Link
									</label>
								<?php
								}
								?>
						</div>
						<div class="form-group">
							<label for="inputPassword">Link</label>
								<input type="text" class="form-control" name="href" placeholder="Link" autocomplete="off" value="<?php if (isset($href)) {
																																		echo $href;
																																	} ?>">
						</div>
						<div class="form-group">
							<label for="inputPassword">Urutan Menu</label>
								<input type="text" class="form-control" name="sort" placeholder="Urutan Menu" autocomplete="off" value="<?php if (isset($sort)) {
																																			echo $sort;
																																		} ?>">
						</div>
						<div class="form-group">
							<label for="inputPassword">Status</label>
								<?php
								if (isset($status) && $status == "N") {
								?>
									<label class="radio-inline radio-success">
										<input type="radio" name="status" value="Y" class="form-check-input">
										Aktif
									</label>
									<label class="radio-inline radio-danger">
										<input type="radio" name="status" value="N" class="form-check-input" checked="checked">
										Non Aktif
									</label>
								<?php
								} else {
								?>
									<label class="radio-inline radio-success">
										<input type="radio" name="status" value="Y" class="form-check-input" checked="checked">
										Aktif
									</label>
									&nbsp
									<label class="radio-inline radio-danger">
										<input type="radio" name="status" value="N" class="form-check-input">
										Non Aktif
									</label>
								<?php
								}
								?>
						</div>
                        <button type="submit" class="btn btn-primary">
								<i class="fas fa-plus"></i>&nbsp Simpan
							</button>
					</div>
                  </form>
                </div>
            </div>
        </div>
    </div>
</section>