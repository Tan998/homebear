<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('dist/_partials/header');
?>

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><?= $title ?></h1>
        </div>

        <div class="section-body">

            <!-- Upload -->
            <form action="<?= site_url('Logo_Manager/upload') ?>" method="post" enctype="multipart/form-data" class="mb-4">
                <div class="card">
                    <div class="card-header"><h4>ロゴをアップロード</h4></div>
                    <div class="card-body">
                        <input type="file" name="logo_file" class="form-control mb-3">
                        <button class="btn btn-success">アップロード</button>
                    </div>
                </div>
            </form>

            <!-- Select logo -->
            <form action="<?= site_url('Logo_Manager/select') ?>" method="post">
                <div class="card">
                    <div class="card-header"><h4>ロゴを選択</h4></div>
                    <div class="card-body row">

                        <?php foreach ($logos as $img): ?>
                            <div class="col-md-3 text-center mb-3">
                                <img src="<?= base_url($img) ?>" class="img-fluid rounded shadow mb-2">
                                
                                <div>
                                    <input type="radio" name="logo_selected"
                                           value="<?= basename($img) ?>"
                                           <?= basename($img) == $setting['logo_filename'] ? 'checked' : '' ?>>
                                </div>

                                <a href="<?= site_url('Logo_Manager/delete/' . urlencode(basename($img))) ?>"
                                   class="btn btn-sm btn-danger mt-2"
                                   onclick="return confirm('削除しますか？')">削除</a>
                            </div>
                        <?php endforeach; ?>

                    </div>

                    <div class="card-footer text-right">
                        <button class="btn btn-primary w-100">保存</button>
                    </div>
                </div>
            </form>

        </div>
    </section>
</div>

<?php
$this->load->view('dist/_partials/footer');
?>
