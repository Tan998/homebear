<?php $this->load->view('dist/_partials/header'); ?>

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><?= $title ?></h1>
        </div>

        <div class="section-body">

            <?php if (!$has_profile): ?>
                <a class="btn btn-primary mb-3" href="<?= site_url('Company_Profile_Manager_Ver2/create') ?>">
                    新しい会社概要を作成する
                </a>
            <?php endif; ?>

            <table class="table table-bordered table-striped text-center align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>タイトル</th>
                        <th>作成日</th>
                        <th>画像</th>
                        <th>編集</th>
                    </tr>
                </thead>

                <tbody>

                    <?php if (!$has_profile): ?>

                        <!-- Chưa có bài → thông báo -->
                        <tr>
                            <td colspan="5" class="text-muted py-4">
                                まだ会社概要が登録されていません。
                            </td>
                        </tr>

                    <?php else: ?>

                        <?php $p = $first_profile; ?>

                        <tr>
                            <td><?= $p->id ?></td>

                            <!-- Title text -->
                            <td><?= mb_strimwidth(strip_tags($p->text_company_profile), 0, 40, "...") ?></td>

                            <td><?= $p->created_at ?></td>

                            <td>
                                <?php if (!empty($p->title_img)): ?>
                                    <img src="<?= base_url('uploads/company_profile_ver2/title_img/1/'.$p->title_img) ?>" width="90">
                                <?php else: ?>
                                    <span class="text-muted">なし</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <a class="btn btn-warning btn-sm"
                                   href="<?= site_url('Company_Profile_Manager_Ver2/edit/'.$p->id) ?>">
                                    編集
                                </a>
                            </td>
                        </tr>

                    <?php endif; ?>

                    </tbody>


            </table>

        </div>
    </section>
</div>

<?php $this->load->view('dist/_partials/footer'); ?>
