<?php

namespace Drupal\login_tfa\Service;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\Core\Messenger\MessengerInterface;

class EmailHelper {

    const SMTP_HOST = 'smtp.gmail.com'; // Change this if using another provider
    const SMTP_PORT = 587;
    const SMTP_USERNAME = 'phamhoangthong@kng.vn'; // Use your email
    const SMTP_PASSWORD = 'lmpr wjrk ssim fvuo'; // Use App Password
    const SMTP_FROM_EMAIL = 'phamhoangthong@kng.vn';
    const SMTP_FROM_NAME = 'Admin';

    protected $logger;
    protected $messenger;

    public function __construct(LoggerChannelFactoryInterface $logger_factory, MessengerInterface $messenger) {
        $this->logger = $logger_factory->get('login_tfa');
        $this->messenger = $messenger;
    }

    public function sendEmail($to, $subject, $message) {
        $mail = new PHPMailer(true);

        try {
            // SMTP Configuration
            $mail->isSMTP();
            $mail->Host = self::SMTP_HOST;
            $mail->SMTPAuth = true;
            $mail->Username = self::SMTP_USERNAME;
            $mail->Password = self::SMTP_PASSWORD;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = self::SMTP_PORT;

            // Email headers
            $mail->setFrom(self::SMTP_FROM_EMAIL, self::SMTP_FROM_NAME);
            $mail->addAddress($to);
            $mail->Subject = $subject;
            $mail->isHTML();
            $mail->Body = $message;

            // Send email
            if ($mail->send()) {
                $this->logger->notice('Email sent successfully to %to.', ['%to' => $to]);
                $this->messenger->addStatus(t('Email sent successfully to %to.', ['%to' => $to]));
                return TRUE;
            } else {
                $this->logger->error('Email failed to %to: %error', ['%to' => $to, '%error' => $mail->ErrorInfo]);
                $this->messenger->addError(t('Email sending failed.'));
                return FALSE;
            }
        } catch (Exception $e) {
            $this->logger->error('SMTP Error: %error', ['%error' => $mail->ErrorInfo]);
            return FALSE;
        }
    }
}
