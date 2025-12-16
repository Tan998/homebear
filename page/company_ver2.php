<div id="loading-overlay" class="d-flex flex-column justify-content-center align-items-center w-100 h-100">
  <p class="presentation-title">HOMEBEAR</p>
  <div class="spinner-grow text-light" role="status">
    <span class="sr-only">Loading...</span>
  </div>
</div>

<div id="company-top-bg" class="page-header page-header-xs" data-parallax="true" style="background-size: cover;">
  <div class="filter"></div>
</div>

  <div id="profile-content" class="section profile-content">
    <div class="container">
      <!--company text-->
      <div class="row">
        <div class="col-12 d-flex justify-content-center mt-5">
          <img class="img-fluid wow fadeInLeftBig" data-wow-duration="1s" data-wow-delay="2s" style="visibility: visible; animation-duration: 1.5s; animation-delay: 2s; animation-name: fadeInLeftBig;" src="./assets/img/homebear/company-text.png" alt="">
        </div>
        <!--<div class="col-12 d-flex justify-content-center mt-3">
          <img class="img-fluid" src="./assets/img/homebear/company-text-2.png" alt="">
        </div>-->
      </div>
      <!--company text end-->

      <!--text profile-->
      <div id="contents" class="row">
        <div class="col-12 mt-5">
          <p class="text-center text-title wow fadeInRightBig" data-wow-duration="1s" data-wow-delay="2s" style="visibility: visible; animation-duration: 1.5s; animation-delay: 2s; animation-name: fadeInRightBig;">代表メッセージ</p>
        </div>
        <div class="col-lg-6 col-md-8 ml-auto mr-auto text-center mt-5">
          <p id="text-company-profile" class="text-company-profile wow fadeInUpBig" data-wow-duration="1s" data-wow-delay="2s" style="visibility: visible; animation-duration: 1.5s; animation-delay: 2s; animation-name: fadeInUpBig;"></p>
        </div>
      </div>
      <!--text profile end-->

      <!--main content-->
      <div id="main_contents" class="row my-5 wow fadeInUpBig" data-wow-duration="1s" data-wow-delay="2s" style="visibility: visible; animation-duration: 1.5s; animation-delay: 2s; animation-name: fadeInUpBig;">
        <div class="col-lg-5 d-flex justify-content-center my-2">
          <img id="profile-image" class="img-fluid img-thumbnail" src="" alt="">
        </div>
        <div class="col-lg-7 my-2">
          <p id="profile-text"></p>
        </div>
      </div>
      <!--main content end-->
    </div>

    <!--company overview-->
    <div class="container-fluid bg-light-cus py-5">
      <div id="company_overview" class="">
        <div class="col-12 mt-5">
          <p class="text-center text-title wow fadeInUpBig" data-wow-duration="1s" data-wow-delay="0.5s" style="visibility: visible; animation-duration: 1.5s; animation-delay: 2s; animation-name: fadeInUpBig;">会社概要</p>
        </div>
      </div>
      <!--table-->
      <div class="table-responsive d-flex justify-content-center my-5 wow fadeInUpBig" data-wow-duration="1s" data-wow-delay="0.5s" style="visibility: visible; animation-duration: 1.5s; animation-delay: 2s; animation-name: fadeInUpBig;">
        <table class="table table-hover col-12 col-md-8">
          <tbody id="company-overview-body">
          </tbody>
        </table>
      </div>
      <!--table-->
    </div>
    <!--company overview end-->
  </div>
<script> 
document.addEventListener("DOMContentLoaded", function () {
  loadCompanyProfileVer2(
    "<?= base_url ?>/classes/Master.php?f=fetch_company_profile_ver2",
    "<?= company_profile_ver2_title_img ?>",
    "<?= company_profile_ver2_top_bg_img ?>"
  );
});
</script>

<script>
// =========================
document.addEventListener("DOMContentLoaded", function () {
    fadeOutOverlay("loading-overlay");
});
</script>

