<footer class="footer footer-black footer-white d-none">
      <div class="container">
        <div class="row">
          <nav class="footer-nav">
            <ul>
              <li>
                <a href="" target="_blank"></a>
              </li>
              <li>
                <a href="" target="_blank"></a>
              </li>
              <li>
                <a href="" target="_blank"></a>
              </li>
            </ul>
          </nav>
          <div class="credits ml-auto">
            <span class="copyright">
              ©
              <script>
                document.write(new Date().getFullYear())
              </script>, made by Homebear
            </span>
          </div>
        </div>
      </div>
    </footer>
    <!--   Core JS Files   -->
    <script src="<?= base_url ?>/assets/js/core/jquery.min.js" type="text/javascript"></script>
    <script src="<?= base_url ?>/assets/js/core/popper.min.js" type="text/javascript"></script>
    <script src="<?= base_url ?>/assets/js/core/bootstrap.min.js" type="text/javascript"></script>
    <!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
    <script src="<?= base_url ?>/assets/js/plugins/bootstrap-switch.js"></script>
    <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
    <script src="<?= base_url ?>/assets/js/plugins/nouislider.min.js" type="text/javascript"></script>
    <!--  Plugin for the DatePicker, full documentation here: https://github.com/uxsolutions/bootstrap-datepicker -->
    <script src="<?= base_url ?>/assets/js/plugins/moment.min.js"></script>
    <script src="<?= base_url ?>/assets/js/plugins/bootstrap-datepicker.js" type="text/javascript"></script>
    <!-- Control Center for Paper Kit: parallax effects, scripts for the example pages etc -->
    <script src="<?= base_url ?>/assets/js/paper-kit.js?v=2.2.0" type="text/javascript"></script>
    <!--  Google Maps Plugin    -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
    <!--Bundel
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>-->
    <!--script YouTube API-->
    <script src="https://www.youtube.com/iframe_api"></script>
    <!--====== WOW js ======-->
    <script src="<?= base_url ?>/assets/js/wow.min.js"></script>
    
    <!--Custom-->
    <script src="<?= base_url ?>/assets/js/homebear.js?v=<?= version ?>"></script>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
      initSmoothNavbar('.navbar-toggler', '#navigation');
      loadLogoImage();
    });
    </script>
    <script>
      $(document).ready(function() {

        if ($("#datetimepicker").length != 0) {
          $('#datetimepicker').datetimepicker({
            icons: {
              time: "fa fa-clock-o",
              date: "fa fa-calendar",
              up: "fa fa-chevron-up",
              down: "fa fa-chevron-down",
              previous: 'fa fa-chevron-left',
              next: 'fa fa-chevron-right',
              today: 'fa fa-screenshot',
              clear: 'fa fa-trash',
              close: 'fa fa-remove'
            }
          });
        }

        function scrollToDownload() {

          if ($('.section-download').length != 0) {
            $("html, body").animate({
              scrollTop: $('.section-download').offset().top
            }, 1000);
          }
        }
      });
    </script>