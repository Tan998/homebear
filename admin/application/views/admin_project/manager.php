<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('dist/_partials/header'); ?>

<div class="main-content">
<section class="section">

<div class="section-header">
  <h1><?= $title ?></h1>
</div>

<div class="section-body">

  <!-- CATEGORY TABS -->
  <?php $this->load->view('admin_project/_partials/tabs'); ?>

  <!-- TOP BACKGROUND -->
  <div class="card mb-4">
    <div class="card-header"><h4>Top Background Image</h4></div>
    <div class="card-body">

      <?php if (!empty($settings) && !empty($settings->top_bg_image)): ?>
        <img src="<?= base_url('uploads/projects/top_bg/1/'.$settings->top_bg_image) ?>"
             class="img-fluid mb-3" style="max-width:300px">
      <?php endif; ?>

      <form method="post" enctype="multipart/form-data"
            action="<?= site_url('Project_Manager/upload_top_bg') ?>">
        <input type="file" name="top_bg" required>
        <button class="btn btn-primary btn-sm ml-2">更新</button>
      </form>
    </div>
  </div>

  <!-- CREATE BUTTON -->
  <a href="<?= site_url('Project_Manager/create/'.$category->category_key) ?>"
     class="btn btn-success mb-3">
     + 新規追加（<?= $category->category_name ?>）
  </a>

  <!-- PROJECT LIST -->
  <div class="card">
    <div class="card-header"><h4>プロジェクト一覧</h4></div>
    <div class="card-body">

      <ul id="project-sortable" class="list-group">
      <?php foreach ($projects as $p): ?>
        <li class="list-group-item d-flex justify-content-between align-items-center"
            data-id="<?= $p->id ?>">
        <span class="drag-handle mr-3" style="cursor:grab;">☰</span>
          <div class="d-flex align-items-center">

            <!-- IMAGE PREVIEW -->
            <?php if (!empty($p->image)): ?>
              <img
                src="<?= base_url('uploads/projects/items/'.$p->id.'/'.$p->image) ?>"
                class="mr-3 rounded"
                style="width:60px;height:60px;object-fit:cover;"
              >
            <?php else: ?>
              <div
                class="mr-3 bg-light d-flex align-items-center justify-content-center rounded"
                style="width:60px;height:60px;font-size:12px;color:#999;"
              >
                No Image
              </div>
            <?php endif; ?>

            <!-- TEXT -->
            <div>
              <strong><?= $p->construction_place ?></strong><br>
              <small class="text-muted"><?= $p->client_name ?></small>
            </div>
          </div>

          <!-- ACTION -->
          <div>
            <a href="<?= site_url('Project_Manager/edit/'.$p->id) ?>"
               class="btn btn-warning btn-sm">編集</a>

            <a href="<?= site_url('Project_Manager/delete/'.$p->id) ?>"
               class="btn btn-danger btn-sm"
               onclick="return confirm('削除しますか？')">削除</a>
          </div>

        </li>
      <?php endforeach; ?>
      </ul>


    </div>
  </div>

  <!-- FOOTER TEXT -->
  <div class="card mt-4">
    <div class="card-header"><h4>Projects Footer Text</h4></div>
    <div class="card-body">
      <form method="post" action="<?= site_url('Project_Manager/update_footer') ?>">
        <textarea name="footer_text" class="form-control" rows="4"><?= !empty($settings) ? $settings->footer_text : '' ?></textarea>
        <button class="btn btn-primary mt-2">保存</button>
      </form>
    </div>
  </div>

</div>
</section>
</div>
<!-- SORTABLE -->
<script>
document.addEventListener("DOMContentLoaded", function () {

    const list = document.getElementById("project-sortable");
    if (!list) return;

    new Sortable(list, {
        handle: ".drag-handle",   // kéo bằng icon
        animation: 150,

        onEnd: function () {
            const order = [];

            list.querySelectorAll("li").forEach(li => {
                order.push(li.dataset.id);
            });

            fetch("<?= site_url('Project_Manager/update_sort') ?>", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ order })
            });
        }
    });

});
</script>



<?php $this->load->view('dist/_partials/footer'); ?>

