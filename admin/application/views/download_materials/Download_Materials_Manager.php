<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('dist/_partials/header'); ?>

<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><?= $title ?></h1>
        </div>
        <div class="section-body">
            <?php /*if($this->session->flashdata('success')): ?>
                <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
            <?php elseif($this->session->flashdata('error')): ?>
                <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
            <?php endif; */?>
                    <table id="download-materials-table" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>リクエスト日付</th>
                                <th>顧客名</th>
                                <th>会社名</th>
                                <th>電話番号</th>
                                <th>メールアドレス</th>
                                <th>会員規模</th>
                                <th>現在運営状況</th>
                                <th>弊社からの説明連絡を希望</th>
                                <th>IP</th>
                                <th>削除</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($download_materials as $c): ?>
                            <tr>
                                <td><?= $c->id ?></td>
                                <td><?= date('d/m/Y H:i', strtotime($c->submitted_at)) ?></td>
                                <td><?= $c->customer_fname ?><?= $c->customer_name ?></td>
                                <td><?= $c->company_name ?></td>
                                <td><?= $c->customer_phone ?></td>
                                <td><?= $c->customer_email ?></td>
                                <td><?= $c->membership_size ?></td>
                                <td><?= $c->current_operation_status ?></td>
                                <td class="<?= $c->explanation_status == 0 ? 'text-danger' : 'text-success' ?>"><?= $c->explanation_status == 0 ? 'いいえ' : 'はい' ?></td>
                                <td><?= $c->ip ?></td>
                                <td>
                                    <a href="<?= site_url('download_materials/delete_download_materials/'.$c->id) ?>" 
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('削除しますか？')">
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
