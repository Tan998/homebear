<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('dist/_partials/header'); ?>

<style>
textarea.form-control {
    min-height: 64px !important;
    height: auto !important;
    resize: vertical;
}
</style>

<div class="main-content">
    <section class="section">

        <div class="section-header">
            <h1><?= $title ?></h1>
        </div>

        <div class="section-body">

            <h2><?= isset($company_profile) ? '会社概要を編集' : '会社概要を新規作成' ?></h2>

            <?php if (isset($success)): ?>
                <div class="alert alert-success"><?= $success ?></div>
            <?php endif; ?>

            <form method="post" enctype="multipart/form-data" class="bordered shadow-sm rounded-lg p-md-5 p-2">
                <!-- ★ Sub Image -->
                <h5 class="mt-4">Top BackGround Image</h5>

                <?php
                $sub_img_folder = FCPATH . 'uploads/company_profile/sub_img/1/';
                $sub_img_files = @glob($sub_img_folder . '*'); // @ để tránh warning nếu folder ko tồn tại
                $sub_img_url = '';

                if (!empty($sub_img_files)) {
                    $filename = basename($sub_img_files[0]);
                    $sub_img_url = base_url('uploads/company_profile/sub_img/1/' . $filename);
                }
                ?>

                <?php if (!empty($sub_img_url)): ?>
                    <div class="mb-3 text-center">
                        <img src="<?= $sub_img_url ?>" width="120" class="mb-2"><br>

                        <?php if (!empty($company_profile) && !empty($company_profile->id)): ?>
                            <a href="<?= site_url('Company_Profile_Manager/delete_sub_image/'.$company_profile->id) ?>"
                               onclick="return confirm('この画像を削除しますか?')"
                               class="btn btn-sm btn-danger">削除</a>
                        <?php else: ?>
                            <!-- khi đang tạo mới (chưa có id) không show link delete -->
                            <span class="text-muted small">(保存後に削除可能)</span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <div class="custom-file mb-4">
                    <input type="file" name="sub_img" class="custom-file-input" id="subImgInput">
                    <label class="custom-file-label" for="subImgInput">画像を選択してください</label>
                </div>

                <!-- ★ Title Image -->
                <h5 class="mt-4">タイトル画像</h5>

                <?php if (isset($company_profile) && $company_profile->title_img): ?>
                    <img src="<?= base_url('uploads/company_profile/title_img/1/'.$company_profile->title_img) ?>"
                         width="140" class="mb-2 d-block">
                <?php endif; ?>

                <div class="custom-file mb-4">
                    <input type="file" name="title_img" class="custom-file-input" id="titleImgInput">
                    <label class="custom-file-label" for="titleImgInput">画像を選択してください</label>
                </div>

                <!-- ★ Company Profile Basic Info -->
                <h5 class="mt-4 mb-3">基本情報</h5>

                <div class="form-group">
                    <label>会社紹介文（text_company_profile）</label>
                    <textarea name="text_company_profile" class="form-control" rows="4"><?= isset($company_profile) ? htmlspecialchars($company_profile->text_company_profile) : '' ?></textarea>
                </div>

                <div class="form-group">
                    <label>詳細説明（text_content）</label>
                    <textarea name="text_content" class="form-control" rows="6"><?= isset($company_profile) ? htmlspecialchars($company_profile->text_content) : '' ?></textarea>
                </div>

                <!-- ★ Company Table Data -->
                <h5 class="mt-4 mb-3">会社情報テーブル</h5>

                <div class="row">
                    <div class="form-group col-md-6">
                        <label>会社名</label>
                        <input type="text" name="company_name" class="form-control" value="<?= isset($company_profile) ? htmlspecialchars($company_profile->company_name) : '' ?>">
                    </div>

                    <div class="form-group col-md-6">
                        <label>電話番号</label>
                        <input type="text" name="company_phone" class="form-control" value="<?= isset($company_profile) ? htmlspecialchars($company_profile->company_phone) : '' ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label>本社所在地</label>
                    <textarea name="company_address" class="form-control" rows="3"><?= isset($company_profile) ? htmlspecialchars($company_profile->company_address) : '' ?></textarea>
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                        <label>設立日</label>
                        <input type="text" name="establishment_date" class="form-control" value="<?= isset($company_profile) ? htmlspecialchars($company_profile->establishment_date) : '' ?>">
                    </div>

                    <div class="form-group col-md-6">
                        <label>資本金</label>
                        <input type="text" name="capital_stock" class="form-control" value="<?= isset($company_profile) ? htmlspecialchars($company_profile->capital_stock) : '' ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label>役員一覧（list_staff）</label>
                    <textarea name="list_staff" class="form-control" rows="4"><?= isset($company_profile) ? htmlspecialchars($company_profile->list_staff) : '' ?></textarea>
                </div>

                <div class="form-group">
                    <label>社員数</label>
                    <input type="text" name="number_of_employees" class="form-control" value="<?= isset($company_profile) ? htmlspecialchars($company_profile->number_of_employees) : '' ?>">
                </div>

                <div class="form-group">
                    <label>許認可等（permits_and_licenses）</label>
                    <textarea name="permits_and_licenses" class="form-control" rows="5"><?= isset($company_profile) ? htmlspecialchars($company_profile->permits_and_licenses) : '' ?></textarea>
                </div>

                <div class="form-group">
                    <label>知的財産（intellectual_property）</label>
                    <textarea name="intellectual_property" class="form-control" rows="4"><?= isset($company_profile) ? htmlspecialchars($company_profile->intellectual_property) : '' ?></textarea>
                </div>

                <div class="form-group">
                    <label>事業内容（business_content）</label>
                    <textarea name="business_content" class="form-control" rows="6"><?= isset($company_profile) ? htmlspecialchars($company_profile->business_content) : '' ?></textarea>
                </div>

                <div class="form-group">
                    <label>取引銀行（bank_info）</label>
                    <textarea name="bank_info" class="form-control" rows="4"><?= isset($company_profile) ? htmlspecialchars($company_profile->bank_info) : '' ?></textarea>
                </div>

                <button type="submit" class="btn btn-primary">
                    <?= isset($company_profile) ? '更新する' : '登録する' ?>
                </button>

            </form>

            <a class="btn btn-warning mt-3" href="<?= site_url('Company_Profile_Manager/CompanyProfileManager') ?>">
                戻る
            </a>

        </div>
    </section>
</div>

<?php $this->load->view('dist/_partials/footer'); ?>

<script>
$(function(){
    $('.custom-file-input').on('change', function(){
        let fileNames = [...this.files].map(f => f.name).join(', ');
        $(this).next('.custom-file-label').text(fileNames);
    });
});
</script>
<?php if (!empty($success)): ?>
  <div class="alert alert-success"><?= $success ?></div>
  <script>
    setTimeout(function(){
      window.location.href = "<?= site_url('company_profile/CompanyProfileManager') ?>";
    }, 2000); // 2000 ms = 2s
  </script>
<?php endif; ?>
