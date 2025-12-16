<?php
require_once('../config.php');


Class Master extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}
	public function __destruct(){
		parent::__destruct();
	}
	public function index(){
		echo "<h1>Access Denied</h1> <a href='".base_url."'>Go Back.</a>";
	}
	
	function getUserIP() {

	    // 1. Cloudflare IP (ưu tiên)
	    if (!empty($_SERVER['HTTP_CF_CONNECTING_IP'])) {
	        return $_SERVER['HTTP_CF_CONNECTING_IP'];
	    }

	    // 2. X-Forwarded-For (có thể chứa nhiều IP)
	    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {

	        $ipArray = array_map('trim', explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']));

	        foreach ($ipArray as $ip) {
	            // Loại IP private
	            if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
	                return $ip;
	            }
	        }
	    }

	    // 3. Client-IP (rare)
	    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
	        if (filter_var($_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP)) {
	            return $_SERVER['HTTP_CLIENT_IP'];
	        }
	    }

	    // 4. Remote Addr (fallback)
	    $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';

	    // Convert IPv6 localhost to IPv4
	    return $ip === '::1' ? '127.0.0.1' : $ip;
	}

	function save_contact() {
	    extract($_POST);
	    //* Check captcha
	    $recaptcha_token = $_POST['recaptcha_token'] ?? '';
		if (!$recaptcha_token) {
		    echo json_encode([
		        'status' => 'failed',
		        'error' => '情報が確認できませんでした。'
		    ]);
		    exit;
		}
		// verify token
		$secretKey = captcha_secret_key;
		$verifyURL = captcha_verifyURL;

		$postData = http_build_query([
		    'secret' => $secretKey,
		    'response' => $recaptcha_token,
		    'remoteip' => $_SERVER['REMOTE_ADDR']
		]);

		$opts = [
		    'http' => [
		        'method' => 'POST',
		        'header' => "Content-type: application/x-www-form-urlencoded\r\n",
		        'content' => $postData
		    ]
		];
		$context = stream_context_create($opts);
		$result = file_get_contents($verifyURL, false, $context);

		$response = json_decode($result);

		if (!$response->success || $response->score < 0.5) {
		    echo json_encode([
		        'status' => 'failed',
		        'error' => '不正なアクセスの可能性があります。'
		    ]);
		    exit;
		}
		if ($response->action !== 'contact_form') {
		    exit(json_encode(['status' => 'failed', 'error' => '不正なアクセスです。']));
		}
		//* Check captcha

	    $ip = $this->getUserIP();
	    $now = time();
	    $limitSeconds = 60; // chặn gửi liên tục

	    $mail_to = config_mail_to_gpro; //sales@mujin24.com

	    // 1. CHECK BLACKLIST - (IP BLOCKED)
	    $sql = "SELECT ip FROM black_list_ip WHERE ip = ?";
        $stmt = $this->conn->prepare($sql);
	    $stmt->bind_param("s", $ip);
	    $stmt->execute();
	    $stmt->store_result();
	    if ($stmt->num_rows > 0) {
	        echo json_encode([
	            'status' => 'failed',
	            'error' => 'アクセスが制限されています。'
	        ]);
	        exit;
	    }
	    $stmt->close();

	    // 2. RATE LIMIT - kiểm tra contact gần nhất theo IP
	    $sql = "SELECT last_submit FROM contact_mujin WHERE ip = ? ORDER BY last_submit DESC LIMIT 1";
        $stmt = $this->conn->prepare($sql);
	    $stmt->bind_param("s", $ip);
	    $stmt->execute();
	    $stmt->store_result();
	    $stmt->bind_result($lastSubmit);

	    if ($stmt->num_rows > 0) {
	        $stmt->fetch();
	        if ($now - $lastSubmit < $limitSeconds) {
	            echo json_encode([
	                'status' => 'failed',
	                'error' => '短時間で複数回の送信はできません。しばらくしてから再度お試しください。'
	            ]);
	            exit;
	        }
	    }
	    $stmt->close();

	    // 3. VALIDATE dữ liệu gửi lên

		// độ dài max
		$required_fields = [
		    'contact_type'      => 1,
		    'customer_type'     => 50,
		    'customer_email'    => 100,
		    'customer_name'     => 30,
		    'customer_phone'    => 15,
		    'customer_address'  => 100,
		    'contact_text'      => 1000
		];

		// Kiểm tra từng trường
		foreach ($required_fields as $field => $maxLength) {

		    if (empty($_POST[$field])) {
		        echo json_encode([
		            'status' => 'failed',
		            'error'  => '情報を完全に入力してください。（'.$field.'）'
		        ]);
		        exit;
		    }

		    // Cắt chuỗi nếu dài quá (chống bypass)
		    $_POST[$field] = mb_substr($_POST[$field], 0, $maxLength, "UTF-8");
		}

		// Gán lại biến sau khi clean
		$contact_type     = $_POST['contact_type'];
		$customer_type    = $_POST['customer_type'];
		$customer_email   = $_POST['customer_email'];
		$customer_name    = $_POST['customer_name'];
		$customer_phone   = $_POST['customer_phone'];
		$customer_address = $_POST['customer_address'];
		$contact_text     = $_POST['contact_text'];

		// --- Validate Email ---
		if (!filter_var($customer_email, FILTER_VALIDATE_EMAIL)) {
		    echo json_encode([
		        'status' => 'failed',
		        'error'  => 'メールアドレスの形式が正しくありません。'
		    ]);
		    exit;
		}

		// --- Validate Phone: chỉ cho phép số ---
		if (!preg_match('/^[0-9]+$/', $customer_phone)) {
		    echo json_encode([
		        'status' => 'failed',
		        'error'  => '電話番号は数字のみご入力ください。'
		    ]);
		    exit;
		}

		// --- Validate contact_type là số hợp lệ ---
		if (!preg_match('/^[1-7]$/', $contact_type)) {
		    echo json_encode([
		        'status' => 'failed',
		        'error'  => 'お問い合わせ種別が正しくありません。'
		    ]);
		    exit;
		}

	    // 4. INSERT CONTACT
	    $sql = "INSERT INTO `contact_mujin`
	            (contact_type, customer_type, customer_email, customer_name, customer_address, contact_text, customer_phone, ip, last_submit) 
	            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

	    $stmt = $this->conn->prepare($sql);
	    $stmt->bind_param("ssssssssi",
	        $contact_type, $customer_type, $customer_email, $customer_name,
	        $customer_address, $contact_text, $customer_phone, $ip, $now
	    );

	    if ($stmt->execute()) {

	        // --- Gửi Email ---
	        $mailer = new Mailer();
	        // --- Gửi Email ---
			$contact_types = [
			    "1" => "打ち合わせで相談したい",
			    "2" => "機能について詳しく知りたい",
			    "3" => "見積もり作成を依頼したい",
			    "4" => "デモを見てみたい",
			    "5" => "導入企業や事例について知りたい",
			    "6" => "協業・パートナー制度について知りたい",
			    "7" => "その他"
			];

			$contact_type_label = isset($contact_types[$contact_type]) ? $contact_types[$contact_type] : "未指定";
	        $subject = "【Mujin24】【{$contact_type_label}】　{$customer_name} 様よりお問い合わせがありました。";
	        $body = "
	            差出人: {$customer_name} [{$customer_email}]<br>

				--<br>
				本メールはあなたのウェブサイト (MUJIN 24 https://mujin24.com) のコンタクトフォームに送信があったことをお知らせするものです。<br>


				■ お問い合わせ種別<br>
				{$contact_type_label}<br><br>

				■ 会社名<br>
				{$customer_type}<br><br>

				■ お名前<br>
				{$customer_name}<br><br>

				■ 電話番号<br>
				{$customer_phone}<br><br>

				■ メールアドレス<br>
				{$customer_email}<br><br>

				■ 導入予定地域<br>
				{$customer_address}<br><br>

				■ お問い合わせ内容<br>
				<pre>{$contact_text}</pre><br><br>


	            ――――――――――――――――――――――――――――――<br>
	        ";
	        //to 
	        $mailer->sendMail($mail_to, $subject, $body);
			
	        // to user
	        $subject2 = "【Mujin24】問い合わせありがとうございます";
	        $body2 = "
		        <div style='text-align: center;'>
			        <img src='https://mujin24.com/assets/images/mujin-img/mujin-logo-new.png' alt='Thanks' style='max-width: 100%; height: auto;'>
			    </div>
			    <br>
			    {$customer_name}様
			    <br><br>
	        	このたびは、お問い合わせいただき誠にありがとうございます。
	        	<br><br>
 				-------------------------------
 				<br>
				以下の内容で受付を承りました。
				<br>
				内容に応じて、担当者よりご連絡させていただきます。<br>
				⸻<br>
				■ お問い合わせ種類：{$contact_type_label}<br>
				■ 会社名：{$customer_type}<br>
				■ お名前：{$customer_name}<br>
				■ 電話番号：{$customer_phone}<br>
				■ メールアドレス：{$customer_email}<br>
				■ 導入予定地域：{$customer_address}<br>
				■ お問い合わせ内容：<pre>{$contact_text}</pre><br><br>

				-------------------------------
				<br><br>
				以下リンクをクリックいただくと、資料・システム動画をご覧いただけます。<br>
				ぜひお役立てください。
				<br><br>
				◾️製品資料
				<br>
				https://bit.ly/mujin24catalogue
				<br><br>
				◾️ システム参考動画
				<br>
				https://m.youtube.com/shorts/ITTTAql3jqE
				<br>
				※通信環境のよい場所でご覧ください
				<br><br>
				本メールは自動送信にてお送りしております。
				<br>
				このメールにご返信いただいてもご対応いたしかねますので、あらかじめご了承ください。
				<br><br>
				ご不明点や追加のご要望がございましたら、下記までお気軽にご連絡ください。
				<br>
				sales@mujin24.com
				<br>
				今後ともどうぞよろしくお願い申し上げます。
				<br><br>
	            ――――――――――――――――――――――――――――――<br>
	            株式会社GPRO <br>
				兵庫県尼崎市南塚口町5-14-12 <br>
				06-6430-5111 <br>
				（月～金 9:30～17:30 / 土日祝除く <br>
				 sales@mujin24.com <br>
				 www.gpro.co.jp <br>
	            ――――――――――――――――――――――――――――――<br>
	        ";
	        $mailer->sendMail($customer_email, $subject2, $body2);
	        echo json_encode([
			    'status' => 'success',
			    'message' => "お問い合わせありがとうございます。"
			]);
			exit;
    	} else {
		    echo json_encode([
		        'status' => 'failed',
		        'error' => $stmt->error
		    ]);
		    exit;
		}
	}

	function download_materials_form() {
	    extract($_POST);
	    
	    //* Check captcha
	    $recaptcha_token = $_POST['recaptcha_token'] ?? '';
		if (!$recaptcha_token) {
		    echo json_encode([
		        'status' => 'failed',
		        'error' => 'reCAPTCHA が確認できませんでした。'
		    ]);
		    exit;
		}
		// verify token
		$secretKey = captcha_secret_key;
		$verifyURL = captcha_verifyURL;

		$postData = http_build_query([
		    'secret' => $secretKey,
		    'response' => $recaptcha_token,
		    'remoteip' => $_SERVER['REMOTE_ADDR']
		]);

		$opts = [
		    'http' => [
		        'method' => 'POST',
		        'header' => "Content-type: application/x-www-form-urlencoded\r\n",
		        'content' => $postData
		    ]
		];
		$context = stream_context_create($opts);
		$result = file_get_contents($verifyURL, false, $context);

		$response = json_decode($result);

		if (!$response->success || $response->score < 0.5) {
		    echo json_encode([
		        'status' => 'failed',
		        'error' => '不正なアクセスの可能性があります。'
		    ]);
		    exit;
		}
		if ($response->action !== 'download_materials_form') {
		    exit(json_encode(['status' => 'failed', 'error' => '不正なアクセスです。']));
		}
		//* Check captcha
		
	    $ip = $this->getUserIP();
	    $now = time();
	    $limitSeconds = 60; // chặn gửi liên tục

	    $mail_to = config_mail_to_gpro; //sales@mujin24.com

	    // 1. CHECK BLACKLIST - (IP BLOCKED)
	    $sql = "SELECT ip FROM black_list_ip WHERE ip = ?";
        $stmt = $this->conn->prepare($sql);
	    $stmt->bind_param("s", $ip);
	    $stmt->execute();
	    $stmt->store_result();
	    if ($stmt->num_rows > 0) {
	        echo json_encode([
	            'status' => 'failed',
	            'error' => 'アクセスが制限されています。'
	        ]);
	        exit;
	    }
	    $stmt->close();

	    // 2. RATE LIMIT - kiểm tra contact gần nhất theo IP
	    $sql = "SELECT last_submit FROM download_materials_form WHERE ip = ? ORDER BY last_submit DESC LIMIT 1";
        $stmt = $this->conn->prepare($sql);
	    $stmt->bind_param("s", $ip);
	    $stmt->execute();
	    $stmt->store_result();
	    $stmt->bind_result($lastSubmit);

	    if ($stmt->num_rows > 0) {
	        $stmt->fetch();
	        if ($now - $lastSubmit < $limitSeconds) {
	            echo json_encode([
	                'status' => 'failed',
	                'error' => '短時間で複数回の送信はできません。しばらくしてから再度お試しください。'
	            ]);
	            exit;
	        }
	    }
	    $stmt->close();

	    // 3. VALIDATE (server-side)
		// Danh sách các field input text + giới hạn độ dài
		$text_fields = [
		    'company_name'   => 50,
		    'customer_fname' => 15,
		    'customer_name'  => 15,
		    'customer_email' => 100,
		    'customer_phone' => 15,
		];

		// Kiểm tra rỗng + độ dài
		foreach ($text_fields as $field => $max) {

		    if (!isset($_POST[$field]) || trim($_POST[$field]) === '') {
		        echo json_encode([
		            'status' => 'failed',
		            'error'  => 'すべての必須項目を入力してください。（' . $field . '）'
		        ]);
		        exit;
		    }

		    // Cắt chuỗi quá dài (chống bypass JS)
		    $_POST[$field] = mb_substr($_POST[$field], 0, $max, "UTF-8");
		}

		// Gán lại biến
		$company_name   = $_POST['company_name'];
		$customer_fname = $_POST['customer_fname'];
		$customer_name  = $_POST['customer_name'];
		$customer_email = $_POST['customer_email'];
		$customer_phone = $_POST['customer_phone'];

		// ---- VALIDATE EMAIL ----
		if (!filter_var($customer_email, FILTER_VALIDATE_EMAIL)) {
		    echo json_encode([
		        'status' => 'failed',
		        'error'  => 'メールアドレスの形式が正しくありません。'
		    ]);
		    exit;
		}

		// ---- VALIDATE PHONE (chỉ số) ----
		if (!preg_match('/^[0-9]+$/', $customer_phone)) {
		    echo json_encode([
		        'status' => 'failed',
		        'error'  => '電話番号は数字のみご入力ください。'
		    ]);
		    exit;
		}

		// ========================================================
		// VALIDATE membership_size (danh sách select hợp lệ)
		// ========================================================

		$valid_membership = [
		    "1-50名",
		    "51-100名",
		    "101-200名",
		    "201-300名",
		    "301-500名",
		    "500-1000名",
		    "1001名以上",
		    "開業前 未定"
		];

		if (!isset($_POST['membership_size']) || !in_array($_POST['membership_size'], $valid_membership)) {
		    echo json_encode([
		        'status' => 'failed',
		        'error'  => '会員規模を正しく選択してください。'
		    ]);
		    exit;
		}

		$membership_size = $_POST['membership_size'];

		// ========================================================
		// VALIDATE current_operation_status (danh sách select hợp lệ)
		// ========================================================

		$valid_operation_status = [
		    "現在、1~2店舗を運営している",
		    "現在、3~10店舗を運営している",
		    "現在、10店舗以上を運営している",
		    "3ヶ月以内オープン予定",
		    "半年以内オープン予定",
		    "一年以内オープン予定",
		    "開業未定"
		];

		if (!isset($_POST['current_operation_status']) || !in_array($_POST['current_operation_status'], $valid_operation_status)) {
		    echo json_encode([
		        'status' => 'failed',
		        'error'  => '現在運営状況を正しく選択してください。'
		    ]);
		    exit;
		}

		$current_operation_status = $_POST['current_operation_status'];

		// ========================================================
		// VALIDATE EXPLANATION + SHOWROOM (radio/select)
		// ========================================================

		if (!isset($explanation_status) || $explanation_status === '' ||
		    !isset($showroom_tour_status) || $showroom_tour_status === '') {

		    echo json_encode([
		        'status' => 'failed',
		        'error'  => '説明会・ショールーム見学の選択を行ってください。'
		    ]);
		    exit;
		}

	    // Tạo access_token và hạn sử dụng (1 giờ)
	    $access_token = bin2hex(random_bytes(32));
	    $token_expired_at = date('Y-m-d H:i:s', time() + 3600);

	    // Lưu vào database
	    $sql = "INSERT INTO download_materials_form 
	        (company_name, customer_fname, customer_name, customer_email, customer_phone, membership_size, current_operation_status, access_token, token_expired_at,explanation_status, showroom_tour_status, ip, last_submit)
	        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
	    $stmt = $this->conn->prepare($sql);
	    $stmt->bind_param("sssssssssiisi", $company_name, $customer_fname, $customer_name, $customer_email, $customer_phone, $membership_size, $current_operation_status, $access_token, $token_expired_at, $explanation_status, $showroom_tour_status, $ip, $now);

	    $explanation_text = ($explanation_status == 1) ? 'はい' : 'いいえ';
	    $showroom_tour_text = ($showroom_tour_status == 1) ? 'はい' : 'いいえ';

	    if ($stmt->execute()) {
	        // --- Gửi Email ---
	        $mailer = new Mailer();

	        // Gửi thông báo đến nội bộ
	        $subject = "【Mujin24】【資料ダウンロード】　{$customer_name} 様より資料をダウンロードされました。";
	        $body = "
				差出人: {$customer_name} [{$customer_email}]<br>
				-- <br>
				本メールはあなたのウェブサイト (MUJIN 24 https://mujin24.com) の資料ダウンロードに送信があったことをお知らせするものです。<br>
				■ 企業名 <br>
				{$company_name}<br><br>

				■ 氏名<br>
				{$customer_fname} {$customer_name} <br>
				■ メールアドレス<br>
				{$customer_email}<br><br>

				■ 電話番号<br>
				{$customer_phone}<br><br>

				■ 弊社からの説明連絡を希望する<br>
				{$explanation_text}<br><br>

				■ ショールーム内覧を希望する<br>
				{$showroom_tour_text}<br><br>

				■ 会員規模<br>
				{$membership_size}<br><br>

				 ■ 現在運営状況<br>
				{$current_operation_status}<br><br>

	        ";
	        $mailer->sendMail($mail_to, $subject, $body);

	        // to user
	        $subject2 = "MUJIN24 資料ダウンロードありがとうございます";
	        $body2 = "
		        <div style='text-align: center;'>
			        <img src='https://mujin24.com/assets/images/mujin-img/mujin-logo-new.png' alt='Thanks' style='max-width: 100%; height: auto;'>
			    </div>
			    <br>
			    {$customer_name}様
			    <br><br>
	        	このたびは、資料をご請求いただき誠にありがとうございます。
	        	<br><br>
	        	以下リンクをクリックいただくと、資料をご覧いただけます。
	        	<br>
	        	ぜひお役立てください。
	        	<br><br>
	        	◾️製品資料
	        	<br>
	        	https://bit.ly/mujin24catalogue
	        	<br><br>
	        	◾️システム参考動画
	        	<br>
	        	https://m.youtube.com/shorts/ITTTAql3jqE
	        	<br><br>
	        	※通信環境のよい場所でご覧ください
	        	<br><br>
	        	本メールは自動送信にてお送りしております。
	        	<br>
	        	このメールにご返信いただいてもご対応いたしかねますので、あらかじめご了承ください。
	        	<br><br>
	        	ご不明点や追加のご要望がございましたら、下記までお気軽にご連絡ください。
	        	<br>
	        	sales@mujin24.com
	        	<br>
	        	今後ともどうぞよろしくお願い申し上げます。
	        	<br><br>
	            ――――――――――――――――――――――――――――――<br>
	            株式会社GPRO <br>
				兵庫県尼崎市南塚口町5-14-12 <br>
				06-6430-5111 <br>
				（月～金 9:30～17:30 / 土日祝除く <br>
				 sales@mujin24.com <br>
				 www.gpro.co.jp <br>
	            ――――――――――――――――――――――――――――――<br>
	            <br><br>
	            ご入力いただいた内容は下記の通りです。
	            <br>
	            ⸻
	            <br><br>
	            ■ 企業名 <br>
				{$company_name}<br><br>

				■ 氏名<br>
				{$customer_fname} {$customer_name} <br>
				■ メールアドレス<br>
				{$customer_email}<br><br>

				■ 電話番号<br>
				{$customer_phone}<br><br>

				■ 弊社からの説明連絡を希望する<br>
				{$explanation_text}<br><br>

				■ ショールーム内覧を希望する<br>
				{$showroom_tour_text}<br><br>

				■ 会員規模<br>
				{$membership_size}<br><br>

				 ■ 現在運営状況<br>
				{$current_operation_status}
				<br><br>
				-------------------------------


	        ";
	        $mailer->sendMail($customer_email, $subject2, $body2);

	        echo json_encode([
            'status' => 'success',
            //'redirect_url' => './salesprofile?token=' . $access_token
	        ]);
	        exit;
	    } else {
	        echo json_encode([
	            'status' => 'failed',
	            'error' => $stmt->error
	        ]);
	        exit;
	    }
	}

	function fetch_list_post() {
        $response = array(); // Mảng kết quả
        $sql = "SELECT id, title, text_content, before_issue, after_effect, used_features, ShopName, Address, Link, title_img, publish_date FROM posts ORDER BY id DESC LIMIT 6";

        $qry = $this->conn->query($sql);
        if($qry){
            while($row = $qry->fetch_assoc()){
                $response[] = $row;
            }
        } else {
            // Trường hợp lỗi SQL
            return json_encode([
                'status' => 'failed',
                'error' => $this->conn->error
            ]);
        }

        return json_encode([
            'status' => 'success',
            'data' => $response
        ]);
    }

	function fetch_post_by_id() {
	    $post_id = isset($_GET['post_id']) ? (int)$_GET['post_id'] : 0;

	    if ($post_id <= 0) {
	        return json_encode([
	            'status' => 'failed',
	            'error' => 'Invalid post_id'
	        ]);
	    }
	    // 1. Lấy thông tin bài viết
	    $sql_post = "SELECT id, title, text_content, before_issue, after_effect, used_features, 
	                        ShopName, Address, Link, title_img, publish_date 
	                 FROM posts 
	                 WHERE id = ?";
	    $stmt_post = $this->conn->prepare($sql_post);
	    if(!$stmt_post){
	        return json_encode([
	            'status' => 'failed',
	            'error' => 'Prepare failed: ' . $this->conn->error
	        ]);
	    }
	    $stmt_post->bind_param("i", $post_id);
	    if(!$stmt_post->execute()){
	        return json_encode([
	            'status' => 'failed',
	            'error' => 'Execute failed: ' . $stmt_post->error
	        ]);
	    }
	    $result_post = $stmt_post->get_result();
	    $post_data = $result_post->fetch_assoc();
	    $stmt_post->close();

	    if(!$post_data){
	        return json_encode([
	            'status' => 'failed',
	            'error' => 'Post not found'
	        ]);
	    }

	    // 2. Lấy danh sách sub_img
	    $sql_imgs = "SELECT file_name FROM post_images WHERE post_id = ?";
	    $stmt_imgs = $this->conn->prepare($sql_imgs);
	    if(!$stmt_imgs){
	        return json_encode([
	            'status' => 'failed',
	            'error' => 'Prepare failed (images): ' . $this->conn->error
	        ]);
	    }
	    $stmt_imgs->bind_param("i", $post_id);
	    if(!$stmt_imgs->execute()){
	        return json_encode([
	            'status' => 'failed',
	            'error' => 'Execute failed (images): ' . $stmt_imgs->error
	        ]);
	    }
	    $result_imgs = $stmt_imgs->get_result();
	    $sub_imgs = [];
	    while($row = $result_imgs->fetch_assoc()){
	        $sub_imgs[] = $row['file_name'];
	    }
	    $stmt_imgs->close();

	    // 3. Thêm mảng sub_img vào dữ liệu bài viết
	    $post_data['sub_img'] = $sub_imgs;

	    return json_encode([
	        'status' => 'success',
	        'data' => $post_data
	    ]);
	}

	function fetch_hp_bg_img() {
	    // 1. Truy vấn thông tin ảnh nền
	    $sql = "SELECT id, bg_lg_filename, bg_sm_filename, updated_at 
	            FROM HP_background_settings 
	            ORDER BY id DESC 
	            LIMIT 1";

	    $stmt = $this->conn->prepare($sql);
	    if (!$stmt) {
	        return json_encode([
	            'status' => 'failed',
	            'error' => 'Prepare failed: ' . $this->conn->error
	        ]);
	    }

	    if (!$stmt->execute()) {
	        return json_encode([
	            'status' => 'failed',
	            'error' => 'Execute failed: ' . $stmt->error
	        ]);
	    }

	    $result = $stmt->get_result();
	    $bg_data = $result->fetch_assoc();
	    $stmt->close();

	    if (!$bg_data) {
	        return json_encode([
	            'status' => 'failed',
	            'error' => 'No background data found'
	        ]);
	    }

	    // 2. Trả kết quả
	    return json_encode([
	        'status' => 'success',
	        'data' => $bg_data
	    ]);
	}

	function fetch_bg_video() {
        $response = array(); // Mảng kết quả
        $sql = "SELECT * FROM youtube_videos WHERE status = 1";

        $qry = $this->conn->query($sql);
        if($qry){
            while($row = $qry->fetch_assoc()){
                $response[] = $row;
            }
        } else {
            // Trường hợp lỗi SQL
            return json_encode([
                'status' => 'failed',
                'error' => $this->conn->error
            ]);
        }

        return json_encode([
            'status' => 'success',
            'data' => $response
        ]);
    }

    function fetch_list_news() {
        $response = array(); // Mảng kết quả
        $sql = "SELECT * FROM news ORDER BY id DESC";

        $qry = $this->conn->query($sql);
        if($qry){
            while($row = $qry->fetch_assoc()){
                $response[] = $row;
            }
        } else {
            // Trường hợp lỗi SQL
            return json_encode([
                'status' => 'failed',
                'error' => $this->conn->error
            ]);
        }

        return json_encode([
            'status' => 'success',
            'data' => $response
        ]);
    }

	function fetch_company_profile() {

	    // 1. Lấy thông tin bài viết
	    $sql_company_profile = "SELECT * FROM company_profile WHERE 1 LIMIT 1";
	    $stmt_company_profile = $this->conn->prepare($sql_company_profile);
	    if(!$stmt_company_profile){
	        return json_encode([
	            'status' => 'failed',
	            'error' => 'Prepare failed: ' . $this->conn->error
	        ]);
	    }
	    if(!$stmt_company_profile->execute()){
	        return json_encode([
	            'status' => 'failed',
	            'error' => 'Execute failed: ' . $stmt_company_profile->error
	        ]);
	    }
	    $result_company_profile = $stmt_company_profile->get_result();
	    $company_profile_data = $result_company_profile->fetch_assoc();
	    $stmt_company_profile->close();

	    if(!$company_profile_data){
	        return json_encode([
	            'status' => 'failed',
	            'error' => 'Data not found'
	        ]);
	    }

	    // 2. Lấy danh sách sub_img
	    $sql_imgs = "SELECT file_name FROM company_profile_images ORDER BY id DESC LIMIT 1";
	    $stmt_imgs = $this->conn->prepare($sql_imgs);
	    if(!$stmt_imgs){
	        return json_encode([
	            'status' => 'failed',
	            'error' => 'Prepare failed (images): ' . $this->conn->error
	        ]);
	    }
	    if(!$stmt_imgs->execute()){
	        return json_encode([
	            'status' => 'failed',
	            'error' => 'Execute failed (images): ' . $stmt_imgs->error
	        ]);
	    }
	    $result_imgs = $stmt_imgs->get_result();
	    $sub_imgs = [];
	    while($row = $result_imgs->fetch_assoc()){
	        $sub_imgs[] = $row['file_name'];
	    }
	    $stmt_imgs->close();

	    // 3. Thêm mảng sub_img vào dữ liệu bài viết
	    $company_profile_data['sub_img'] = $sub_imgs;

	    return json_encode([
	        'status' => 'success',
	        'data' => $company_profile_data
	    ]);
	}

	function fetch_company_profile_ver2() {

	    // 1) Lấy profile đầu tiên (chỉ có 1)
	    $sql = "SELECT * FROM company_profile_ver2 ORDER BY id ASC LIMIT 1";
	    $stmt = $this->conn->prepare($sql);

	    if (!$stmt) {
	        return json_encode([
	            "status" => "failed",
	            "error"  => "Prepare failed: " . $this->conn->error
	        ]);
	    }

	    if (!$stmt->execute()) {
	        return json_encode([
	            "status" => "failed",
	            "error"  => "Execute failed: " . $stmt->error
	        ]);
	    }

	    $profile = $stmt->get_result()->fetch_assoc();
	    $stmt->close();

	    if (!$profile) {
	        return json_encode([
	            "status" => "failed",
	            "error"  => "Profile not found"
	        ]);
	    }

	    $profile_id = $profile["id"];


	    // 2) Lấy list field động
	    $sql_fields = "
	        SELECT field_key, field_value, sort_order 
	        FROM company_profile_fields_ver2 
	        WHERE company_profile_id = ?
	        ORDER BY sort_order ASC
	    ";
	    $stmt_fields = $this->conn->prepare($sql_fields);
	    $stmt_fields->bind_param("i", $profile_id);
	    $stmt_fields->execute();
	    $result_fields = $stmt_fields->get_result();

	    $fields = [];
	    while ($row = $result_fields->fetch_assoc()) {
	        $fields[] = $row;
	    }
	    $stmt_fields->close();


	    // 3) Lấy sub images (nhiều ảnh)
	    $sql_imgs = "
	        SELECT file_name FROM company_profile_images_ver2 
	        WHERE company_profile_id = ?
	        ORDER BY id ASC
	    ";
	    $stmt_imgs = $this->conn->prepare($sql_imgs);
	    $stmt_imgs->bind_param("i", $profile_id);
	    $stmt_imgs->execute();
	    $result_imgs = $stmt_imgs->get_result();

	    $sub_imgs = [];
	    while ($row = $result_imgs->fetch_assoc()) {
	        $sub_imgs[] = $row["file_name"];
	    }
	    $stmt_imgs->close();


	    // 4) Gom data trả về
	    $profile["fields"] = $fields;
	    $profile["sub_images"] = $sub_imgs;

	    return json_encode([
	        "status" => "success",
	        "data"   => $profile
	    ]);
	}

	function fetch_logo_img() {
	    // 1. Truy vấn thông tin ảnh nền
	    $sql = "SELECT * 
	            FROM company_logo_settings 
	            ORDER BY id DESC 
	            LIMIT 1";

	    $stmt = $this->conn->prepare($sql);
	    if (!$stmt) {
	        return json_encode([
	            'status' => 'failed',
	            'error' => 'Prepare failed: ' . $this->conn->error
	        ]);
	    }

	    if (!$stmt->execute()) {
	        return json_encode([
	            'status' => 'failed',
	            'error' => 'Execute failed: ' . $stmt->error
	        ]);
	    }

	    $result = $stmt->get_result();
	    $bg_data = $result->fetch_assoc();
	    $stmt->close();

	    if (!$bg_data) {
	        return json_encode([
	            'status' => 'failed',
	            'error' => 'No data found'
	        ]);
	    }

	    // 2. Trả kết quả
	    return json_encode([
	        'status' => 'success',
	        'data' => $bg_data
	    ]);
	}

	function fetch_font_text() {

	    // 1. Lấy page_key từ GET
	    $page_key = $_GET['page_key'] ?? '';

	    if ($page_key === '') {
	        return json_encode([
	            'status' => 'failed',
	            'error'  => 'Missing page_key'
	        ]);
	    }

	    // 2. Query đúng page_key, lấy bản ghi mới nhất
	    $sql = "
	        SELECT *
	        FROM font_settings
	        WHERE page_key = ?
	        ORDER BY id DESC
	        LIMIT 1
	    ";

	    $stmt = $this->conn->prepare($sql);
	    if (!$stmt) {
	        return json_encode([
	            'status' => 'failed',
	            'error' => 'Prepare failed: ' . $this->conn->error
	        ]);
	    }

	    $stmt->bind_param("s", $page_key);

	    if (!$stmt->execute()) {
	        return json_encode([
	            'status' => 'failed',
	            'error' => 'Execute failed: ' . $stmt->error
	        ]);
	    }

	    $result = $stmt->get_result();
	    $font = $result->fetch_assoc();
	    $stmt->close();

	    if (!$font) {
	        return json_encode([
	            'status' => 'failed',
	            'error' => 'Font not found for page_key'
	        ]);
	    }

	    // 3. Trả dữ liệu
	    return json_encode([
	        'status' => 'success',
	        'data'   => $font
	    ]);
	}

	function fetch_projects_page_data() {
	    /* =============================
	       1. PROJECT SETTINGS
	    ============================== */
	    $sql = "SELECT *
	            FROM project_settings
	            ORDER BY id DESC
	            LIMIT 1";
	    $stmt = $this->conn->prepare($sql);
	    if (!$stmt) {
	        return json_encode([
	            'status' => 'failed',
	            'error'  => 'Prepare settings failed: ' . $this->conn->error
	        ]);
	    }
	    if (!$stmt->execute()) {
	        return json_encode([
	            'status' => 'failed',
	            'error'  => 'Execute settings failed: ' . $stmt->error
	        ]);
	    }
	    $settings = $stmt->get_result()->fetch_assoc();
	    $stmt->close();

	    if (!$settings) {
	        $settings = [
	            'top_bg_image' => null,
	            'footer_text'  => ''
	        ];
	    }

	    /* =============================
	       2. PROJECT CATEGORIES
	    ============================== */
	    $sql = "SELECT *
	            FROM project_categories
	            ORDER BY sort_order ASC";
	    $stmt = $this->conn->prepare($sql);
	    if (!$stmt) {
	        return json_encode([
	            'status' => 'failed',
	            'error'  => 'Prepare categories failed: ' . $this->conn->error
	        ]);
	    }
	    $stmt->execute();
	    $result = $stmt->get_result();

	    $categories = [];
	    while ($row = $result->fetch_assoc()) {
	        $row['items'] = [];
	        $categories[$row['id']] = $row;
	    }
	    $stmt->close();
	    if (empty($categories)) {
	        return json_encode([
	            'status' => 'failed',
	            'error'  => 'No categories found'
	        ]);
	    }

	    /* =============================
	       3. PROJECT ITEMS
	    ============================== */
	    $sql = "SELECT *
	            FROM project_items
	            ORDER BY sort_order ASC";

	    $stmt = $this->conn->prepare($sql);
	    if (!$stmt) {
	        return json_encode([
	            'status' => 'failed',
	            'error'  => 'Prepare items failed: ' . $this->conn->error
	        ]);
	    }
	    $stmt->execute();
	    $result = $stmt->get_result();
	    while ($item = $result->fetch_assoc()) {
	        if (isset($categories[$item['category_id']])) {
	            $categories[$item['category_id']]['items'][] = $item;
	        }
	    }
	    $stmt->close();

	    /* =============================
	       4. RETURN JSON
	    ============================== */
	    return json_encode([
	        'status' => 'success',
	        'data' => [
	            'settings'   => $settings,
	            'categories' => array_values($categories)
	        ]
	    ]);
	}


}


$Master = new Master();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$sysset = new SystemSettings();

switch ($action) {
	case 'save_contact':
		echo $Master->save_contact();
	break;
	case 'download_materials_form':
		echo $Master->download_materials_form();
	break;
	case 'fetch_list_post':
		echo $Master->fetch_list_post();
	break;
	case 'fetch_post_by_id':
		echo $Master->fetch_post_by_id();
	break;
	case 'fetch_hp_bg_img':
		echo $Master->fetch_hp_bg_img();
	break;
	case 'fetch_bg_video':
		echo $Master->fetch_bg_video();
	break;
	case 'fetch_list_news':
		echo $Master->fetch_list_news();
	break;
	case 'fetch_company_profile':
		echo $Master->fetch_company_profile();
	break;
	case 'fetch_company_profile_ver2':
		echo $Master->fetch_company_profile_ver2();
	break;
	case 'fetch_logo_img':
		echo $Master->fetch_logo_img();
	break;
	case 'fetch_font_text':
		echo $Master->fetch_font_text();
	break;
	case 'fetch_projects_page_data':
		echo $Master->fetch_projects_page_data();
	break;
	
	default:
		echo $Master->index();
		break;
}