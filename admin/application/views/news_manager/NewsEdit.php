<?php $this->load->view('dist/_partials/header'); ?>

<div class="main-content">
<section class="section">

    <div class="section-header">
        <h1><?= $title ?></h1>
    </div>

    <div class="section-body">

        <form action="<?= site_url('news_manager/update/'.$news->id) ?>" method="post">

            <div class="form-group">
                <label>タイトル</label>
                <input type="text" name="news_title" value="<?= $news->news_title ?>" class="form-control" required>
            </div>

            <div class="form-group">
                <label>内容</label>
                <textarea name="news_content" class="form-control" rows="6" required><?= $news->news_content ?></textarea>
            </div>

            <div class="form-group">
                <label>Ngày đăng</label>
                <input type="date" name="publish_date" value="<?= $news->publish_date ?>" class="form-control" required>
            </div>

            <button class="btn btn-primary">更新</button>
            <a href="<?= site_url('news_manager') ?>" class="btn btn-secondary">戻る</a>

        </form>

    </div>

</section>
</div>

<?php $this->load->view('dist/_partials/footer'); ?>
