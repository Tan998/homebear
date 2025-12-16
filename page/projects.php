<div id="loading-overlay" class="d-flex flex-column justify-content-center align-items-center w-100 h-100">
  <p class="presentation-title">HOMEBEAR</p>
  <div class="spinner-grow text-light" role="status">
    <span class="sr-only">Loading...</span>
  </div>
</div>

<div id="company-top-bg" class="page-header page-header-xs" data-parallax="true" style="background-size: cover;">
  <div class="filter"></div>
</div>


<div class="container" id="projects_content">

    <!-- TITLE -->
    <div class="page-title">
        <h1>実績</h1>
        <small>Projects</small>
    </div>

    <!-- 個人宅 -->
    <section class="section section-1 pb-0" data-category="private">
    </section>

    <!-- 商業施設 -->
    <section class="section section-2 pb-0" data-category="commercial">
    </section>

    <!-- 福利厚生 -->
    <section class="section section-3 pb-0" data-category="welfare">
    </section>
    <div class="note">※ 順不同</div>

    <div class="bottom-text" id="projects-footer" style="white-space: break-spaces;">
    </div>

</div>

<!-- MODAL -->
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body p-0">
                <img id="modalImage" src="" class="img-fluid w-100 rounded-lg">
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {

    document.querySelectorAll('.image-wrap img').forEach(img => {
        const wrap = img.closest('.image-wrap');
        const hasLargeImg = wrap?.dataset.img?.trim();

        // chỉ remove khi BOTH đều rỗng
        if (
            (!img.getAttribute('src') || img.getAttribute('src').trim() === "") &&
            !hasLargeImg
        ) {
            wrap.remove();
        }
    });

});

// =========================
document.addEventListener("DOMContentLoaded", function () {
    load_projects_page_data();
    initImageModal();
    fadeOutOverlay("loading-overlay");
});

window.addEventListener('resize', function () {
    clearTimeout(window.__swiperResizeTimer);
    window.__swiperResizeTimer = setTimeout(initProjectSwiper, 200);
});

</script>
