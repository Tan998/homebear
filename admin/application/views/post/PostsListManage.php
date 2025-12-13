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
            
            <h2>記事一覧</h2>
            <a class="btn btn-primary" href="<?= site_url('post/create_posts') ?>">新しい記事を作成する</a>
            <table id="table-list-posts" class="table table-striped">
                <thead>
                    <tr class="text-center align-middle">
                        <th>ID</th>
                        <th>タイトル</th>
                        <th>投稿日</th>
                        <th>タイトル画像</th>
                        <th>削除</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($posts as $p): ?>
                    <tr class="text-center align-middle">
                        <td><a href="<?= site_url('post/edit/'.$p->id) ?>"><?= $p->id ?></a></td>
                        <td><?= htmlspecialchars($p->title) ?></td>
                        <td><?= $p->publish_date ?></td>
                        <td>
                            <?php if ($p->title_img): ?>
                                <img src="<?= base_url('uploads/posts/title_img/'.$p->id.'/'.$p->title_img) ?>" width="100">
                            <?php endif; ?>
                        </td>
                        <td>
                            <a class="btn btn-danger btn-sm" href="<?= site_url('post/delete/'.$p->id) ?>" onclick="return confirm('このポストを削除しますか?')">削除</a>
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
