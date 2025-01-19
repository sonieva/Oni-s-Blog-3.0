<?php

namespace Utils;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailService {
  private PHPMailer $mailer;

  public function __construct() {
    $this->mailer = new PHPMailer(true);

    // Configuración básica del servidor SMTP
    $this->mailer->isSMTP();
    $this->mailer->Host = $_ENV['MAIL_HOST'];
    $this->mailer->SMTPAuth = true;
    $this->mailer->Username = $_ENV['MAIL_USERNAME'];
    $this->mailer->Password = $_ENV['MAIL_PASSWORD'];
    $this->mailer->SMTPSecure = $_ENV['MAIL_ENCRYPTION']; // tls o ssl
    $this->mailer->Port = $_ENV['MAIL_PORT'];

    // Configuración del remitente
    $this->mailer->setFrom($_ENV['MAIL_FROM_ADDRESS'], $_ENV['MAIL_FROM_NAME']);
  }

  // Método para enviar correos
  public function send(string $to, string $subject, string $body): bool {
    try {
        $this->mailer->clearAddresses();
        $this->mailer->addAddress($to);
        $this->mailer->isHTML(true);
        $this->mailer->Subject = $subject;
        $this->mailer->Body = $body;

        return $this->mailer->send();
    } catch (Exception $e) {
        error_log("Error al enviar el correo: " . $this->mailer->ErrorInfo);
        return false;
    }
  }
}
