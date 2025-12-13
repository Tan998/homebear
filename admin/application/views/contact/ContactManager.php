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
                    <table id="contact-table" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>問い合せ日付</th>
                                <th>顧客名</th>
                                <th>会社名</th>
                                <th>住所</th>
                                <th>電話番号</th>
                                <th>メールアドレス</th>
                                <th>お問い合わせ内容</th>
                                <th>IP</th>
                                <th>last submit</th>
                                <th>削除</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($contacts as $c): ?>
                            <tr>
                                <td><?= $c->id ?></td>
                                <td><?= date('d/m/Y H:i', strtotime($c->created_at)) ?></td>
                                <td><?= $c->customer_name ?></td>
                                <td><?= $c->customer_type ?></td>
                                <td><?= $c->customer_address ?></td>
                                <td><?= $c->customer_phone ?></td>
                                <td><?= $c->customer_email ?></td>
                                <td><?= $c->contact_text ?></td>
                                <td><?= $c->ip ?></td>
                                <td><?= $c->last_submit ?></td>
                                <td>
                                    <a href="<?= site_url('contact/delete_contact/'.$c->id) ?>" 
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
