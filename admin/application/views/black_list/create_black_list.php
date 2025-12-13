<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>


<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('dist/_partials/header'); ?>

<style>
  textarea.form-control {
    min-height: 64px !important; /* chiều cao tối thiểu */
    height: auto !important;     /* cho phép kéo cao thêm */
    resize: vertical;            /* hoặc resize: both; */
}
</style>
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1><?php echo $title; ?></h1>
          </div>

          <div class="section-body">

            <h2>新規作成する</h2>

            <?php if (isset($success)): ?>
                <div class="alert alert-success"><?= $success ?></div>
            <?php elseif (isset($error)): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>
            <form method="post" class="bordered shadow-sm rounded-lg p-md-5 p-2" enctype="multipart/form-data">
              <div class="row">
                  <div class="form-group col-sm-6">
                    <label>IP</label>
                    <input type="text" name="IP" class="form-control" required>
                  </div>

                  <div class="form-group col-sm-6">
                    <label>理由</label>
                    <textarea type="text" name="reason" class="form-control" required></textarea>
                  </div>
              </div>

              <button type="submit" class="btn btn-primary">Submit</button>
            </form>


            <a class="btn btn-warning mt-3" href="<?= site_url('black_list/BlackListManage') ?>">リストに戻る</a>

          </div>
        </section>
      </div>




<?php
$this->load->view('dist/_partials/footer'); ?>

<script>
$(document).ready(function(){
  $('.custom-file-input').on('change', function(){
    var fileNames = Array.from(this.files).map(f => f.name).join(', ');
    $(this).next('.custom-file-label').html(fileNames);
  });
});
</script>

<?php if (!empty($success)): ?>
  <div class="alert alert-success"><?= $success ?></div>
  <script>
    setTimeout(function(){
      window.location.href = "<?= site_url('black_list/BlackListManage') ?>";
    }, 2000); // 2000 ms = 2s
  </script>
<?php endif; ?>