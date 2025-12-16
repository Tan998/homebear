<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

<?php $this->load->view('dist/_partials/header'); ?>

<div class="main-content">
    <section class="section">

        <div class="section-header">
            <h1><?= $title ?></h1>
        </div>

        <div class="section-body">

            <?php if (!empty($success)): ?>
                <div class="alert alert-success"><?= $success ?></div>
            <?php endif; ?>

            <form method="post" enctype="multipart/form-data" class="p-3 border rounded shadow-sm">

                <!-- TEXT FIELDS -->
                <div class="form-group">
                    <label>会社紹介文</label>
                    <textarea name="text_company_profile" class="form-control" rows="3"><?= isset($profile)? htmlspecialchars($profile->text_company_profile):'' ?></textarea>
                </div>

                <div class="form-group">
                    <label>詳細説明</label>
                    <textarea name="text_content" class="form-control" rows="6"><?= isset($profile)? htmlspecialchars($profile->text_content):'' ?></textarea>
                </div>

                <hr>

                <!-- TITLE IMAGE -->
                <h5 class="mb-2">タイトル画像</h5>

                <?php if (isset($profile) && !empty($profile->title_img)): ?>
                    <img src="<?= base_url('uploads/company_profile_ver2/title_img/'.$profile->id.'/'.$profile->title_img) ?>"
                         width="160" class="mb-2 d-block">
                <?php endif; ?>

                <input type="file" name="title_img" class="form-control mb-4">

                <hr>

                <!-- DYNAMIC FIELDS -->
                <h5 class="mb-3">会社情報（自由追加項目）</h5>

                <button type="button" id="btn-add-field" class="btn btn-success btn-sm mb-3">
                    + 項目を追加する
                </button>

                <ul id="field-list" class="list-group">

                    <?php if (!empty($fields)): ?>
                        <?php foreach ($fields as $f): ?>
                            <li class="list-group-item d-flex align-items-center">

                                <span class="drag-handle mr-2" style="cursor:move;">☰</span>

                                <input type="hidden" name="field_order[]" value="<?= $f->sort_order ?>" class="order-input">

                                <input type="text" name="field_key[]" class="form-control mr-2"
                                       placeholder="項目名"
                                       value="<?= htmlspecialchars($f->field_key) ?>">

                                <input type="text" name="field_value[]" class="form-control mr-2"
                                       placeholder="内容"
                                       value="<?= htmlspecialchars($f->field_value) ?>">

                                <button type="button" class="btn btn-danger btn-sm btn-remove-field">X</button>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>

                </ul>

                <hr>

                <!-- SUB IMAGES -->
                <h5>追加画像</h5>

                <input type="file" name="sub_img" class="form-control mb-3">

                <?php if (!empty($images)): ?>
                    <div class="row">
                        <?php foreach ($images as $img): ?>
                            <div class="col-md-3 text-center mb-3">
                                <img src="<?= base_url('uploads/company_profile_ver2/sub_img/'.$profile->id.'/'.$img->file_name) ?>"
                                     width="120" class="d-block mb-1">
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <button type="submit" class="btn btn-primary mt-3">
                    <?= isset($profile) ? '更新する' : '登録する' ?>
                </button>

            </form>

            <a href="<?= site_url('Company_Profile_Manager_Ver2/index') ?>" class="btn btn-warning mt-3">戻る</a>

        </div>
    </section>
</div>

<script>
let list = document.getElementById("field-list");

new Sortable(list, {
    handle: ".drag-handle",
    animation: 150,
    onSort: function () {
        // cập nhật order sau khi kéo thả
        document.querySelectorAll("#field-list .order-input").forEach((el, index) => {
            el.value = index + 1;
        });
    }
});

// ADD NEW FIELD
document.getElementById("btn-add-field").addEventListener("click", function() {
    let li = document.createElement("li");
    li.className = "list-group-item d-flex align-items-center";

    li.innerHTML = `
        <span class="drag-handle mr-2" style="cursor:move;">☰</span>
        <input type="hidden" name="field_order[]" value="0" class="order-input">
        <input type="text" name="field_key[]" class="form-control mr-2" placeholder="項目名">
        <input type="text" name="field_value[]" class="form-control mr-2" placeholder="内容">
        <button type="button" class="btn btn-danger btn-sm btn-remove-field">X</button>
    `;

    document.getElementById("field-list").appendChild(li);
});

// REMOVE FIELD
document.addEventListener("click", function(e){
    if (e.target.classList.contains("btn-remove-field")) {
        e.target.closest("li").remove();
    }
});
</script>

<?php $this->load->view('dist/_partials/footer'); ?>
