<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('dist/_partials/header');
?>
<body>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
            <div class="login-brand">
              <img src="<?php echo base_url(); ?>assets/img/logo_brand/HOMEBEAR.webp" alt="logo" width="100" class="shadow-light rounded-circle">
            </div>

            <div class="card card-primary">
              <div class="card-header"><h4>Register</h4></div>
                <?php if (isset($error)) echo '<p style="color:red; padding-left:20px;">'.$error.'</p>'; ?>
                <?php if (isset($success)) echo '<p style="color:green; padding-left:20px;">'.$success.'</p>'; ?>
              <div class="card-body">
                <form method="POST">
                <?php if(false): ?>
                  <div class="row">
                    <div class="form-group col-6">
                      <label for="frist_name">First Name</label>
                      <input id="frist_name" type="text" class="form-control" name="frist_name" autofocus>
                    </div>
                    <div class="form-group col-6">
                      <label for="last_name">Last Name</label>
                      <input id="last_name" type="text" class="form-control" name="last_name">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control" name="email">
                    <div class="invalid-feedback">
                    </div>
                  </div>
                    <?php endif; ?>
                    <div class="form-group w-100">
                        <label for="username">User Name</label>
                        <input id="username" class="form-control" type="text" name="username" placeholder="username" required>
                    <div class="invalid-feedback">
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-6">
                      <label for="password" class="d-block">Password</label>
                      <input id="password" type="password" class="form-control pwstrength" data-indicator="pwindicator" name="password">
                      <div id="pwindicator" class="pwindicator">
                        <div class="bar"></div>
                        <div class="label"></div>
                      </div>
                    </div>
                    <div class="form-group col-6">
                      <label for="password2" class="d-block">Password Confirmation</label>
                      <input id="password2" type="password" class="form-control" name="password-confirm">
                    </div>
                  </div>

                  <div class="form-divider">
                    Role
                  </div>
                  <div class="row">
                    <div class="form-group col-6">
                        <label>Select role</label>
                        <select class="form-control selectric" name="role">
                            <option selected value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                  </div>
                <?php if(false): ?>
                  <div class="row">
                    <div class="form-group col-6">
                      <label>City</label>
                      <input type="text" class="form-control">
                    </div>
                    <div class="form-group col-6">
                      <label>Postal Code</label>
                      <input type="text" class="form-control">
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" name="agree" class="custom-control-input" id="agree">
                      <label class="custom-control-label" for="agree">I agree with the terms and conditions</label>
                    </div>
                  </div>
                <?php endif; ?>
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block">
                      Register
                    </button>
                    <p class="text-center pt-3">または</p>
                    <a class="btn btn-warning btn-lg btn-block" href="<?= site_url('auth/login') ?>">ログイン</a>
                  </div>
                </form>
              </div>
            </div>
            <div class="simple-footer">
              Copyright &copy; <script>
                document.write(new Date().getFullYear())
              </script> <div class="bullet"></div> <a href="#">HomeBear</a>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
<?php if (isset($success)): ?>
    <div class="alert alert-success"><?= $success ?></div>
    <script>
        setTimeout(function() {
            window.location.href = "<?= site_url('auth/login') ?>";
        }, 2000); // 2000 milliseconds = 2 seconds
    </script>
<?php endif; ?>

<?php $this->load->view('dist/_partials/js'); ?>