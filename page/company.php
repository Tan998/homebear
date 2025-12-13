<style>
  .bg-light-cus {
    background-color: #f5f5f5 !important;
  }
  #profile-content .text-title{
    font-size: 1.2rem;
    font-weight: bold;
  }
  #profile-content #contents .text-company-profile{
    font-size: 1.8rem;
    font-weight: bold;
  }
  #profile-content #main_contents #profile-image{
    max-height: 800px !important;
  }
  #profile-content #main_contents #profile-text{
    font-size: 1.1rem;
    white-space: break-spaces;
  }

    /* Tinh chỉnh nhỏ để dòng dài tự xuống hàng tốt hơn */
    .table td, .table th {
      vertical-align: top;
    }
    .prewrap { word-break: break-word; }
    /* Màu nhẹ cho heading cột bên trái */
    .field-name {
      font-weight: 600;
      width: 200px;
      min-width: 160px;
    }
    /* Responsive: hiển thị block trên màn hình nhỏ (nếu muốn) */
    @media (max-width: 575.98px) {
      .field-name { width: 10%; }
    }
</style>

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
    <div class="container-fluid bg-light-cus">
      <div id="company_overview" class="">
        <div class="col-12 mt-5">
          <p class="text-center text-title pt-5 wow fadeInUpBig" data-wow-duration="1s" data-wow-delay="0.5s" style="visibility: visible; animation-duration: 1.5s; animation-delay: 2s; animation-name: fadeInUpBig;">会社概要</p>
        </div>
      </div>
      <!--table-->
      <div class="table-responsive d-flex justify-content-center my-5 wow fadeInUpBig" data-wow-duration="1s" data-wow-delay="0.5s" style="visibility: visible; animation-duration: 1.5s; animation-delay: 2s; animation-name: fadeInUpBig;">
        <table class="table table-bordered col-12 col-md-8">
          <tbody>
            <tr>
              <th class="field-name">会社名</th>
              <td id="company_name" class="prewrap"></td>
            </tr>

            <tr>
              <th class="field-name">本社所在地</th>
              <td id="company_address" class="prewrap"></td>
            </tr>

            <tr>
              <th class="field-name">電話番号</th>
              <td class="prewrap"><a id="company_phone_link" href="#"><span id="company_phone"></span></a></td>
            </tr>

            <tr>
              <th class="field-name">設立日</th>
              <td id="establishment_date" class="prewrap"></td>
            </tr>

            <tr>
              <th class="field-name">資本金</th>
              <td id="capital_stock" class="prewrap"></td>
            </tr>

            <tr>
              <th class="field-name">役員</th>
              <td class="prewrap">
                <ul id="list_staff" class="mb-0 list-unstyled list-group list-group-flush">
                </ul>
              </td>
            </tr>

            <tr>
              <th class="field-name">社員数</th>
              <td  id="number_of_employees" class="prewrap"></td>
            </tr>

            <tr>
              <th class="field-name">許認可等</th>
              <td id="permits_and_licenses" class="prewrap">
              </td>
            </tr>

            <tr>
              <th class="field-name">知的財産</th>
              <td id="intellectual_property" class="prewrap"><a href="#" class="small"></a></td>
            </tr>

            <tr>
              <th class="field-name">事業内容</th>
              <td id="business_content" class="prewrap">
              </td>
            </tr>

            <tr>
              <th class="field-name">取引銀行</th>
              <td id="bank_info" class="prewrap">
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <!--table-->

  </div>
    </div>
    <!--company overview end-->
  </div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    fetch("<?= base_url ?>/classes/Master.php?f=fetch_company_profile")
        .then(response => response.json())
        .then(res => {
            if (res.status !== 'success') {
                console.error("API error:", res.error);
                return;
            }

            const company = res.data;

            // ================================
            // 1️⃣ TEXT PROFILE
            // ================================
            document.getElementById("text-company-profile").innerHTML =
                company.text_company_profile || "";

            document.getElementById("profile-text").innerHTML =
                company.text_content || "";

            // ================================
            // 2️⃣ PROFILE IMAGE
            // ================================
            const titleImg = "<?= company_profile_title_img ?>" + company.title_img;
            const TopImg = company.sub_img[0]
                ? "<?= company_profile_top_bg_img ?>" + company.sub_img[0]
                : "";

            const topBgDiv = document.getElementById("company-top-bg");
            topBgDiv.style.backgroundImage = `url('${TopImg}')`;

            document.getElementById("profile-image").src = titleImg;

            // ================================
            // 3️⃣ COMPANY OVERVIEW TABLE
            // ================================

            document.getElementById("company_name").innerHTML =
                company.company_name;

            document.getElementById("company_address").innerHTML =
                company.company_address;

            // phone
            document.getElementById("company_phone").innerHTML =
                company.company_phone;

            document.getElementById("company_phone_link").href =
                "tel:" + company.company_phone.replace(/-/g, "");

            document.getElementById("establishment_date").innerHTML =
                company.establishment_date;

            document.getElementById("capital_stock").innerHTML =
                company.capital_stock;

            // Staff list
            const staffList = document.getElementById("list_staff");
            staffList.innerHTML = "";
            company.list_staff.split(/\r?\n/).forEach(item => {
                if (item.trim() !== "") {
                    let li = document.createElement("li");
                    li.classList.add("my-1");
                    li.textContent = item;
                    staffList.appendChild(li);
                }
            });
            //number_of_employees
            document.getElementById("number_of_employees").innerHTML =
                company.number_of_employees;
            // Permits
            document.getElementById("permits_and_licenses").innerHTML =
                company.permits_and_licenses.replace(/\n/g, "<br>");

            // Intellectual property (HTML allowed)
            document.getElementById("intellectual_property").innerHTML =
                company.intellectual_property;

            // Business content
            document.getElementById("business_content").innerHTML =
                company.business_content.replace(/\n/g, "<br>");

            // Bank info
            document.getElementById("bank_info").innerHTML =
                company.bank_info.replace(/\n/g, "<br>");

        })
        .catch(err => console.error("Error fetch:", err));
});
</script>
<script>
// =========================
document.addEventListener("DOMContentLoaded", function () {
    fadeOutOverlay("loading-overlay");
});

</script>
