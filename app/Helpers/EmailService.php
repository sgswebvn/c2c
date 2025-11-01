<?php

namespace App\Helpers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailService
{
    private $mailer;
    
    public function __construct()
    {
        $this->mailer = new PHPMailer(true);
        
        // Cấu hình SMTP từ .env
        $this->mailer->isSMTP();
        $this->mailer->Host = 'smtp.gmail.com';
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = $_ENV['SMTP_USER'];
        $this->mailer->Password = $_ENV['SMTP_PASS'];
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $this->mailer->Port = 465;
        $this->mailer->CharSet = 'UTF-8';
        $this->mailer->setFrom($_ENV['SMTP_NAME'], 'Hệ thống quản lý');
    }
    
    public function sendActivationEmail($to, $username, $isActive)
    {
        try {
            $this->mailer->addAddress($to);
            $this->mailer->isHTML(true);
            $this->mailer->Subject = $isActive === 0 ? 'Tài khoản của bạn đã được kích hoạt' : 'Tài khoản của bạn đã bị tạm khóa';
            
            $statusText = $isActive === 0 ? 'kích hoạt' : 'tạm khóa';
            $this->mailer->Body = "
                <h2>Thông báo trạng thái tài khoản</h2>
                <p>Xin chào {$username},</p>
                <p>Tài khoản của bạn đã được <strong>{$statusText}</strong> bởi quản trị viên.</p>
                <p>Nếu bạn có bất kỳ câu hỏi nào, vui lòng liên hệ với chúng tôi.</p>
                <p>Trân trọng,<br>Hệ thống quản lý</p>
            ";
            
            $this->mailer->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
?>