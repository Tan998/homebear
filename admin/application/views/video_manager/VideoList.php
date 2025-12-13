<?php $this->load->view('dist/_partials/header'); ?>

<div class="main-content">
<section class="section">
    <div class="section-header">
        <h1><?= $title ?></h1>
        <div class="section-header-button">
            <a href="<?= site_url('video_manager/VideoCreate') ?>" class="btn btn-primary">＋　動画登録</a>
        </div>
    </div>

    <div class="section-body">

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>YouTube ID</th>
                    <th>プレビュー</th>
                    <th>状態</th>
                    <th>削除</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($videos as $v): ?>
                <tr>
                    <td><?= $v->title ?></td>
                    <td><?= $v->youtube_id ?></td>

                    <td>
                        <iframe width="200" height="110" 
                            src="https://www.youtube.com/embed/<?= $v->youtube_id ?>?mute=1" 
                            frameborder="0"></iframe>
                    </td>

                    <td>
                        <?php if($v->status == 1): ?>
                            <a href="<?= site_url('video_manager/toggle_status/'.$v->id) ?>" 
                               class="btn btn-success btn-sm">表示</a>
                        <?php else: ?>
                            <a href="<?= site_url('video_manager/toggle_status/'.$v->id) ?>" 
                               class="btn btn-secondary btn-sm">非表示</a>
                        <?php endif; ?>
                    </td>

                    <td>
                        <a href="<?= site_url('video_manager/delete/'.$v->id) ?>" 
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('削除しますか？')">削除</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>
</section>
</div>

<?php $this->load->view('dist/_partials/footer'); ?>
