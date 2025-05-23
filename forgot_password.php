<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
require_once 'db_connect.php';

header('Content-Type: text/html; charset=utf-8');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];

    $sql_mail = "SELECT mail FROM users WHERE username = ?";
    $stmt_mail = $conn->prepare($sql_mail);
    $stmt_mail->bind_param("s", $username);
    $stmt_mail->execute();
    $result_mail = $stmt_mail->get_result();

    if ($result_mail->num_rows > 0) {
        $row_mail = $result_mail->fetch_assoc();
        $user_mail = $row_mail["mail"];

        if (!empty($user_mail)) {
            $token = bin2hex(random_bytes(32));

            $sql = "UPDATE users SET reset_token = ? WHERE username = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $token, $username);
            $stmt->execute();

            $reset_link = "http://cumunizmcraft.pp.ua/reset_password.php?token=" . $token;

            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'cumunzimcraft@gmail.com';
                $mail->Password = 'eckh fkod tpxg kvja';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('cumunzimcraft@gmail.com', 'Відновлення пароля');
                $mail->addAddress($user_mail);

                $mail->isHTML(true);
                $mail->CharSet = 'UTF-8';
                $mail->Encoding = 'quoted-printable'; // Зміна кодування
                $mail->Subject = 'Відновлення пароля';
                $mail->Body = 'Перейдіть за посиланням, щоб відновити пароль: <a href="' . $reset_link . '">' . $reset_link . '</a>';
                $mail->AltBody = 'Перейдіть за посиланням, щоб відновити пароль: ' . $reset_link;

                $mail->send();
                echo "<div class='container'><p class='alert alert-success'>Посилання для відновлення пароля відправлено на вашу пошту.</p></div>";
            } catch (Exception $e) {
                echo "<div class='container'><p class='alert alert-danger'>Помилка відправлення листа: {$mail->ErrorInfo}</p></div>";
            }
        } else {
            echo "<div class='container'><p class='alert alert-danger'>У користувача не вказана електронна пошта.</p></div>";
        }
    } else {
        echo "<div class='container'><p class='alert alert-danger'>Користувач з таким ім'ям не знайдений.</p></div>";
    }

    $stmt_mail->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head meta charset="UTF-8">
    <title>Забыли пароль</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .login-form {
            width: 350px;
            margin: 100px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .login-form .form-control {
            margin-bottom: 10px;
        }

        .login-form .btn {
            margin-bottom: 5px;
        }

        .login-form input[type="text"] {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
        }

        .login-form .btn-block {
            display: block;
        }
    </style>
</head>
<body>
    <div class="container login-form">
        <h2 class="text-center">Восстановление пароля</h2>
        <form method="post">
            <input type="text" name="username" id="username" placeholder="Имя пользователя" class="form-control" required>
            <button type="submit" class="btn btn-primary btn-block">Отправить ссылку</button>
        </form>
        <a href="index.php" class="btn btn-link btn-block">Войти</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA