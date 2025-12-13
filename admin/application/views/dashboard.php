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
            <h2>Chào mừng <?= $session_data['username'] ?></h2>
            <p>Đây là dashboard của bạn.</p>

            <a href="<?= site_url('auth/logout') ?>">Đăng xuất</a>

            <pre><?php print_r($session_data); ?></pre>

          </div>
        </section>
      </div>
<?php
$this->load->view('dist/_partials/footer'); ?>