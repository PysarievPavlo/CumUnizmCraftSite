<?php
require_once 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $mail = $_POST["mail"];

    if ($password !== $confirm_password) {
        echo "<div class='container'><p class='alert alert-danger'>Пароли не совпадают!</p></div>";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (username, password, mail) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $username, $hashed_password, $mail);

        if ($stmt->execute()) {
            echo "<div class='container'><p class='alert alert-success'>Регистрация успешна! <a href='index.php'>Перейти на главную</a></p></div>";
        } else {
            echo "<div class='container'><p class='alert alert-danger'>Ошибка: " . $stmt->error . "</p></div>";
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Регистрация</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .login-form {
            width: 500px;
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

        .login-form input[type="text"],
        .login-form input[type="password"],
        .login-form input[type="email"] {
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
        <h2 class="text-center">Регистрация</h2>
        <form method="post">
            <input type="text" name="username" id="username" placeholder="Имя пользователя" class="form-control" required>
            <input type="password" name="password" id="password" placeholder="Пароль" class="form-control" required>
            <input type="password" name="confirm_password" id="confirm_password" placeholder="Повторите пароль" class="form-control" required>
            <input type="email" name="mail" id="mail" placeholder="Электронная почта" class="form-control">
            <button type="submit" class="btn btn-primary btn-block">Зарегистрироваться</button>
        </form>
        <a href="index.php" class="btn btn-link btn-block">Войти</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>