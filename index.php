<?php require_once('config.php'); ?>

<!DOCTYPE html>
<html lang="ja">
<?php require_once(base_app . 'inc/header.php') ?>

<body class="index-page sidebar-collapse">
  <?php require_once(base_app . 'inc/topBarNav.php') ?>
  
  
  <?php
      // Lấy URI như /process
      $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
      $scriptName = dirname($_SERVER['SCRIPT_NAME']);

      // Xử lý base folder nếu website không ở root
      if ($scriptName !== '/' && strpos($requestUri, $scriptName) === 0) {
          $requestUri = substr($requestUri, strlen($scriptName));
      }

      $requestPath = trim($requestUri, '/');

      // Luôn ưu tiên lấy từ ?p= nếu có
      if (isset($_GET['p']) && $_GET['p'] !== '') {
          $page = trim($_GET['p'], '/');
      } else {
          // Nếu không có ?p= thì fallback = home
          $page = 'home';
      }

      //Trường hợp đặc biệt: ?p=contact/ads/thanks → contact_ads_thanks.php
      if ($page === 'contact/ads/thanks') {
          $page = 'contact_ads_thanks';
      }

      $path = 'page/' . $page;

      // Nếu file không tồn tại → 404
      if (!file_exists($path . ".php") && !is_dir($path)) {
          include '404.html';
      } else {
          // Nếu là folder thì load index.php bên trong
          if (is_dir($path)) {
              include $path . '/index.php';
          } else {
              include $path . '.php';
          }
      }
  ?>

    
    <!--====== DOWNLOAD PART ENDS ======-->
    
    <?php require_once(base_app . 'inc/footer.php') ?>
    
</body></html>