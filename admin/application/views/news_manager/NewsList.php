<?php $this->load->view('dist/_partials/header'); ?>
<style>
.flash-msg {
    opacity: 1;
    transition: opacity 0.5s ease;  /* fade-out 0.5s */
}
.flash-msg.hide {
    opacity: 0;
}
</style>
<div class="main-content">
<section class="section">

    <div class="section-header">
        <h1><?= $title ?></h1>
        <div class="section-header-button">
            <a href="<?= site_url('news_manager/create') ?>" class="btn btn-primary">ニュース登録</a>
        </div>
    </div>

    <div class="section-body">
        <?php if($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show flash-msg" role="alert">
                <?= $this->session->flashdata('success') ?>
            </div>
        <?php 
            $this->session->unset_userdata('success');
        endif; 
        ?>

        <?php if($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show flash-msg" role="alert">
                <?= $this->session->flashdata('error') ?>
            </div>
        <?php 
            $this->session->unset_userdata('error');
        endif; 
        ?>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>タイトル</th>
                    <th>登録日</th>
                    <th>編集/削除</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($news as $n): ?>
                <tr>
                    <td><?= $n->id ?></td>
                    <td><?= $n->news_title ?></td>
                    <td><?= $n->publish_date ?></td>
                    <td>
                        <a href="<?= site_url('news_manager/edit/'.$n->id) ?>" class="btn btn-warning btn-sm">編集</a>
                        <a href="<?= site_url('news_manager/delete/'.$n->id) ?>"
                            onclick="return confirm('削除しますか？')"
                            class="btn btn-danger btn-sm">削除</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>
</section>
</div>
<script>
document.addEventListener("DOMContentLoaded", () => {
    const alerts = document.querySelectorAll('.flash-msg');
    if (alerts.length > 0) {
        setTimeout(() => {
            alerts.forEach(alert => {
                alert.classList.add('hide');
                setTimeout(() => {
                    alert.style.display = 'none';
                }, 500);
            });
        }, 3000);
    }
});
</script>

<?php $this->load->view('dist/_partials/footer'); ?>
