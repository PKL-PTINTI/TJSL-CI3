<?php
$login = array(
	'name' => 'login',
	'id' => 'user',
	'value' => set_value('login'),
	'placeholder' => 'Username',
	'class' => 'form-control',
	'autocomplete' => 'off'
);
if ($login_by_username and $login_by_email) {
	$login_label = 'Email or username';
} else if ($login_by_username) {
	$login_label = 'Login';
} else {
	$login_label = 'Email';
}
$password = array(
	'name' => 'password',
	'id' => 'pass',
	'data-type' => 'password',
	'value' => set_value('password'),
	'class' => 'form-control',
	'placeholder' => 'Password',
	'autocomplete' => 'off'
);
$remember = array(
	'name' => 'remember',
	'id' => 'monthly',
	'class' => 'custom-control-input',
	'value' => 1,
	'checked' => set_value('remember'),
	'autocomplete' => 'off',
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

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Login &mdash; TJSL</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/vendor/bootstrap-social/bootstrap-social.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/css/style.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/css/components.css">
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  <style>
    .err {
            color: red;
            font-weight: bold;
        }
  </style>
</head>

<body>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="login-brand">
              <img src="<?= base_url() ?>assets/img/INTI.PNG" alt="logo" width="150">
            </div>

            <div class="card card-primary">
              <div class="card-header"><h4>Login </h4></div>

              <div class="card-body">
					    <?php echo form_open($this->uri->uri_string(), array('class' => 'form w-100', 'novalidate' => 'novalidate', 'id' => 'kt_sign_in_form')); ?>
                  <div class="form-group">
                    <label for="email">Username</label>
                    <?php echo form_input($login, array('class' => 'form-control form-control-lg form-control-solid', 'autocomplete' => 'off')); ?>
                    <span style="color: #f43f5e;">
                      <?php echo form_error($login['name']); ?>
                      <?php echo isset($errors[$login['name']]) ? $errors[$login['name']] : ''; ?>
                    </span>
                  </div>
                  <div class="form-group">
                    	<label for="password" class="control-label">Password</label>
                      <?php echo form_password($password, array('class' => 'form-control form-control-lg form-control-solid', 'autocomplete' => 'off')); ?>
                      <span style="color: #f43f5e;">
                        <?php echo form_error($password['name']); ?>
                        <?php echo isset($errors[$password['name']]) ? $errors[$password['name']] : ''; ?>
                      </span>
                  </div>
                  <?php
                    if ($show_captcha) {
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
                      }
                      if (!$use_recaptcha) {
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
                  <div class="form-group">
                    <div class="custom-control custom-checkbox">
                    <?php echo form_checkbox($remember, array('class' => 'custom-control-input', 'id' => 'flexCheckDefault')); ?>
                    <label class="custom-control-label" for="monthly">Ingat saya</label>
                    </div>
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                      Login
                    </button>
                  </div>
                  <?php echo form_close(); ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- General JS Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  <script src="<?= base_url() ?>assets/js/stisla.js"></script>

  <!-- JS Libraies -->

  <!-- Template JS File -->
  <script src="<?= base_url() ?>assets/js/scripts.js"></script>
  <script src="<?= base_url() ?>assets/js/custom.js"></script>

  <!-- Page Specific JS File -->
</body>
</html>

