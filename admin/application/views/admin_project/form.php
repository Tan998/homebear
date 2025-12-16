<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('dist/_partials/header'); ?>

<div class="main-content">
<section class="section">

<div class="section-header">
  <h1><?= $title ?></h1>
</div>

<div class="section-body">

  <div class="card">
    <div class="card-body">

      <form method="post" enctype="multipart/form-data">

        <!-- 施工場所 -->
        <div class="form-group">
          <label>施工場所</label>
          <input type="text" name="construction_place"
                 class="form-control"
                 value="<?= $project->construction_place ?? '' ?>"
                 required>
        </div>

        <!-- 発注者 -->
        <div class="form-group">
          <label>発注者</label>
          <input type="text" name="client_name"
                 class="form-control"
                 value="<?= $project->client_name ?? '' ?>">
        </div>

        <!-- IMAGE -->
        <div class="form-group">
          <label>画像</label><br>

          <?php if (!empty($project->image)): ?>
            <img src="<?= base_url('uploads/projects/items/'.$project->id.'/'.$project->image) ?>"
                 style="max-width:200px" class="mb-2"><br>
          <?php endif; ?>

          <input type="file" name="image">
        </div>

        <button class="btn btn-primary">
          <?= isset($project) ? '更新する' : '登録する' ?>
        </button>

        <?php if (!empty($category)): ?>
        <a href="<?= site_url('Project_Manager/index/'.$category->category_key) ?>"
           class="btn btn-secondary ml-2">戻る</a>
        <?php endif; ?>

      </form>

    </div>
  </div>

</div>
</section>
</div>

<?php $this->load->view('dist/_partials/footer'); ?>
