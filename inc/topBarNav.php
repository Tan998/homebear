<!-- Navbar -->
  <nav class="navbar fixed-top navbar-transparent navbar-custom" color-on-scroll="50">
    <div class="container-fluid">
      <div class="navbar-translate w-100 d-flex justify-content-between align-items-center">
        <a class="navbar-brand" href="./home" rel="tooltip" title="Coded by Creative Tim" data-placement="bottom">
          ＨｏｍｅＢｅａｒ
        </a>
        <div class="d-flex justify-content-between align-items-center">
          <a class="navbar-sns-icon" rel="tooltip" title="Follow us on Instagram" data-placement="bottom" href="https://www.instagram.com/home_bear0301/" target="_blank">
            <i class="fa fa-instagram"></i>
            <p class="d-none">Instagram</p>
          </a>
          <!--<a class="navbar-sns-icon" rel="tooltip" title="Follow us on Instagram" data-placement="bottom" href="" target="_blank">
            <i class="fa fa-twitter"></i>
            <p class="d-none">X</p>
          </a>
          <a class="navbar-sns-icon" rel="tooltip" title="Like us on Facebook" data-placement="bottom" href="" target="_blank">
            <i class="fa fa-facebook-square"></i>
            <p class="d-lg-none">Facebook</p>
          </a>-->
          <button class="navbar-toggler navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="toggler-line line1"></span>
            <span class="toggler-line line2"></span>
            <span class="toggler-line line3"></span>
          </button>
        </div>
      </div>
      <div class="collapse custom-collapse justify-content-end" id="navigation">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a href="./company" class="nav-link">COMPANY</a>
          </li>
          <!--<li class="nav-item">
            <a href="./contact" class="nav-link">CONTACT</a>
          </li>-->
        </ul>
      </div>
    </div>
  </nav>
  <!-- End Navbar -->

<script>
const toggleBtn = document.querySelector('.navbar-toggler');
const collapse = document.querySelector('#navigation');

toggleBtn.addEventListener('click', function(e) {

    if (collapse.classList.contains('show')) {
        e.preventDefault();
        e.stopPropagation();
        toggleBtn.classList.remove('open');
        closeCollapseSmooth();
        return;
    }

    // mở nhanh – bypass bootstrap
    e.preventDefault();
    e.stopPropagation();
    toggleBtn.classList.add('open');
    openCollapseSmooth();
});

// CLICK NGOÀI
document.addEventListener('click', function(e) {
    if (toggleBtn.contains(e.target)) return;

    if (collapse.classList.contains('show') && !collapse.contains(e.target)) {
        toggleBtn.classList.remove('open');
        closeCollapseSmooth();
    }
});

// MỞ MƯỢT – KHÔNG DELAY
function openCollapseSmooth() {
    collapse.style.maxHeight = "0";
    collapse.style.opacity = "0";
    collapse.style.transform = "translateY(-20px) scale(0.98)";

    collapse.classList.add("show");

    requestAnimationFrame(() => {
        collapse.style.maxHeight = collapse.scrollHeight + "px";
        collapse.style.opacity = "1";
        collapse.style.transform = "translateY(0) scale(1)";
    });
}

// ĐÓNG MƯỢT
function closeCollapseSmooth() {
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
}


</script>

