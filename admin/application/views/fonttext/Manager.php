<?php $this->load->view('dist/_partials/header'); ?>

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><?= $title ?></h1>
            <a href="<?= site_url('FontTextManager/create') ?>" class="btn btn-primary ml-auto">
                ＋ 新規フォントを追加
            </a>
        </div>

        <div class="section-body">

            <table class="table table-bordered text-center">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>ページ</th>
                        <th>Font Family</th>
                        <th>Selector</th>
                        <th>Preview</th>
                        <th>削除</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($fonts as $f): ?>
                        <tr>
                            <td><?= $f->id ?></td>
                            <td><?= $f->page_key ?></td>
                            <td><?= $f->font_family ?></td>
                            <td><code><?= $f->css_selector ?></code></td>
                            <?= $f->font_url ?>
                            <td style="font-family: <?= $f->font_family ?>;">ABC あいうえお 漢字</td>
                            <td>
                                <a class="btn btn-danger btn-sm"
                                   href="<?= site_url('FontTextManager/delete/'.$f->id) ?>"
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
