<?php $this->load->view('dist/_partials/header'); ?>

<div class="main-content">
<section class="section">

    <div class="section-header">
        <h1><?= $title ?></h1>
    </div>

    <div class="section-body">

        <form action="<?= site_url('news_manager/save') ?>" method="post">

            <div class="form-group">
                <label>タイトル</label>
                <input type="text" name="news_title" class="form-control" required>
            </div>

            <div class="form-group">
                <label>内容</label>
                <textarea name="news_content" class="form-control" rows="6" required></textarea>
            </div>

            <div class="form-group">
                <label>登録日</label>
                <input type="date" name="publish_date" class="form-control" required>
            </div>

            <button class="btn btn-primary">保存</button>
            <a href="<?= site_url('news_manager') ?>" class="btn btn-secondary">戻る</a>
        </form>

    </div>

</section>
</div>

<?php $this->load->view('dist/_partials/footer'); ?>
