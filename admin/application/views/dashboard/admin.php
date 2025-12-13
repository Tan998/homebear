
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('dist/_partials/header'); ?>

    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1><?php echo $title; ?></h1>
          </div>

          <div class="section-body">
            <!--<h2><?= $session_data['username'] ?> (Admin) ようこそ！</h2>-->
      			<img class="img-fluid w-100" src="<?php echo base_url(); ?>assets/img/logo_brand/HOMEBEAR.webp" alt="">
      			<a href="<?= site_url('auth/logout') ?>">ログアウト</a>
      			<!--<pre><?php print_r($session_data); ?></pre>-->
          </div>
        </section>
      </div>
<?php
$this->load->view('dist/_partials/footer'); ?>