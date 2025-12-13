<?php defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('dist/_partials/header'); ?>

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><?= $title ?></h1>
        </div>

        <div class="section-body">
            <h2>ブラックリスト管理</h2>

            <a class="btn btn-primary mb-3" href="<?= site_url('black_list/create_black_list') ?>">新規追加</a>

            <table class="table table-striped">
                <thead>
                    <tr class="text-center">
                        <th>IP</th>
                        <th>理由</th>
                        <th>ブロック時間</th>
                        <th>削除</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($black_list as $b): ?>
                        <tr class="text-center">
                            <td><?= $b->ip ?></td>
                            <td><?= $b->reason ?></td>
                            <td><?= date("Y-m-d H:i:s", $b->blocked_at) ?></td>
                            <td>
                                <a href="<?= site_url('black_list/delete/'.$b->ip) ?>" 
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('削除しますか？');">
                                   削除
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </section>
</div>

<?php $this->load->view('dist/_partials/footer'); ?>
