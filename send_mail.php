<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

header('Content-Type: text/html; charset=utf-8'); // Встановлення кодування на рівні PHP

$mail = new PHPMailer(true);

try {
    // Налаштування сервера
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'cumunzimcraft@gmail.com';
    $mail->Password = 'eckh fkod tpxg kvja';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Отримувачі
    $mail->setFrom('cumunzimcraft@gmail.com', 'да да да');
    $mail->addAddress('pasha.blenov@gmail.com', 'Recipient Name');

    // Вміст
    $mail->isHTML(true);
    $mail->CharSet = 'UTF-8'; // Встановлення кодування UTF-8
    $mail->Encoding = 'base64'; // Встановлення кодування Base64
    $mail->Subject = '=?UTF-8?B?' . base64_encode('Тема листа на русском') . '?='; // Кодування теми
    $mail->Body = '=?UTF-8?B?' . base64_encode('Это тело письма на русском языке <b>жирным шрифтом</b>!') . '?='; // Кодування тіла
    $mail->AltBody = '=?UTF-8?B?' . base64_encode('Это тело письма на русском языке без HTML.') . '?='; // Кодування AltBody

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>