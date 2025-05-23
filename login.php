<?php
session_start();
require_once 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["password"])) {
            $_SESSION["username"] = $username;
            echo json_encode(['success' => true]); // Возвращаем JSON при успешной авторизации
        } else {
            echo json_encode(['success' => false, 'message' => 'Неправильный пароль']); // Возвращаем JSON при ошибке
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Пользователь не найден']); // Возвращаем JSON при ошибке
    }

    $stmt->close();
}

$conn->close();
?>