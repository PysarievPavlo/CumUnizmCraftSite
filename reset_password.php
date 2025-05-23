<?php
require_once 'db_connect.php';

if (isset($_GET["token"])) {
    $token = $_GET["token"];

    // Перевірка, чи існує токен в базі даних
    $sql = "SELECT * FROM users WHERE reset_token = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $username = $row["username"];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $password = $_POST["password"];
            $confirm_password = $_POST["confirm_password"];

            if ($password !== $confirm_password) {
                echo "<div class='container'><p class='alert alert-danger'>Пароли не совпадают!</p></div>";
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Оновлення пароля та видалення токена
                $sql = "UPDATE users SET password = ?, reset_token = NULL WHERE username = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ss", $hashed_password, $username);
                $stmt->execute();

                echo "<div class='container'><p class='alert alert-success'>Пароль успешно изменен! <a href='index.php'>Войти</a></p></div>";
            }

            $stmt->close();
        }
    } else {
        echo "<div class='container'><p class='alert alert-danger'>Неверный токен.</p></div>";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Восстановление пароля</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .login-form {
            width: 300px;
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

        .login-form input[type="password"] {
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
            <input type="password" name="password" id="password" placeholder="Новый пароль" class="form-control" required>
            <input type="password" name="confirm_password" id="confirm_password" placeholder="Повторите пароль" class="form-control" required>
            <button type="submit" class="btn btn-primary btn-block">Сменить пароль</button>
        </form>
        <a href="index.php" class="btn btn-link btn-block">Войти</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>