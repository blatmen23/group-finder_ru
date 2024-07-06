<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function send_mail(array $mail_settings, string $to, string $subject, string $body)
{
    $mail = new PHPMailer(true);

    try {
        $mail->SMTPDebug = $mail_settings['debug'];
        $mail->isSMTP();

        $mail->Host       = $mail_settings['host'];
        $mail->SMTPAuth   = $mail_settings['auth'];
        $mail->Username   = $mail_settings['username'];
        $mail->Password   = $mail_settings['password'];
        $mail->SMTPSecure = $mail_settings['secure'];
        $mail->Port       = $mail_settings['port'];
        $mail->CharSet    = $mail_settings['charset'];

        $mail->setFrom($mail_settings['from_email'], $mail_settings['from_name']);
        $mail->addAddress($to);

        $mail->isHTML($mail_settings['is_html']);
        $mail->Subject = $subject;
        $mail->Body = $body;

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}