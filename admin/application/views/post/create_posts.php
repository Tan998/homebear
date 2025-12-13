<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>


<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('dist/_partials/header'); ?>

<style>
  textarea.form-control {
    min-height: 64px !important; /* chiều cao tối thiểu */
    height: auto !important;     /* cho phép kéo cao thêm */
    resize: vertical;            /* hoặc resize: both; */
}
</style>
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1><?php echo $title; ?></h1>
          </div>

          <div class="section-body">

            <h2><?= isset($post) ? '投稿を編集' : '新しい記事を作成する'; ?></h2>

            <?php if (isset($success)): ?>
                <div class="alert alert-success"><?= $success ?></div>
            <?php endif; ?>

            <form method="post" class="bordered shadow-sm rounded-lg p-md-5 p-2" enctype="multipart/form-data">
              <h6>ポストカード</h6>
              <div class="row">
                  <div class="form-group col-sm-6">
                    <label>タイトル</label>
                    <input type="text" name="title" class="form-control"
                           value="<?= isset($post) ? htmlspecialchars($post->title ?? '') : '' ?>" required>
                  </div>

                  <div class="form-group col-sm-6">
                    <label>投稿日時（空白のままでも可）</label>
                    <input type="date" name="publish_date" class="form-control"
                           value="<?= isset($post) ? $post->publish_date : '' ?>">
                  </div>
              </div>
              <div class="row flex-column">
                <div class="form-group col-sm-6">
                  <label>導入前課題</label>
                  <input type="text" name="before_issue" class="form-control" rows="5" required value="<?= isset($post) ? htmlspecialchars($post->before_issue ?? '') : '' ?>">
                </div>
                <div class="form-group col-sm-6">
                <label>導入後の効果</label>
                  <input type="text" name="after_effect" class="form-control" rows="5" required value="<?= isset($post) ? htmlspecialchars($post->after_effect ?? '') : '' ?>">
                </div>
                <div class="form-group col-sm-6">
                  <label>活用機能</label>
                  <input type="text" name="used_features" class="form-control" rows="5" required value="<?= isset($post) ? htmlspecialchars($post->used_features ?? '') : '' ?>">
                </div>
              </div>

              <h6>ポスト詳細</h6>
              <div class="form-group col-sm-6">
                <label>タイトル：上と同様</label>
              </div>
              <div class="form-group">
                <label>内容（空白のままでも可）</label>
                <textarea name="text_content" class="w-100" style="max-height: none;" rows="5" placeholder="<h4>Title</h4>
<br>
<p>Text Content</p>" required><?= isset($post) ? htmlspecialchars($post->text_content ?? '') : '' ?></textarea>
              </div>
              <h6>footer</h6>
              <div class="row">
                <div class="form-group col-sm-4">
                  <label>店舗名:</label>
                  <input type="text" name="ShopName" class="form-control" rows="5" required value="<?= isset($post) ? htmlspecialchars($post->ShopName ?? '') : '' ?>">
                </div>
                <div class="form-group col-sm-4">
                <label>住所:</label>
                  <input type="text" name="Address" class="form-control" rows="5" required value="<?= isset($post) ? htmlspecialchars($post->Address ?? '') : '' ?>">
                </div>
                <div class="form-group col-sm-4">
                  <label>リンク: </label>
                  <input type="text" name="Link" class="form-control" required
                  pattern="https?://.+"
                  title="リンクは http:// または https:// で始めてください"
                  value="<?= isset($post) ? htmlspecialchars($post->Link ?? '') : '' ?>">
                </div>
              </div>

              <!-- Title image -->
              <div class="form-group">
                <label>タイトル画像　(１枚 - jpg|png|jpeg|gif)</label><br>
                <?php if (isset($post) && $post->title_img): ?>
                  <img src="<?= base_url('uploads/posts/title_img/'.$post->id.'/'.$post->title_img) ?>" width="120" class="mb-2">
                <?php endif; ?>

                <div class="custom-file">
                    <input type="file" name="title_img" class="custom-file-input" id="titleImgInput" aria-describedby="titleImgInput">
                    <label class="custom-file-label" for="titleImgInput">タイトル画像を選択してください</label>
                </div>

              </div>
              <!-- Sub images -->
              <div class="form-group">
                <label>サブ画像（jpg|png|jpeg|gif）</label><br>
                <?php if (!empty($sub_images)): ?>
                  <div class="d-flex flex-wrap">
                    <?php foreach ($sub_images as $img): ?>
                      <div class="mr-2 mb-2 text-center">
                        <img src="<?= base_url('uploads/posts/sub_img/'.$post->id.'/'.$img->file_name) ?>" width="100" class="mb-1"><br>
                        <a href="<?= site_url('post/delete_sub_image/'.$img->id) ?>" 
                           onclick="return confirm('この画像を削除しますか?')" class="btn btn-sm btn-danger">削除</a>
                      </div>
                    <?php endforeach; ?>
                  </div>
                <?php endif; ?>

                <div class="custom-file">
                    <input type="file" name="sub_img[]" class="custom-file-input" multiple id="subImgInput" aria-describedby="subImgInput">
                    <label class="custom-file-label" for="subImgInput">画像を選択してください</label>
                </div>

              </div>

              

              <button type="submit" class="btn btn-primary"><?= isset($post) ? '更新' : 'Submit' ?></button>
            </form>


            <a class="btn btn-warning mt-3" href="<?= site_url('post/PostsListManage') ?>">記事リストに戻る</a>

          </div>
        </section>
      </div>




<?php
$this->load->view('dist/_partials/footer'); ?>

<script>
$(document).ready(function(){
  $('.custom-file-input').on('change', function(){
    var fileNames = Array.from(this.files).map(f => f.name).join(', ');
    $(this).next('.custom-file-label').html(fileNames);
  });
});
</script>

<?php if (!empty($success)): ?>
  <div class="alert alert-success"><?= $success ?></div>
  <script>
    setTimeout(function(){
      window.location.href = "<?= site_url('post/PostsListManage') ?>";
    }, 2000); // 2000 ms = 2s
  </script>
<?php endif; ?>