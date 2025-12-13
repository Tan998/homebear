//=====  WOW active
new WOW().init();

function fadeOutOverlay(overlayId, visibleTime = 1800, fadeTime = 800) {
    const overlay = document.getElementById(overlayId);
    if (!overlay) return;

    // Hiện overlay
    overlay.style.display = "flex";

    // Chờ visibleTime ms rồi bắt đầu mờ dần
    setTimeout(() => {
        overlay.classList.add("fade-out");

        // Sau fadeTime ms, ẩn hẳn overlay
        setTimeout(() => {
            overlay.style.display = "none";
        }, fadeTime);
    }, visibleTime);
}

// =========================
// 1) BACKGROUND IMAGE
// =========================
function loadBackgroundImage() {
    fetch(base_url + "/classes/Master.php?f=fetch_hp_bg_img")
        .then(response => response.json())
        .then(res => {
            if (res.status !== 'success') {
                console.error("API error:", res.error);
                return;
            }

            const bgData = res.data;

            // Sử dụng biến JS đã được PHP gán trước đó
            const lgImg = hp_bg_img_lg + bgData.bg_lg_filename;
            const smImg = bgData.bg_sm_filename
                ? hp_bg_img_sm + bgData.bg_sm_filename
                : lgImg;

            const style = document.createElement("style");
            style.textContent = `
                .page-header {
                    background-image: url('${lgImg}') !important;
                }
                @media (max-width: 767.98px) {
                    .page-header {
                        background-image: url('${smImg}') !important;
                    }
                }
            `;
            document.head.appendChild(style);
        })
        .catch(err => console.error("Error fetch background:", err));
}



// =========================
// 2) BACKGROUND VIDEO
// =========================
/*function loadBackgroundVideo() {
    fetch(base_url + "/classes/Master.php?f=fetch_bg_video")
        .then(response => response.json())
        .then(res => {
            const iframe = document.getElementById("bgVideo");

            if (res.status !== 'success') {
                iframe.style.display = "none";
                return;
            }

            if (!Array.isArray(res.data) || res.data.length === 0) {
                iframe.style.display = "none";
                return;
            }

            const bg = res.data[0];

            if (bg.status !== "1") {
                iframe.style.display = "none";
                return;
            }

            const id = bg.youtube_id;
            const videoURL =
                `https://www.youtube.com/embed/${id}?autoplay=1&mute=1&controls=0&modestbranding=1` +
                `&rel=0&playsinline=1&loop=1&playlist=${id}&wmode=transparent&enablejsapi=1`;

            iframe.src = videoURL;
            iframe.style.display = "block";

            const style = document.createElement("style");
            style.textContent = `
                .page-header {
                    background-image: none !important;
                }
            `;
            document.head.appendChild(style);
        })
        .catch(err => {
            console.error("Error fetch background:", err);
            document.getElementById("bgVideo").style.display = "none";
        });
}*/
// Lưu URL video đã set
let bgVideoURL = "";

function loadBackgroundVideo() {
    const iframe = document.getElementById("bgVideo");

    fetch(base_url + "/classes/Master.php?f=fetch_bg_video")
        .then(response => response.json())
        .then(res => {

            if (res.status !== "success") {
                iframe.style.display = "none";
                return;
            }

            if (!Array.isArray(res.data) || res.data.length === 0) {
                iframe.style.display = "none";
                return;
            }

            const bg = res.data[0];

            if (bg.status !== "1") {
                iframe.style.display = "none";
                return;
            }

            const id = bg.youtube_id;

            bgVideoURL =
                `https://www.youtube.com/embed/${id}?autoplay=1&mute=1&controls=0` +
                `&modestbranding=1&rel=0&playsinline=1&loop=1&playlist=${id}`;

            iframe.src = bgVideoURL;
            iframe.style.display = "block";

            // loại bỏ background nếu muốn
            const style = document.createElement("style");
            style.textContent = `.page-header { background-image: none !important; }`;
            document.head.appendChild(style);
        })
        .catch(err => {
            console.error("Error fetch background:", err);
            iframe.style.display = "none";
        });
}





// =========================
// 3) NEWS SLIDER
// =========================
function loadNewsSlider() {
    let swiperInstance = null;
    let newsData = null;

    fetch(base_url + "/classes/Master.php?f=fetch_list_news")
        .then(response => response.json())
        .then(res => {
            if (res.status !== 'success') return;
            newsData = res.data;
            initNewsSlider();
        });

    function initNewsSlider() {
        const wrapper = document.getElementById("newsSliderWrapper");
        wrapper.innerHTML = "";

        const isMobile = window.innerWidth < 768;

        if (isMobile) {
            newsData.forEach(item => {
                wrapper.insertAdjacentHTML("beforeend", `
                    <div class="swiper-slide">
                        <div class="news-item d-flex">
                            <div class="news-badge"><img width="20px" src="./assets/img/homebear/new-button.svg" alt=""></div>
                            <div class="news-box w-100">
                                <div class="news-date">${item.publish_date}</div>
                                <div class="news-content">${item.news_content}</div>
                            </div>
                        </div>
                    </div>
                `);
            });
        } else {
            for (let i = 0; i < newsData.length; i += 3) {
                const group = newsData.slice(i, i + 3);
                let html = `<div class="swiper-slide">`;
                group.forEach(item => {
                    html += `
                        <div class="swiper-slide">
                            <div class="news-item d-flex">
                                <div class="news-badge"><img src="./assets/img/homebear/new-button.svg" alt=""></div>
                                <div class="news-box w-100">
                                    <div class="news-date">${item.publish_date}</div>
                                    <div class="news-content">${item.news_content}</div>
                                </div>
                            </div>
                        </div>
                    `;
                });
                html += `</div>`;
                wrapper.insertAdjacentHTML("beforeend", html);
            }
        }

        if (swiperInstance) swiperInstance.destroy(true, true);

        swiperInstance = new Swiper(".newsSwiper", {
            slidesPerView: 1,
            loop: true,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            }
        });
    }

    let resizeTimer;
    window.addEventListener("resize", function () {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => initNewsSlider(), 200);
    });
}