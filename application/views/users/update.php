<?php
$nama_lengkap = array(
    'name' => 'nama_lengkap',
    'id' => 'nama_lengkap',
    'class' => 'form-control',
    'value' => $data_name,
    'autocomplete' => 'off'
);
$username = array(
    'name' => 'username',
    'id' => 'username',
    'class' => 'form-control',
    'value' => $data_username,
    'maxlength' => $this->config->item('username_max_length', 'tank_auth'),
    'autocomplete' => 'off'
);
$email = array(
    'name' => 'email',
    'id' => 'email',
    'class' => 'form-control',
    'value' => $data_email,
    'autocomplete' => 'off'
);
$foto = array(
    'class' => 'form-control',
    'name' => 'foto',
    'id' => 'foto',
    'type' => 'file',
    'value' => set_value('foto'),
    'autocomplete' => 'off'
);
?>

<section class="section">
    <div class="section-header">
        <h1>Tambah Data User</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="<?= base_url('usersmanagement') ?>">User</a></div>
            <div class="breadcrumb-item">Tambah Data User</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
        <div class="col-md-4">
			<!-- Profile Image -->
			<div class="card card-primary card-outline">
				<div class="card-body box-profile">
					<div class="text-center mb-3">
                    <?php
                                $images="https://source.boringavatars.com/beam/120/" . urlencode($profile_name) . "?square&colors=FAD089,FF9C5B,F5634A,ED303C,3B8183";
                            ?>
						<!--<img class="profile-user-img img-fluid img-circle" src="--><?php //echo base_url('/assets/adminLTE3/foto-profil/' . $data_foto) ?><!--">-->
						<img class="img-fluid rounded w-75" src="<?php echo ($profile_foto != 'no_image.jpg') ? base_url('/assets/media/profiles/') . $profile_foto : $images ; ?>">
					</div>

					<h3 class="profile-username text-center"><?php if (isset($data_name)) {
							echo $data_name;
						} ?></h3>
					<ul class="list-group list-group-unbordered mb-3">
						<li class="list-group-item">
							<b>Username :</b> <a class="float-right"><?php echo $data_username; ?></a>
						</li>
						<li class="list-group-item">
							<b>Email :</b> <a class="float-right"><?php echo $data_email; ?></a>
						</li>
						<li class="list-group-item">
							<b>Jenis Kelamin :</b>
							<a class="float-right"><?php echo ($data_jenis_kelamin == 'P') ? 'Pria' : 'Wanita'; ?></a>
						</li>
						<li class="list-group-item">
							<b>Tanggal Lahir :</b> <a class="float-right"><?php echo $data_tangal_lahir; ?></a>
						</li>
						<li class="list-group-item">
							<b>Alamat :</b> <a class="float-right"><?php echo $data_alamat; ?></a>
						</li>
					</ul>
				</div>
				<!-- /.card-body -->
			</div>
			<!-- /.card -->
		</div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Data User</h4>
                    </div>
                    <?php echo form_open($action, 'class="form-horizontal" enctype="multipart/form-data"'); ?> 
                    <div class="card-body">
                        <div class="form-group">
                            <label>Nama Lengkap </label>
                            <?php echo form_input($nama_lengkap); ?>
                            <span style="color: red;"><?php echo form_error($nama_lengkap['name']); ?><?php echo isset($errors[$nama_lengkap['name']]) ? $errors[$nama_lengkap['name']] : ''; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Username</label>
                            <?php echo form_input($username); ?>
                            <span style="color: #f43f5e;"><?php echo form_error($username['name']); ?><?php echo isset($errors[$username['name']]) ? $errors[$username['name']] : ''; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <?php echo form_input($email); ?>
                            <span style="color: #f43f5e;"><?php echo form_error($email['name']); ?><?php echo isset($errors[$email['name']]) ? $errors[$email['name']] : ''; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Jenis Kelamin &nbsp</label>
                            <input type="radio" name="gender" value="P"  <?php echo ($data_jenis_kelamin == 'P') ? 'checked' : ''; ?>>&nbsp Pria &nbsp
							<input type="radio" name="gender" value="W"  <?php echo ($data_jenis_kelamin == 'W') ? 'checked' : ''; ?>>&nbsp Wanita
                        </div>
                        <div class="form-group">
                            <label>Tanggal Lahir</label>
                            <input type="text" class="form-control" id="kt_datepicker_user" value="<?php echo $data_tangal_lahir; ?>" name="tanggal_lahir" placeholder="Tanggal Lahir"/>
                        </div>
                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea name="alamat" class="form-control" rows="5" placeholder="Alamat"><?php echo $data_alamat; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Foto</label>
                            <?php echo form_input($foto); ?>
                            <span style="color: #f43f5e;"><?php echo form_error($foto['name']); ?><?php echo isset($errors[$foto['name']]) ? $errors[$foto['name']] : ''; ?></span>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                    <?php echo form_close() ?>  
                </div>
            </div>
        </div>
    </div>
</section>