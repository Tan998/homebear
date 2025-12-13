
<div id="loading-overlay" class="d-flex flex-column justify-content-center align-items-center w-100 h-100">
    <p class="presentation-title">HOMEBEAR</p>
    <div class="spinner-grow text-light" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>

<div class="page-header section-dark">
    <div id="video_background" class="video-background">
        <iframe id="bgVideo" 
            src=""
            frameborder="0"
            allow="autoplay"
            allowfullscreen>
        </iframe>
        <div id="video_overlay"></div>
    </div>
    <div class="filter"></div>

    <div class="content-center w-100 px-4 pb-5 wow fadeInLeftBig" data-wow-duration="2s" data-wow-delay="1.5s" style="visibility: visible; animation-duration: 2s; animation-delay: 1.5s; animation-name: fadeInLeftBig;">
      <div class="container-fruid">
        <!-- brand logo-->
        <!--<div class="title-brand-cus">
          <h3 class="presentation-title pl-3">HOMEBEAR</h3>
        </div>-->
        <!-- NEWS BLOCK -->
        <div class="container-fruid">
              <div class="row justify-content-start">
                <div class="col-12 col-sm-6 col-md-6 col-lg-4">

                  <div class="swiper newsSwiper">
                    <div class="swiper-wrapper" id="newsSliderWrapper"></div>

                    <!-- Navigation -->
                    <div class="news-nav text-center mt-3">
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-button-next"></div>
                    </div>
                  </div>

                </div>
              </div>
        </div>
        <!-- NEWS BLOCK -->
      </div>
    </div>
    <div class="scroll-bar-vertical">
        <div class="scroll-indicator-vertical"></div>
    </div>
</div>

<script>
// BackGround Video
document.addEventListener("visibilitychange", function () {
    if (!document.hidden) {
        const iframe = document.getElementById("bgVideo");
        // reload for play video
        iframe.src = "";
        iframe.src = bgVideoURL;

    }
});
function resizeYT() {
    const iframe = document.querySelector('#video_background iframe');
    const bg = document.querySelector('#video_background');

    const bw = bg.offsetWidth;
    const bh = bg.offsetHeight;

    const videoRatio = 16/9;
    const scaleFactor = 1.2; // tăng lên nữa → 1.3, 1.5, 2...

    let width, height;

    if (bw / bh > videoRatio) {
        width = bw * scaleFactor;
        height = (bw / videoRatio) * scaleFactor;
    } else {
        height = bh * scaleFactor;
        width = (bh * videoRatio) * scaleFactor;
    }

    iframe.style.width = width + 'px';
    iframe.style.height = height + 'px';

    // căn giữa
    iframe.style.top = (bh - height) / 2 + 'px';
    iframe.style.left = (bw - width) / 2 + 'px';
}
window.addEventListener('load', resizeYT);
window.addEventListener('resize', resizeYT);
</script>


<script>
// =========================
document.addEventListener("DOMContentLoaded", function () {
    loadBackgroundImage();
    loadBackgroundVideo();
    loadNewsSlider();
    fadeOutOverlay("loading-overlay"); //visibleTime = 1000, fadeTime = 800
});

</script>
