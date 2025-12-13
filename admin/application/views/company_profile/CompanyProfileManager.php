<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('dist/_partials/header'); ?>

<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><?php echo $title; ?></h1>
        </div>

        <div class="section-body">

            <h2>会社概要一覧</h2>

            <!-- nút tạo mới -->
            <?php if (!$has_profile) { ?>
                <a class="btn btn-primary mb-3" href="<?= site_url('company_profile/create_company_profile') ?>">
                    新しい会社概要を作成する
                </a>
            <?php } ?>
            

            <table id="table-company-profile" class="table table-striped">
                <thead>
                    <tr class="text-center align-middle">
                        <th>ID</th>
                        <th>会社名</th>
                        <th>作成日</th>
                        <th>タイトル画像</th>
                        <th>編集</th>
                        <th>削除</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($company_profile as $p): ?>
                    <tr class="text-center align-middle">

                        <!-- ID -->
                        <td>
                            <a href="<?= site_url('Company_Profile_Manager/edit/'.$p->id) ?>">
                                <?= $p->id ?>
                            </a>
                        </td>

                        <!-- Company Name -->
                        <td>
                            <?= htmlspecialchars($p->company_name) ?>
                        </td>

                        <!-- created_at -->
                        <td>
                            <?= $p->created_at ?>
                        </td>

                        <!-- Title Image -->
                        <td>
                            <?php if (!empty($p->title_img)): ?>
                                <img src="<?= base_url('uploads/company_profile/title_img/1/'.$p->title_img) ?>" width="100">
                            <?php else: ?>
                                <span class="text-muted">なし</span>
                            <?php endif; ?>
                        </td>

                        <!-- Edit -->
                        <td>
                            <a class="btn btn-warning btn-sm" href="<?= site_url('Company_Profile_Manager/edit/'.$p->id) ?>">
                                編集
                            </a>
                        </td>

                        <!-- Delete -->
                        <td>
                            <a class="btn btn-danger btn-sm"
                               href="<?= site_url('Company_Profile_Manager/delete/'.$p->id) ?>"
                               onclick="return confirm('この会社概要を削除しますか?')">
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

<?php
$this->load->view('dist/_partials/footer'); ?>

