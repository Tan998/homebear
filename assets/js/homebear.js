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

//=====  navbar toggle
function initSmoothNavbar(btnSelector, collapseSelector) {
    const toggleBtn = document.querySelector(btnSelector);
    const collapse = document.querySelector(collapseSelector);

    if (!toggleBtn || !collapse) return;

    const openSmooth = () => {
        collapse.style.maxHeight = "0";
        collapse.style.opacity = "0";
        collapse.style.transform = "translateY(-20px) scale(0.98)";

        collapse.classList.add("show");

        requestAnimationFrame(() => {
            collapse.style.maxHeight = collapse.scrollHeight + "px";
            collapse.style.opacity = "1";
            collapse.style.transform = "translateY(0) scale(1)";
        });
    };

    const closeSmooth = () => {
        collapse.style.maxHeight = collapse.scrollHeight + "px";
        collapse.style.opacity = "1";
        collapse.style.transform = "translateY(0) scale(1)";
        collapse.offsetHeight;

        collapse.style.maxHeight = "0";
        collapse.style.opacity = "0";
        collapse.style.transform = "translateY(-20px) scale(0.98)";

        setTimeout(() => {
            collapse.classList.remove("show");
            collapse.removeAttribute("style");
        }, 150);
    };

    toggleBtn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();

        if (collapse.classList.contains('show')) {
            toggleBtn.classList.remove('open');
            closeSmooth();
        } else {
            toggleBtn.classList.add('open');
            openSmooth();
        }
    });

    // CLICK OUTSIDE CLOSE
    document.addEventListener('click', function(e) {
        if (
            !toggleBtn.contains(e.target) &&
            collapse.classList.contains("show") &&
            !collapse.contains(e.target)
        ) {
            toggleBtn.classList.remove('open');
            closeSmooth();
        }
    });
}
//=====  get Current Page Key
function getCurrentPageKey() {
    const path = window.location.pathname; 

    const parts = path.split("/").filter(Boolean);
    // ["homebear", "company_ver2"]

    return parts.length >= 2 ? parts[1] : "";  
}

const current_page_key = getCurrentPageKey();

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

// =========================
// 4) BRAND LOGO
// =========================
function loadLogoImage() {
    fetch(base_url + "/classes/Master.php?f=fetch_logo_img")
        .then(response => response.json())
        .then(res => {
            if (res.status !== 'success') {
                console.error("API error:", res.error);
                return;
            }

            const logo = res.data?.logo_filename;
            if (!logo) {
                console.warn("Logo filename not found in API response");
                return;
            }

            // ĐƯA LINK ẢNH VÀO IMG
            const imgElement = document.getElementById("company_logo");
            imgElement.src = base_logo_img_url + logo;

        })
        .catch(err => console.error("Error fetch logo:", err));
}

// =========================
// 5) Load company profile
// =========================
function loadCompanyProfileVer2(fetchUrl, titleImgBase, bgImgBase) {

    fetch(fetchUrl)
        .then(res => res.json())
        .then(res => {

            if (res.status !== "success") {
                console.error("API error:", res.error);
                return;
            }

            const data = res.data;

            // ----------------------------
            // 1) TEXT PROFILE
            const elTitle = document.getElementById("text-company-profile");
            if (elTitle && data.text_company_profile !== null) {
                elTitle.innerHTML = data.text_company_profile;
            }

            const elText = document.getElementById("profile-text");
            if (elText && data.text_content !== null) {
                elText.innerHTML = data.text_content;
            }

            // ----------------------------
            // 2) TITLE IMAGE
            const imgProfile = document.getElementById("profile-image");
            if (imgProfile) {
                imgProfile.src =
                    (data.title_img && data.title_img !== "null")
                        ? titleImgBase + data.title_img
                        : "";
            }

            // ----------------------------
            // 3) TOP BACKGROUND
            const topBgDiv = document.getElementById("company-top-bg");

            if (topBgDiv) {
                if (Array.isArray(data.sub_images) && data.sub_images.length > 0) {
                    const cleanBg = bgImgBase.replace(/\/+$/, ""); // remove trailing slash
                    topBgDiv.style.backgroundImage = `url('${cleanBg}/${data.sub_images[0]}')`;
                } else {
                    topBgDiv.style.backgroundImage = "none";
                }
            }

            // ----------------------------
            // 4) DYNAMIC TABLE
            const tbody = document.getElementById("company-overview-body");
            if (!tbody) {
                console.error("ERROR: #company-overview-body not found");
                return;
            }

            tbody.innerHTML = ""; // Clear old

            if (Array.isArray(data.fields)) {
                data.fields.forEach(f => {
                    const tr = document.createElement("tr");

                    tr.innerHTML = `
                        <th class="field-name">${f.field_key || ""}</th>
                        <td class="prewrap">${(f.field_value || "").replace(/\n/g, "<br>")}</td>
                    `;

                    tbody.appendChild(tr);
                });
            }

        })
        .catch(err => console.error("Fetch error:", err));
}

// =========================
// 6) FONT TEXT
// =========================
function loadFontText(pageKey) {
    if (!pageKey) {
        console.warn("loadFontText: pageKey is empty");
        return;
    }

    fetch(base_url + "/classes/Master.php?f=fetch_font_text&page_key=" + encodeURIComponent(pageKey))
        .then(res => res.json())
        .then(res => {

            if (res.status !== "success" || !res.data) {
                console.log("No font config for page:", pageKey);
                return;
            }

            const font = res.data;

            //console.log("Font config loaded:", font);

            // =========================
            // 1️⃣ Inject Google Font <link>
            // =========================
            if (font.font_url) {
                // tránh inject trùng
                const existed = [...document.querySelectorAll("link")]
                    .some(l => l.href && font.font_url.includes(l.href));

                if (!existed) {
                    const tmp = document.createElement("div");
                    tmp.innerHTML = font.font_url.trim();

                    tmp.querySelectorAll("link").forEach(link => {
                        document.head.appendChild(link.cloneNode(true));
                    });
                }
            }
            // =========================
            // 2️⃣ Apply font-family CSS
            // =========================
            if (font.css_selector && font.font_family) {

                const styleId = "font-style-" + pageKey;

                if (!document.getElementById(styleId)) {
                    const style = document.createElement("style");
                    style.id = styleId;
                    style.innerHTML = `
                        ${font.css_selector} {
                            font-family: '${font.font_family}', sans-serif !important;
                        }
                    `;
                    document.head.appendChild(style);
                }
            }
            console.log("Font applied for page:", pageKey);
        })
        .catch(err => console.error("Error fetch font-family:", err));
    }
//call function
document.addEventListener("DOMContentLoaded", function () {
    loadFontText(current_page_key);
});

// =========================
// 7) PROJECTS PAGE
// =========================
function hasValidImage(img) {
    return img && img !== 'null' && img !== '';
}

function load_projects_page_data() {

    fetch(base_url + "/classes/Master.php?f=fetch_projects_page_data")
        .then(res => res.json())
        .then(res => {

            if (res.status !== 'success') {
                console.error("API error:", res.error);
                return;
            }

            const { settings, categories } = res.data;

            /* =========================
               1. TOP BACKGROUND
            ========================= */
            if (settings?.top_bg_image) {
                const bgUrl = `${base_url}/admin/uploads/projects/top_bg/1/${settings.top_bg_image}`;
                document.getElementById("company-top-bg").style.backgroundImage =
                    `url('${bgUrl}')`;
            }

            /* =========================
               2. RENDER SECTIONS
            ========================= */
            categories.forEach(category => {

                const section = document.querySelector(
                    `.section[data-category="${category.category_key}"]`
                );

                if (!section) return;

                /* ---------- DESKTOP ---------- */
                let desktopHTML = `
                    <div class="section-title">${category.category_name}</div>

                    <div class="d-none d-md-block">
                        <div class="row project-header pb-2">
                            <div class="col-md-4">施工場所</div>
                            <div class="col-md-4">発注者</div>
                            <div class="col-md-4"></div>
                        </div>
                `;

                category.items.forEach(item => {

                    let imageHTML = '';

                    if (hasValidImage(item.image)) {
                        const imgUrl = `${base_url}/admin/uploads/projects/items/${item.id}/${item.image}`;

                        imageHTML = `
                            <div class="image-wrap"
                                 data-toggle="modal"
                                 data-target="#imageModal"
                                 data-img="${imgUrl}">
                                <img src="${imgUrl}" loading="lazy">
                            </div>
                        `;
                    }

                    desktopHTML += `
                        <div class="row project-row">
                            <div class="col-md-4">${item.construction_place}</div>
                            <div class="col-md-4">${item.client_name}</div>
                            <div class="col-md-4">
                                ${imageHTML}
                            </div>
                        </div>
                    `;
                });

                desktopHTML += `</div>`;

                /* ---------- MOBILE (SWIPER) ---------- */
                let mobileHTML = `
                    <div class="d-block d-md-none overflow-hidden">
                        <div class="swiper-container projectSwiper">
                            <div class="swiper-wrapper">
                `;

                category.items.forEach(item => {

                    let imageHTML = '';

                    if (hasValidImage(item.image)) {
                        const imgUrl = `${base_url}/admin/uploads/projects/items/${item.id}/${item.image}`;

                        imageHTML = `
                            <div class="image-wrap"
                                 data-toggle="modal"
                                 data-target="#imageModal"
                                 data-img="${imgUrl}">
                                <img src="${imgUrl}" loading="lazy">
                            </div>
                        `;
                    }

                    mobileHTML += `
                        <div class="swiper-slide">
                            <div class="project-card">
                                ${imageHTML}
                                <div class="project-text text-center">
                                    <p><strong>施工場所:</strong> ${item.construction_place}</p>
                                    <p><strong>発注者:</strong> ${item.client_name}</p>
                                </div>
                            </div>
                        </div>
                    `;
                });

                mobileHTML += `
                            </div>
                            <div class="w-100 d-flex justify-content-between">
                                <div class="swiper-button-prev project-prev"></div>
                                <div class="swiper-button-next project-next"></div>
                            </div>
                        </div>
                    </div>
                `;

                section.innerHTML = desktopHTML + mobileHTML;

                /* ---------- INIT SWIPER ---------- */
                setTimeout(() => {
                    initProjectSwiper();
                }, 0);
            });

            /* =========================
               3. FOOTER TEXT
            ========================= */
            const footer = document.getElementById("projects-footer");
            if (footer) {
                footer.innerHTML = settings?.footer_text || "";
            }

            /* =========================
               4. HIDE LOADING
            ========================= */
            if (typeof fadeOutOverlay === "function") {
                fadeOutOverlay("loading-overlay");
            }

            /* =========================
               5. IMAGE LOADED EFFECT
            ========================= */
            setTimeout(() => {
                if (typeof initImageLoadedObserver === "function") {
                    initImageLoadedObserver();
                }
            }, 0);

        })
        .catch(err => console.error("Fetch error:", err));
}

let projectSwiper = null;
function initProjectSwiper() {
    const swiperEl = document.querySelector('.projectSwiper');
    const slideCount = swiperEl.querySelectorAll('.swiper-slide').length;

    if (!swiperEl) return;

    const isMobile = window.innerWidth < 768;

    if (isMobile && !projectSwiper) {
        projectSwiper = new Swiper('.projectSwiper', {
            spaceBetween: 16,
            observer: true,
            observeParents: true,
            loop: slideCount >= 3,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            breakpoints: {
                0: {
                    slidesPerView: 2   // < sm
                },
                576: {
                    slidesPerView: 3   // >= sm & < md
                }
            },

            navigation: {
                nextEl: '.project-next',
                prevEl: '.project-prev'
            }
        });
    }

    if (!isMobile && projectSwiper) {
        projectSwiper.destroy(true, true);
        projectSwiper = null;
    }
}

function initImageLoadedObserver() {

    const observer = new IntersectionObserver((entries, obs) => {
        entries.forEach(entry => {
            if (!entry.isIntersecting) return;

            const img = entry.target;
            const wrap = img.closest('.image-wrap');

            if (!wrap) return;

            if (img.complete && img.naturalWidth > 0) {
                wrap.classList.add('loaded');
            } else {
                img.addEventListener('load', () => {
                    wrap.classList.add('loaded');
                }, { once: true });
            }

            obs.unobserve(img);
        });
    }, { threshold: 0.15 });

    document.querySelectorAll('.image-wrap img').forEach(img => {
        observer.observe(img);
    });
}

function initImageModal(modalSelector = '#imageModal', imageSelector = '#modalImage') {

    const $modal = $(modalSelector);
    const $image = $(imageSelector);

    if ($modal.length === 0 || $image.length === 0) return;

    // Khi mở modal
    $modal.on('show.bs.modal', function (e) {
        const $trigger = $(e.relatedTarget);
        let largeImg = $trigger.data('img');

        // fallback sang ảnh thumb
        if (!largeImg || largeImg.trim() === "") {
            const thumb = $trigger.find('img').attr('src');
            if (thumb && thumb.trim() !== "") {
                largeImg = thumb;
            }
        }

        // không có ảnh → không mở modal
        if (!largeImg) {
            e.preventDefault();
            return;
        }

        $image.attr('src', largeImg);
    });

    // tránh warning focus / aria
    $modal.on('hide.bs.modal', function () {
        document.body.focus();
    });

    // cleanup sau khi đóng
    $modal.on('hidden.bs.modal', function () {
        $image.attr('src', '');
    });
}
