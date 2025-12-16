<?php $this->load->view('dist/_partials/header'); ?>

<div class="main-content">
    <section class="section">

        <div class="section-header">
            <h1>新規フォント設定</h1>
        </div>
        <div class="section-header flex-column">
            <h5>Google Fonts を参考にしてください</h5>
            <a class="" rel="tooltip" title="Google Fonts" href="https://fonts.google.com/?lang=ja_Jpan" target="_blank">
                <i class="bi bi-file-font"></i>
                <p class="">https://fonts.google.com/?lang=ja_Jpan</p>
            </a>
        </div>
        <form method="post" action="<?= site_url('FontTextManager/store') ?>">

            <div class="form-group">
                <label>ページキー (page_key)</label>
                <input type="text" name="page_key" class="form-control" placeholder="home / company / contact ..." required>
                <small id="page_key_help" class="form-text text-muted">
                    例： https://dev1.homebear.jp/<mark>home</mark>/
                </small>

            </div>

            <div class="form-group">
                <label>Google Font Family</label>
                <input type="text" name="font_family" class="form-control"
                       placeholder="Noto Sans JP" required>
                <small id="page_key_help" class="form-text text-muted">
                    例： <br>
                        .hachi-maru-pop-regular {<br>
                        　font-family: "<mark>Hachi Maru Pop</mark>", cursive;<br>
                        　font-weight: 400;<br>
                        　font-style: normal;<br>
                        }
                </small>
            </div>

            <div class="form-group">
                <label>Google Font URL</label>
                <input type="text" name="font_url" class="form-control"
                       placeholder="https://fonts.googleapis.com/css2?family=..." required>
                <?php
                $example_lines = [
                    '<link rel="preconnect" href="https://fonts.googleapis.com">',
                    '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>',
                    '<link href="https://fonts.googleapis.com/css2?family=Hachi+Maru+Pop&family=Kaisei+Decol&display=swap" rel="stylesheet">'
                ];
                ?>


                                <small class="form-text text-muted">
                    例：<br>
                    <pre><?php
                    foreach ($example_lines as $index => $line) {
                        if ($index === count($example_lines) - 1) {
                            echo '<mark>' . htmlspecialchars($line) . '</mark>';
                        } else {
                            echo htmlspecialchars($line);
                        }
                        echo "\n";
                    }
                    ?></pre>
                </small>


            </div>

            <div class="form-group">
                <label>CSS Selector</label>
                <input type="text" name="css_selector" class="form-control"
                       placeholder="body" required>
                <small id="page_key_help" class="form-text text-muted">
                    <strong class="text-danger">body</strong>を使用してページ全体にフォントを適用します。
                </small>
            </div>

            <button class="btn btn-primary">保存</button>
            <a href="<?= site_url('FontTextManager') ?>" class="btn btn-secondary">戻る</a>

        </form>

    </section>
</div>

<?php $this->load->view('dist/_partials/footer'); ?>
