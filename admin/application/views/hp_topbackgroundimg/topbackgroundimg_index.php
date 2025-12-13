<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('dist/_partials/header'); ?>

<div class="main-content">
	<section class="section">
	  <div class="section-header">
	    <h1><?= $title ?></h1>
	  </div>

	  <div class="section-body">

	    <!-- Upload form -->
	    <form action="<?= site_url('HP_TopBackgroundIMG/upload') ?>" method="post" enctype="multipart/form-data" class="mb-4">
	      <div class="card">
	        <div class="card-header"><h4>画像をアップロード</h4></div>
	        <div class="card-body">
	          <div class="form-group">
	            <label>大サイズ（パソコン・PC・タブレットのスクリーン）</label>
	            <input type="file" name="bg_lg" class="form-control">
	          </div>
	          <div class="form-group">
	            <label>小サイズ（モデルスクリーン）</label>
	            <input type="file" name="bg_sm" class="form-control">
	          </div>
	          <button class="btn btn-success">アップロード</button>
	        </div>
	      </div>
	    </form>

	    <!-- Form chọn ảnh -->
	    <form action="<?= site_url('HP_TopBackgroundIMG/update') ?>" method="post">
	      <div class="card">
	        <div class="card-header"><h4>大画像を選択</h4></div>
	        <div class="card-body row">
	          <?php foreach ($lg_images as $img): ?>
	            <div class="col-md-3 text-center mb-3">
	              <img src="<?= base_url($img) ?>" class="img-fluid rounded shadow mb-2">
	              <div>
	                <input type="radio" name="bg_lg" value="<?= basename($img) ?>" <?= basename($img) == $setting['bg_lg_filename'] ? 'checked' : '' ?>>
	              </div>
	              <a href="<?= site_url('HP_TopBackgroundIMG/delete/lg/' . urlencode(basename($img))) ?>" class="btn btn-sm btn-danger mt-2" onclick="return confirm('この画像を削除しますか?')">削除</a>
	            </div>
	          <?php endforeach; ?>
	        </div>
	      </div>

	      <div class="card mt-3">
	        <div class="card-header"><h4>小画像を選択</h4></div>
	        <div class="card-body row">
	          <?php foreach ($sm_images as $img): ?>
	            <div class="col-md-3 text-center mb-3">
	              <img src="<?= base_url($img) ?>" class="img-fluid rounded shadow mb-2">
	              <div>
	                <input type="radio" name="bg_sm" value="<?= basename($img) ?>" <?= basename($img) == $setting['bg_sm_filename'] ? 'checked' : '' ?>>
	              </div>
	              <a href="<?= site_url('HP_TopBackgroundIMG/delete/sm/' . urlencode(basename($img))) ?>" class="btn btn-sm btn-danger mt-2" onclick="return confirm('この画像を削除しますか?')">削除</a>
	            </div>
	          <?php endforeach; ?>
	        </div>
	      </div>

	      <div class="card-footer text-right">
	        <button class="btn btn-primary w-100">保存</button>
	      </div>
	    </form>
	  </div>
	</section>
</div>

<?php
$this->load->view('dist/_partials/footer'); ?>