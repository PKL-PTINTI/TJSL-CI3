<?php
$username = array(
		'name' => 'username',
		'id' => 'username',
		'class' => 'form-control',
		'value' => set_value('username'),
		'maxlength' => $this->config->item('username_max_length', 'tank_auth'),
		'placeholder' => 'Username',
		'autocomplete' => 'off'
);
$email = array(
		'name' => 'email',
		'id' => 'email',
		'class' => 'form-control',
		'value' => set_value('email'),
		'placeholder' => 'Email',
		'autocomplete' => 'off'
);
$password = array(
		'name' => 'password',
		'id' => 'password',
		'class' => 'form-control',
		'placeholder' => 'Katasandi',
		'value' => set_value('password'),
		'maxlength' => $this->config->item('password_max_length', 'tank_auth'),
		'size' => 30,
		'autocomplete' => 'off'
);
$confirm_password = array(
		'name' => 'confirm_password',
		'id' => 'confirm_password',
		'class' => 'form-control',
		'placeholder' => 'Konfirmasi Katasandi',
		'value' => set_value('confirm_password'),
		'maxlength' => $this->config->item('password_max_length', 'tank_auth'),
		'size' => 30,
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
$captcha = array(
		'name' => 'captcha',
		'id' => 'captcha',
		'class' => 'form-control',
		'placeholder' => 'Captcha',
		'autocomplete' => 'off'
);
$label_captcha = "Confirmation Code";
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
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Data User</h4>
                    </div>
                    <?php echo form_open($action, 'class="form-horizontal" enctype="multipart/form-data"'); ?> 
                    <div class="card-body">
                    <?php
						if (isset($registration_fields)) {
							foreach ($registration_fields as $val) {
								list($name, $label, , $type) = $val;
								$field = array('name' => $name, 'id' => $name, 'value' => set_value($name), 'placeholder' => $label, 'class' => 'form-control',);
								if ($type == 'text') {
									$field += array('size' => 30);
									$attr = isset($val[4]) ? $val[4] : FALSE;
									if ($attr) {
										foreach ($attr as $k => $v) {
											$field[$k] = $v;
										}
									}
									?>
									<div class="form-group">
										<label><?php echo $field['placeholder'] ?><span style="color:#f43f5e;">*</span></label>
										<?php echo form_input($field, array('class' => 'form-control', 'autocomplete' => 'off')); ?>
										<span style="color: #f43f5e;">
											<?php echo form_error($field['name']); ?><?php echo isset($errors[$field['name']]) ? $errors[$field['name']] : ''; ?>
										</span>
									</div>
									<?php
								}
							}
						}
						?>
                        <div class="form-group">
                            <label>Username<span style="color:#f43f5e;">*</span></label>
                            <?php echo form_input($username); ?>
                            <span style="color: #f43f5e;"><?php echo form_error($username['name']); ?><?php echo isset($errors[$username['name']]) ? $errors[$username['name']] : ''; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Email<span style="color:#f43f5e;">*</span></label>
                            <?php echo form_input($email); ?>
                            <span style="color: #f43f5e;"><?php echo form_error($email['name']); ?><?php echo isset($errors[$email['name']]) ? $errors[$email['name']] : ''; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Katasandi<span style="color:#f43f5e;">*</span></label>
                            <?php echo form_password($password); ?>
                            <span style="color: #f43f5e;"><?php echo form_error($password['name']); ?><?php echo isset($errors[$password['name']]) ? $errors[$password['name']] : ''; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Konfirmasi Katasandi<span style="color:#f43f5e;">*</span></label>
                            <?php echo form_password($confirm_password); ?>
                            <span style="color: #f43f5e;"><?php echo form_error($confirm_password['name']); ?><?php echo isset($errors[$confirm_password['name']]) ? $errors[$confirm_password['name']] : ''; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Jenis Kelamin<span style="color:#f43f5e;">*</span> &nbsp</label>
                            <input type="radio" name="gender" value="P">&nbsp Pria &nbsp
							<input type="radio" name="gender" value="W">&nbsp Wanita
                        </div>
                        <div class="form-group">
                            <label>Tanggal Lahir</label>
                            <input type="text" class="form-control" id="kt_datepicker_user" name="tanggal_lahir" placeholder="Tanggal Lahir"/>
                        </div>
                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea name="alamat" class="form-control" rows="5" placeholder="Alamat"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Foto</label>
                            <?php echo form_input($foto); ?>
                            <span style="color: #f43f5e;"><?php echo form_error($foto['name']); ?><?php echo isset($errors[$foto['name']]) ? $errors[$foto['name']] : ''; ?></span>
                        </div>
                        <?php
                        if ($captcha_registration) {
                            if ($use_recaptcha) {
                                ?>
                                    <div class="fv-row mb-3">
                                    <center>
                                        <div class="captcha_wrapper">
                                        <div class="g-recaptcha" data-sitekey="6Le4OOEhAAAAAOZxVGIcU1NP5WXLO4UDOeOtHBX4"></div>
                                        <span style="color: #f43f5e;">
                                            <?php echo $this->session->flashdata('flashError'); ?>
                                        </span>
                                        </div>
                                    </center>
                                    </div>
                                <?php
                            } else {
                                ?>
                                    <div class="fv-row mb-3">
                                    <center for="user" class="label">
                                        <img src="<?php echo base_url('Auth/captcha'); ?>" />
                                        <label for="captcha" class="label"><?php echo $label_captcha; ?></label>
                                        <div class="mws-form-item large">
                                        <?php echo form_input($captcha); ?>
                                        </div>
                                        <span style="color: #f43f5e;"><?php echo form_error($captcha['name']); ?></span>
                                    </center>
                                    </div>
                                <?php
                            }
                        }
                        ?>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                    <?php echo form_close() ?>  
                </div>
            </div>
        </div>
    </div>
</section>