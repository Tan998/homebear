<?php $this->load->view('dist/_partials/header'); ?>

<div class="main-content">
<section class="section">
    <div class="section-header">
        <h1><?= $title ?></h1>
    </div>

    <div class="section-body">

        <form method="post" action="<?= site_url('video_manager/save') ?>">
            <div class="form-group">
                <label>Video tittle</label>
                <input type="text" name="video_title" class="form-control" placeholder="" required>
                <label>YouTube ID</label>
                <input type="text" name="youtube_id" class="form-control" placeholder="例： N8yl5KSNr3o" required>
                <br>
                <small>例：https://www.youtube.com/watch?v=<mark>N8yl5KSNr3o</mark>　→　「<mark>N8yl5KSNr3o</mark>」をコピーしてください。</small>
            </div>

            <input type="hidden" name="status" value="0">

            <button class="btn btn-primary">保存</button>
            <a href="<?= site_url('video_manager/VideoList') ?>" class="btn btn-secondary">戻る</a>
        </form>

    </div>
</section>
</div>

<?php $this->load->view('dist/_partials/footer'); ?>
