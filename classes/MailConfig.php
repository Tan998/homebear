<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php'; // Đảm bảo đường dẫn chính xác

class Mailer {
    private $mail;

    public function __construct() {
        $this->mail = new PHPMailer(true);

        try {
            // Cấu hình SMTP
            $this->mail->isSMTP();
            $this->mail->Host = 'mail90.conoha.ne.jp'; //smtp.gmail.com
            $this->mail->SMTPAuth = true;
            $this->mail->Username = 'golf@gp311.conohawing.com'; // Thay bằng email Gmail của bạn tanclone0001@gmail.com
            $this->mail->Password = 'smtp-7777'; // Thay bằng mật khẩu ứng dụng Gmail sqgw addt aric uklf
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $this->mail->Port = 587; //587

            // Cấu hình mặc định cho email
            $this->mail->setFrom('sales@mujin24.com', 'Mujin 24'); //tanclone0001@gmail.com
            $this->mail->isHTML(true);
            $this->mail->CharSet = 'UTF-8';

        } catch (Exception $e) {
            die("Mail error: " . $e->getMessage());
        }
    }

    /*public function sendMail($to, $subject, $body) {
        try {
            $this->mail->clearAddresses();
            $this->mail->addAddress($to);
            $this->mail->Subject = $subject;
            $this->mail->Body = $body;

            return $this->mail->send();
        } catch (Exception $e) {
            return "メールが送信されませんでした： " . $this->mail->ErrorInfo;
        }
    }*/
    public function sendMail($to, $subject, $body) {
        try {
            $this->mail->clearAddresses();
            $this->mail->addAddress($to);
            $this->mail->Subject = $subject;
            $this->mail->Body = $body;

            /*// ⚠️ Bật debug
            $this->mail->SMTPDebug = 2; // 2 = Debug chi tiết
            $this->mail->Debugoutput = 'html'; // hiển thị log dưới dạng HTML*/

            return $this->mail->send();
        } catch (Exception $e) {
            return "メールが送信されませんでした： " . $this->mail->ErrorInfo;
        }
    }
}

/*
Sử dụng class Mailer trong project:

$mailer = new Mailer();
$result = $mailer->sendMail('receiver@example.com', 'Tiêu đề Email', 'Nội dung email');

echo $result ? 'Gửi thành công' : 'Gửi thất bại';
*/
?>